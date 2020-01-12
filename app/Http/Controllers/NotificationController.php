<?php

namespace App\Http\Controllers;

use App\Http\Requests\PushSubscribe;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Show all the notifications
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return view('notifications.index', [
            'notifications' => auth()->user()->notifications()->paginate(10)
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => Carbon::now()]);
        return redirect()->back()->with('app_message', 'All notifications marked as read');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Request $request)
    {
        $id = $request->get('id');
        auth()->user()->unreadNotifications()->where('id', $id)->update(['read_at' => Carbon::now()]);
        return response()->json([
            'message' => 'mark as read',
            'status' => true
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pushSubscribe(PushSubscribe $request)
    {
        try {
            $user = auth()->user();
            $keys = $request->get('keys');
            $auth = $keys['auth'] ?? null;
            $p256h = $keys['p256dh'] ?? null;
            $user->updatePushSubscription($request->get('endpoint'), $p256h, $auth);
            return response()->json([
                'success' => true,
                'message' => 'Thanks for subscribing'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unsubscribe(Request $request)
    {
        try {
            $user = auth()->user();
            $user->pushSubscriptions()->delete();
            return redirect()->back()->with('app_message', 'Successfully unsubscribed');
        } catch (\Exception $e) {
            return redirect()->back()->with('app_error', $e->getMessage());
        }
    }
}