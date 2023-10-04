<?php
    use App\Models\Notifications; 
    use Illuminate\Support\Facades\DB;
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
                    ->where('notifications.booked_by',$user->id)->limit('5')
                    ->whereDate('notifications.created_at', now())
                    ->leftJoin('users','users.id','=','notifications.notifier_id')
                    ->get();
                                
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
        <a href="@if(Auth::check()){{ route('client') }}@else{{ route('/') }}@endif" class="navbar-brand ml-lg-3">
            <h1 class="m-0 text-primary"><span class="text-dark">SPA</span> Center</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
            <div class="navbar-nav m-auto py-0">
                @if(Auth::check())  
                    <a href="{{ route('client') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'client' ? 'active' : '' }}">Spa</a>
                    <a href="{{ route('services') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'services' ? 'active' : '' }}">Services</a>
                    <a href="{{ route('therapist') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'therapist' ? 'active' : '' }}">Therapist</a>
                    <a href="{{ route('booking') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'booking' ? 'active' : '' }}">Booking</a>
                    <a href="{{ route('booking.history') }}" class="nav-item nav-link {{ Route::currentRouteName() == 'booking.history' ? 'active' : '' }}">Booking History</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            Notifications
                            <span class="badge badge-notification">{{ count($notifications) }}</span> <!-- Display the number of unread notifications -->
                        </a>
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
                                                <div class="col-md-4" style="padding: 0; padding-top:10px;">
                                                    <p><small class="text-info">{{ $notification->time_ago }}</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div style="text-align: center;">
                                <a href="{{ route('booking.history') }}">View All</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if(Auth::check())
            <div class="nav-item dropdown" style="float:right;">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ $user->fname.' '.$user->lname }}</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <a href="#" class="dropdown-item">Profile</a>
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