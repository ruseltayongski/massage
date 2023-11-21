<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject --> 
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    <!-- LOBIBOX -->
    <link rel="stylesheet" href="{{ asset('plugin/lobibox/dist/css/LobiBox.min.css') }}">
    @vite(['resources/js/app.js'])
    <style>
        .menu-disabled {
            pointer-events: none !important; /* Disable mouse events */
            opacity: 0.5 !important;
            background-color: red;
        }
    </style>
    @yield('css')
</head>
<body>
    <input type="hidden" id="asset" value="{{ asset('/') }}">
    <?php 
        $user = Auth::user(); 
        if (!function_exists('hasContractEnded')) {
            function hasContractEnded($date_end) {
                $dateEnd = new DateTime($date_end);
                $dateEnd->modify('+1 day');
                $today = new DateTime();

                $differenceInDays = $dateEnd->diff($today)->days;
                return $differenceInDays <= 0;
            }
        }
        if (!function_exists('contractEnded2DaysBefore')) {
            function contractEnded2DaysBefore($date_end) {
                $dateEnd = new DateTime($date_end);
                $dateEnd->modify('+1 day');
                $today = new DateTime();

                $differenceInDays = $dateEnd->diff($today)->days;
                return $differenceInDays > 0 && $differenceInDays <= 2;
            }
        }
    ?>
    <div id="app">
        @if($user->roles == 'OWNER') 
            @if(contractEnded2DaysBefore($user->contract_end))    
                <div class="row" id="proBanner">
                    <div class="col-12">
                        <span class="d-flex align-items-center purchase-popup">
                            <p>This is a friendly reminder that your contract is ending soon</p>
                            <a href="#sign_contract" class="btn download-button purchase-button ml-auto" data-backdrop="static" data-toggle="modal">Renew a contract</a>
                            <i class="typcn typcn-delete-outline" id="bannerClose"></i>
                        </span>
                    </div>
                </div>
            @elseif(hasContractEnded($user->contract_end))
                <div class="row" id="proBanner">
                    <div class="col-12">
                        <span class="d-flex align-items-center purchase-popup">
                            <p>Sign now!, to avail exciting features!</p>
                            <a href="#sign_contract" class="btn download-button purchase-button ml-auto" data-backdrop="static" data-toggle="modal">Sign a contract</a>
                            <i class="typcn typcn-delete-outline" id="bannerClose"></i>
                        </span>
                    </div>
                </div>    
            @endif
        @endif
        <div class="container-scroller">
            @include('layouts.admin.partials._navbar')
            <div class="container-fluid page-body-wrapper">
                @include('layouts.admin.partials._settings-panel')
                @include('layouts.admin.partials._sidebar')
                <div class="main-panel">
                    @yield('content')
                    @include('layouts.admin.partials._footer')
                </div>
            </div>
        </div>
    </div>
    @include('modal.modal')
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/template.js') }}"></script>
    <script src="{{ asset('admin/js/settings.js') }}"></script>
    <script src="{{ asset('admin/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{ asset('admin/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{ asset('admin/js/dashboard.js?v='.date('his')) }}"></script>
    <!-- End custom js for this page-->
    <!-- LOBIBOX -->
    <script src="{{ asset('plugin/lobibox/dist/js/lobibox.min.js?v='.date('his')) }}"></script>
    <script>
        var path_gif = "<?php echo asset('img/loading.gif'); ?>";
        var loading = '<center><img src="'+path_gif+'" alt=""></center>';

   
        @if(session('contract_save'))
            <?php //session('contract_save',false); ?>
            Lobibox.notify('success', {
                msg: 'Successfully secured the contract!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
    
        @if(session('profile_update'))
            <?php //session('contract_save',false); ?>
            Lobibox.notify('success', {
                msg: 'Successfully updated the Profile!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('owner_status'))
            <?php //session('contract_save',false); ?>
            Lobibox.notify('success', {
                msg: 'Successfully updated the Status!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('assign_spa'))
            <?php //session('contract_save',false); ?>
            Lobibox.notify('success', {
                msg: 'Successfully assign SPA!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('assign_therapist'))
            <?php //session('contract_save',false); ?>
            Lobibox.notify('success', {
                msg: 'Successfully assign Therapist!',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('therapist_update'))
            <?php //session('contract_save',false); ?>
            Lobibox.notify('success', {
                msg: 'Successfully Updated',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('booking_update_status'))
            Lobibox.notify('success', {
                msg: 'Successfully Updated Booking Status',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('services_update'))
            Lobibox.notify('success', {
                msg: 'Successfully Updated Services',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('services_save'))
            Lobibox.notify('success', {
                msg: 'Successfully Added Services',
                img: "{{ asset('img/check.png') }}"
            });
        @endif
        @if(session('insuficient_spa'))
            Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
            {
                msg: "Reached limit in creating a SPA"
            });
        @endif
        @if(session('error_save'))
            Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
            {
                msg: "Email is already exist"
            });
        @endif
        @if(session('spa_save'))
            Lobibox.notify('success', {
                msg: 'Successfully Added!',
                img: "{{ asset('img/check.png') }}"
            });

            // Clear the session flash data using AJAX
            $.ajax({
                url: "{{ route('clear_spa_update_flash') }}",
                method: 'POST',
                data: {_token: "{{ csrf_token() }}"},
                success: function(response) {
                    console.log('Flash data cleared');
                },
                error: function(error) {
                    console.error('Error clearing flash data');
                }
            });
        @endif
        @if(session('spa_update'))
            Lobibox.notify('success', {
                msg: 'Successfully updated!',
                img: "{{ asset('img/check.png') }}"
            });

            // Clear the session flash data using AJAX
            $.ajax({
                url: "{{ route('clear_spa_update_flash') }}",
                method: 'POST',
                data: {_token: "{{ csrf_token() }}"},
                success: function(response) {
                    console.log('Flash data cleared');
                },
                error: function(error) {
                    console.error('Error clearing flash data');
                }
            });
        @endif
        @if(session('therapist_save'))
            Lobibox.notify('success', {
                msg: 'Successfully add!',
                img: "{{ asset('img/check.png') }}"
            });

            // Clear the session flash data using AJAX
            $.ajax({
                url: "{{ route('clear_spa_update_flash') }}",
                method: 'POST',
                data: {_token: "{{ csrf_token() }}"},
                success: function(response) {
                    console.log('Flash data cleared');
                },
                error: function(error) {
                    console.error('Error clearing flash data');
                }
            });
        @endif


        // $("a[href='#sign_contract']").on('click',function(){
        //     $('.modal_content').html(loading);
        //     $('.modal-title').html('Title');
        //     var url = $(this).data('link');
        //     setTimeout(function(){
        //         $.ajax({
        //             url: url,
        //             type: 'GET',
        //             success: function(data) {
        //                 $('.modal_content').html(data);
        //                 $('#reservation').daterangepicker();
        //                 var datePicker = $('body').find('.datepicker');
        //                 $('input').attr('autocomplete', 'off');
        //             }
        //         });
        //     },1000);
        // });
        $(document).ready(function() {
            // Remove the 'disabled' property in token
            $('#logout-form input[name="_token"]').prop('disabled', false);
            $('#logout-form1 input[name="_token"]').prop('disabled', false);
        });
    </script>
    @yield('js')
</body>
</html>
