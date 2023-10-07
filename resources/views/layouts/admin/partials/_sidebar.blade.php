<?php 
  $user = Auth::user(); 
  $firstRoute = strtolower($user->roles);
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <div class="d-flex sidebar-profile">
        <div class="sidebar-profile-image">
          @if($firstRoute === 'owner')
          @if(empty($user->picture))
            <img class="img-account-profile rounded-circle mb-2 w-75" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
          @else
            <img src="{{ asset('/fileupload/owner/profile').'/'.$user->picture }}" alt="image"/>
          @endif
        @elseif($firstRoute === 'admin')
          @if(empty($user->picture))
            <img class="img-account-profile rounded-circle mb-2 w-75" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
          @else
            <img src="{{ asset('/fileupload/admin/profile').'/'.$user->picture }}" alt="image"/>
          @endif
        @else
          @if(empty($user->picture))
            <img class="img-account-profile rounded-circle mb-2 w-75" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
          @else
            <img src="{{ asset('/fileupload/therapist/profile').'/'.$user->picture }}" alt="image"/>
          @endif
        @endif
        
          <span class="sidebar-status-indicator"></span>
        </div>
        <div class="sidebar-profile-name">
          <p class="sidebar-name">
            {{ $user->fname.' '.$user->lname }}
          </p>
          <p class="sidebar-designation">
            Welcome
          </p>
        </div>
      </div>
      <div class="nav-search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Type to search..." aria-label="search" aria-describedby="search">
          <div class="input-group-append">
            <span class="input-group-text" id="search">
              <i class="typcn typcn-zoom"></i>
            </span>
          </div>
        </div>
      </div>
      <p class="sidebar-menu-title">Dash menu</p>
    </li>
   
    @if($user->roles == 'THERAPIST')
    <li class="nav-item">
      <a class="nav-link" href="{{ route($firstRoute.'/dashboard') }}">
        <i class="typcn typcn-device-desktop menu-icon"></i>
        <span class="menu-title">Manage Profile</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route($firstRoute.'.booking') }}">
        <i class="typcn typcn-news menu-icon"></i>
        <span class="menu-title">Manage Booking</span>
      </a>
    </li>
    @else
    <li class="nav-item">
      <a class="nav-link" href="{{ route($firstRoute.'/dashboard') }}">
        <i class="typcn typcn-device-desktop menu-icon"></i>
        <span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>
      </a>
    </li>
    @endif
    @if($user->roles == 'ADMIN')
    <li class="nav-item">
      <a class="nav-link" href="{{ route($firstRoute.'/owner') }}">
        <i class="typcn typcn-user-add-outline menu-icon"></i>
        <span class="menu-title">Spa Owner</span>
      </a>
    </li>
    @endif
    @if($user->roles == 'OWNER')
    <li class="nav-item">
      <a class="nav-link" href="{{ route($firstRoute.'.contract') }}">
        <i class="typcn typcn-news menu-icon"></i>
        <span class="menu-title">Manage Contract</span>
      </a>
    </li>
    <li class="nav-item {{ hasContractEnded($user->contract_end) ? 'menu-disabled' : '' }}">
      <a class="nav-link" href="{{ route($firstRoute.'/spa') }}">
        <i class="typcn typcn-tags menu-icon"></i>
        <span class="menu-title">Manage Spa</span>
      </a>
    </li>
    <li class="nav-item {{ hasContractEnded($user->contract_end) ? 'menu-disabled' : '' }}">
      <a class="nav-link" href="{{ route($firstRoute.'/therapist') }}">
        <i class="typcn typcn-user-add-outline menu-icon"></i>
        <span class="menu-title">Manage Therapist</span>
      </a>
    </li>
    <li class="nav-item {{ hasContractEnded($user->contract_end) ? 'menu-disabled' : '' }}">
      <a class="nav-link" href="{{ route($firstRoute.'/services') }}">
        <i class="typcn typcn-user-add-outline menu-icon"></i>
        <span class="menu-title">Services</span>
      </a>
    </li>
    @endif
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="typcn typcn-cog-outline menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="typcn typcn-briefcase menu-icon"></i>
        <span class="menu-title">UI Elements</span>
        <i class="typcn typcn-chevron-right menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
        <i class="typcn typcn-film menu-icon"></i>
        <span class="menu-title">Form elements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="form-elements">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
        <i class="typcn typcn-chart-pie-outline menu-icon"></i>
        <span class="menu-title">Charts</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="charts">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
        <i class="typcn typcn-th-small-outline menu-icon"></i>
        <span class="menu-title">Tables</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="tables">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
        <i class="typcn typcn-compass menu-icon"></i>
        <span class="menu-title">Icons</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="icons">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="typcn typcn-user-add-outline menu-icon"></i>
        <span class="menu-title">User Pages</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
        <i class="typcn typcn-globe-outline menu-icon"></i>
        <span class="menu-title">Error pages</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="error">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/documentation/documentation.html">
        <i class="typcn typcn-document-text menu-icon"></i>
        <span class="menu-title">Documentation</span>
      </a>
    </li> -->
  </ul>
  <ul class="sidebar-legend">
    <li>
      <p class="sidebar-menu-title">Category</p>
    </li>
    <li class="nav-item"><a href="#" class="nav-link">#Owner</a></li>
    <li class="nav-item"><a href="#" class="nav-link">#Therapist</a></li>
    <li class="nav-item"><a href="#" class="nav-link">#Spa</a></li>
  </ul>
</nav>