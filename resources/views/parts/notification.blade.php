@php
$user = \App\Models\User::find(auth()->id())
@endphp
<div id="notifications">

    @foreach($user->notifications as $notification)
        <div class="alert {{$notification->read_at  ? 'alert-warning' : 'alert-success' }} m-3" role="alert">
            <h5>{{$notification->data['title']}}</h5>
            <p>{{$notification->data['message']}}</p>
        </div>
        {{$user->unreadNotifications->markAsRead()}}
    @endforeach

</div>
