@extends('layouts.app')
@section('header')
    <h5 class="text-muted font-weight-semibold"><i class="material-icons">notifications</i> My Notifications</h5>
@endsection
@section('tools')

@endsection

@section('content')
    <div class="row p-2">
        <div class="col-sm-5"><h3>Notifications</h3></div>
        <div class="col-sm-7 text-right">
            <a class="text-primary lead"
               href="{{route('notifications.markAllRead')}}">
                <i class="fa fa-check-circle"> </i> Mark all as read
            </a>

            @if(auth()->user()->pushSubscriptions()->count()>0)
                <a href="{{route('notifications.pushUnsubscribe')}}"
                   title="You will no longer receive Push Messages" class="btn btn-warning"
                ><i class="fa fa-sign-out"></i> Unsubscribe To Push Notification
                </a>
            @else
                <button data-toggle="tooltip"
                        title="We will notify important events via Push Message. You can see messages even when you are not on our site."
                        class="btn btn-primary pushMessageBtn" onclick="subscribeUserToPush()"><i
                            class="fa fa-sign-in"></i> Subscribe to Push
                    Notification
                </button>
            @endif


        </div>
    </div>


    <table class="table table-hover">
        <tbody>
        @foreach($notifications as $notify)
            <tr class="border-bottom {{!empty($notify->read_at)?'bg-light':''}}">
                <td>
                    <a data-id="{{$notify->id}}" data-read_at="{{$notify->read_at}}" class="notificationLink"
                       href="{{$notify->data['link'] ?? '#'}}">
                        <p class="m-0 p-0">
                            <i class="{{$notify->data['icon']??'fa fa-bell'}}"></i>
                            @if(isset($notify->data['message']))
                                {!! $notify->data['message'] !!}
                            @else
                                N/A
                            @endif
                            <strong class="pull-right">{{$notify->created_at->diffForHumans()}}</strong>
                        </p>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if($notifications->count()<1)
        <div class="m-0  px-4 p-1 alert alert-warning">No notification found</div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            {!! $notifications->render() !!}
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (e) {
            if (!('PushManager' in window) || !('serviceWorker' in navigator)) {
                $(".pushMessageBtn").remove();
            }

            var link = '{{route('notifications.read')}}';
            $(".notificationLink").on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var read_at = $(this).data('read_at');
                if (read_at.length < 2) {
                    $.get(link + '?id=' + id).then(function (resp) {
                    });
                }
                window.location.href = $(this).attr('href');
            });
        });

        function subscribeUserToPush() {
            if (!('PushManager' in window) || !('serviceWorker' in navigator)) {
                return;
            }
            return navigator.serviceWorker.ready
                .then(function (registration) {
                    const subscribeOptions = {
                        userVisibleOnly: true,
                        applicationServerKey: urlB64ToUint8Array(
                            '{{config('services.vapid_public_key')}}'
                        )
                    };
                    return registration.pushManager.subscribe(subscribeOptions);
                })
                .then(function (pushSubscription) {
                    pushSubscribe(pushSubscription);
                    return pushSubscription;
                });
        }


        function urlB64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');
            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);
            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }


        function pushSubscribe(pushSubscription) {
            var subscriptionObject = JSON.stringify(pushSubscription);
            subscriptionObject = $.parseJSON(subscriptionObject)
            var queryString = "?endpoint=" + pushSubscription.endpoint + "&keys[auth]=" + subscriptionObject.keys.auth + "&keys[p256dh]=" + subscriptionObject.keys.p256dh;
            var url = '{{route('notifications.pushSubscribe')}}' + queryString;
            $.get(url).then(function (response) {
                window.location.reload();
            });
        }

    </script>
@endsection