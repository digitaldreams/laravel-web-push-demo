@extends('layouts.app')
@section('header')
    <h5 class="text-muted font-weight-semibold"><i class="material-icons">notifications</i> My Notifications</h5>
@endsection
@section('tools')

@endsection

@section('content')
    <div class="row p-2">
        <div class="col-sm-8"><h3>Notifications</h3></div>
        <div class="col-sm-4 text-right">
            <a class="text-primary lead"
               href="{{route('notifications.markAllRead')}}">
               <i class="fa fa-check-circle"> </i> Mark all as read
            </a>
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
    </script>
@endsection