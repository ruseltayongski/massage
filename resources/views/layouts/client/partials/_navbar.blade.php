<?php
    use App\Models\Notifications;
    use Illuminate\Support\Facades\DB;
    $notification = [];
    if(isset($user->id)) {
        $notifications = Notifications::
                    select(
                        DB::raw("concat(users.fname,' ',users.lname,' ',LOWER(notifications.message)) as message"),
                        'users.picture as notifier_picture',
                        DB::raw("CASE
                            WHEN TIMESTAMPDIFF(SECOND, notifications.created_at, NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(SECOND, notifications.created_at, NOW()), ' seconds ago')
                            WHEN TIMESTAMPDIFF(MINUTE, notifications.created_at, NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(MINUTE, notifications.created_at, NOW()), ' minutes ago')
                            WHEN TIMESTAMPDIFF(HOUR, notifications.created_at, NOW()) < 24 THEN CONCAT(TIMESTAMPDIFF(HOUR, notifications.created_at, NOW()), ' hours ago')
                            WHEN TIMESTAMPDIFF(DAY, notifications.created_at, NOW()) < 7 THEN CONCAT(TIMESTAMPDIFF(DAY, notifications.created_at, NOW()), ' days ago')
                            WHEN TIMESTAMPDIFF(MONTH, notifications.created_at, NOW()) < 12 THEN CONCAT(TIMESTAMPDIFF(MONTH, notifications.created_at, NOW()), ' months ago')
                            ELSE CONCAT(TIMESTAMPDIFF(YEAR, notifications.created_at, NOW()), ' years ago')
                        END AS time_ago")
                    )
                    ->whereNotNull('notifications.booking_id')
                    ->where('notifications.booked_by',$user->id)
                    ->where('notifications.notifier_id','!=',$user->id)
                    ->where(function($query) {
                        $query->where('notifications.message','like','%approved%');
                        $query->orWhere('notifications.message','like','%rejected%');
                        $query->orWhere('notifications.message','like','%completed%');
                        $query->orWhere('notifications.message','like','%pending%');
                    })
                    ->whereDate('notifications.created_at', now())
                    ->leftJoin('bookings','bookings.id','=','notifications.booking_id')
                    ->leftJoin('users','users.id','=','notifications.notifier_id')
                    ->orderBy('notifications.id','desc')
                    ->limit('5')
                    ->get();
    }
?>
<style>
    /* Style the notification badge nagamit*/
    .badge-notification {
        background-color: #ff6347; /* Red color for notifications */
        font-size: 14px;
        margin-left: 5px;
        border-radius: 50%;
        padding: 5px 8px;
        color: white;
    }

    /* Style the dropdown menu nagamit*/
    .dropdown-menu.notifications {
        max-height: 300px; /* Limit the height if there are many notifications */
        width: 300px;
        min-width: 100%;
    }

    /* Style for the notification content gamit*/
    .notification-ui_dd-content {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        padding: 10px;
        margin-bottom: 10px;
    }

    /* Style for the user's name gamit*/
    .notification-list_detail b {
        color: #333;
        font-weight: bold;
    }

    /* Style for the reaction icon gamit*/
    .notification-list_detail i {
        color: #007bff;
        margin-right: 5px;
    }

    /* Style for the timestamp gamit*/
    .notification-list_detail small {
        color: #888;
        font-size: 12px;
    }

    .flex-row {
        display: flex;
        align-items: center;
    }

    .img-notification {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        margin-top:10px;
        margin-left:10px;
    }
</style>

<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
        <a href="@if(Auth::check()){{ route('client.dashboard') }}@else{{ route('/') }}@endif" class="navbar-brand ml-lg-3">
            <h1 class="m-0 text-primary"><span class="text-dark">Massage</span> Sent</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
            <div class="navbar-nav m-auto py-0">
                @if(Auth::check())
                    <a href="{{ route('client.dashboard') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.dashboard' ? 'active' : '' }}">Spa</a>
                    <a href="{{ route('client.services') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.services' ? 'active' : '' }}">Services</a>
                    <a href="{{ route('client.therapist') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.therapist' ? 'active' : '' }}">Therapist</a>
                    {{-- <a href="{{ route('client.booking') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.booking' ? 'active' : '' }}">Booking</a>
                    <a href="{{ route('client.booking.history') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.booking.history' ? 'active' : '' }}">History</a> --}}
                    {{-- <a href="{{ route('client.rate.spa') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.rate.spa' ? 'active' : '' }}">Rate Spa</a>
                    <a href="{{ route('client.rate.therapist') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.rate.therapist' ? 'active' : '' }}">Rate Therapist</a> --}}
                    <div class="nav-item dropdown" style="cursor: pointer;">
                        <a href="#" class="nav-link dropdown-toggle {{ Route::currentRouteName() == 'client.booking' || Route::currentRouteName() == 'client.booking.history' ? 'active' : '' }}" data-toggle="dropdown">Booking</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="{{ route('client.booking') }}" class="dropdown-item {{ Route::currentRouteName() == 'client.booking' ? 'active' : '' }}">Create</a>
                            <a href="{{ route('client.booking.history') }}" class="dropdown-item {{ Route::currentRouteName() == 'client.booking.history' ? 'active' : '' }}">History</a>
                        </div>
                    </div>
                    <a href="{{ route('client.testimonial') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client.testimonial' ? 'active' : '' }}">Testimonial</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            Notifications
                            <span class="badge badge-notification">{{ count($notifications) }}</span> <!-- Display the number of unread notifications -->
                        </a>
                        @if(count($notifications) > 0)
                            <div class="dropdown-menu notifications rounded-0 m-0">
                                @foreach($notifications as $notification)
                                    <div class="notification-ui_dd-content">
                                        <div class="notification-list notification-list--unread">
                                            <div class="notification-list_detail">
                                                <div class="row">
                                                    <div class="col-md-2" style="padding: 0;">
                                                        <img src="{{ asset('fileupload/therapist/profile').'/'.$notification->notifier_picture }}" class="img-notification" alt="user">
                                                    </div>
                                                    <div class="col-md-6" style="padding: 0;padding-left:5px;">
                                                        <p><small>{{ $notification->message }}</small></p>
                                                    </div>
                                                    <div class="col-md-4" style="padding: 0; padding-top:5px;">
                                                        <p><small class="text-info">{{ $notification->time_ago }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div style="text-align: center;">
                                    <a href="{{ route('client.booking.history') }}">View All</a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @if(Auth::check())
            <div class="nav-item dropdown ml-auto">
                {{-- <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="font-size: 9pt;">{{ $user->fname.' '.$user->lname }}</a> --}}
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" >{{ $user->fname.' '.$user->lname }}</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <a href="{{ route('client.profile') }}" class="dropdown-item">Profile</a>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary d-none d-lg-block">Login</a>
        @endif
    </nav>
</div>
<!-- Navbar End -->
@section('js')
<script>
$(document).ready(function() {
    $(".nav-item.dropdown").hover(
        function() {
            event.preventDefault();
            console.log("hahaha");
        },
        function() {
            event.preventDefault();
            console.log("hehhehe");
        }
    );
});
</script>
@endsection