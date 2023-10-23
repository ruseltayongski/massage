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
                    ->where('bookings.therapist_id',$user->id)
                    ->where('bookings.status','!=','Approved')
                    ->where('bookings.status','!=','Rejected')
                    ->whereDate('notifications.created_at', now())
                    ->leftJoin('bookings','bookings.id','=','notifications.booking_id')
                    ->leftJoin('users','users.id','=','notifications.notifier_id')
                    ->orderBy('bookings.id','desc')
                    ->limit('5')
                    ->get();
    }
?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.html"><img src="{{ asset('admin/images/logo.svg') }}" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('admin/images/logo-mini.svg') }}" alt="logo"/></a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button" data-toggle="minimize">
        <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
            {{-- <li class="nav-item  d-none d-lg-flex">
                <a class="nav-link" href="#">
                Calendar
                </a>
            </li>
            <li class="nav-item  d-none d-lg-flex">
                <a class="nav-link active" href="#">
                Statistic
                </a>
            </li>
            <li class="nav-item  d-none d-lg-flex">
                <a class="nav-link" href="#">
                Employee
                </a>
            </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-flex  mr-2">
                <a class="nav-link" href="#">
                Help
                </a>
            </li> --}}
            <li class="nav-item dropdown d-flex">
                <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                <i class="typcn typcn-bell"></i>
                <span class="count bg-success">{{ count($notifications) }}</span>
                </a>
                @if(count($notifications) > 0)
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                        @foreach($notifications as $notification)
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="{{ asset('fileupload/client/profile').'/'.$notification->notifier_picture }}" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis font-weight-normal">{{ $notification->time_ago }}
                                    </h6>
                                    <p class="font-weight-light small-text mb-0">
                                       {{ $notification->message }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                        {{-- <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                            <img src="{{ asset('admin/images/faces/face2.jpg') }}" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                            </h6>
                            <p class="font-weight-light small-text mb-0">
                                New product launch
                            </p>
                            </div>
                        </a>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                            <img src="{{ asset('admin/images/faces/face3.jpg') }}" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                            </h6>
                            <p class="font-weight-light small-text mb-0">
                                Upcoming board meeting
                            </p>
                            </div>
                        </a> --}}
                    </div>
                @endif
            </li>
            {{-- <li class="nav-item dropdown  d-flex">
                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="typcn typcn-bell mr-0"></i>
                <span class="count bg-danger">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                        <i class="typcn typcn-info-large mx-0"></i>
                    </div>
                    </div>
                    <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                    <p class="font-weight-light small-text mb-0">
                        Just now
                    </p>
                    </div>
                </a>
                <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                        <i class="typcn typcn-cog mx-0"></i>
                    </div>
                    </div>
                    <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                    <p class="font-weight-light small-text mb-0">
                        Private message
                    </p>
                    </div>
                </a>
                <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                        <i class="typcn typcn-user-outline mx-0"></i>
                    </div>
                    </div>
                    <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                    <p class="font-weight-light small-text mb-0">
                        2 days ago
                    </p>
                    </div>
                </a>
                </div>
            </li> --}}
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
                    <i class="typcn typcn-user-outline mr-0"></i>
                    <span class="nav-profile-name">{{ Auth::user()->fname.' '.Auth::user()->lname }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('owner.get.profile') }}">
                        <i class="typcn typcn-cog text-primary"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form1').submit();">
                        <i class="typcn typcn-power text-primary"></i>
                        Logout
                    </a>
                    <form id="logout-form1" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>