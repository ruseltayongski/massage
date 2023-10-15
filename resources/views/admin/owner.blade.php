@section('css')
    <style>
        .booking_status {
            cursor: pointer !important;
            color: white;
        }

        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', sans-serif;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .radio-tile-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .radio-tile-group .input-container {
            position: relative;
            height: 7rem;
            width: 7rem;
            margin: 0.5rem;
        }
        .radio-tile-group .input-container .radio-button {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            margin: 0;
            cursor: pointer;
        }
        .radio-tile-group .input-container .radio-tile {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            border: 2px solid #079ad9;
            border-radius: 5px;
            padding: 1rem;
            transition: transform 300ms ease;
        }
        .radio-tile-group .input-container .icon svg {
            /* fill: #079ad9; */
            width: 3rem;
            height: 3rem;
        }
        .radio-tile-group .input-container .icon-pending svg {
            fill: orange;
        }
        .radio-tile-group .input-container .icon-approved svg {
            fill: green;
        }
        .radio-tile-group .input-container .icon-rejected svg {
            fill: red;
        }
        .radio-tile-group .input-container .radio-tile-pending {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #079ad9;
        }
        .radio-tile-group .input-container .radio-tile-label-pending {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: orange;
        }
        .radio-tile-group .input-container .radio-tile-label-approved {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: green;
        }
        .radio-tile-group .input-container .radio-tile-label-rejected {
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: red;
        }
        .radio-tile-group .input-container .radio-button:checked + .radio-tile {
            background-color: #079ad9;
            border: 2px solid #079ad9;
            color: white;
            transform: scale(1.1, 1.1);
        }
        .radio-tile-group .input-container .radio-button:checked + .radio-tile .icon svg {
            fill: white;
            background-color: #079ad9;
        }
        .radio-tile-group .input-container .radio-button:checked + .radio-tile .radio-tile-label-pending {
            color: white;
            background-color: #079ad9;
        }
        .radio-tile-group .input-container .radio-button:checked + .radio-tile .radio-tile-label-approved {
            color: white;
            background-color: #079ad9;
        }
        .radio-tile-group .input-container .radio-button:checked + .radio-tile .radio-tile-label-rejected {
            color: white;
            background-color: #079ad9;
        }
        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        .modal-picture {
            display: none;
            position: fixed; 
            z-index: 999999999;
            padding-top: 100px; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.9); 
        }

        .modal-contents {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .modal-contents {
            animation-name: zoom;
            animation-duration: 0.6s;
        }
        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        #close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        #close:hover,
        #close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @media only screen and (max-width: 700px){
            .modal-contents {
                width: 100%;
            }
        }
    </style>
@endsection

@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Spa Owner</h4>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Spa</th>
                            <th>Therapist</th>
                            <th>Contract</th>
                            <th>Payment Proof</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ownerContracts as $user)
                            <tr>
                                @if(empty($user->picture))
                                <td>
                                    <img class="img-account-profile rounded-circle mb-2 w-50" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                </td>
                                @else
                                <td class="py-1">
                                    <img src="{{ asset('/fileupload/owner/profile').'/'.$user->picture }}" alt="image"/>
                                </td>
                                @endif
                                <td>
                                    {{ $user->username }}
                                </td>
                                <td>
                                    {{ $user->mobile }}
                                </td>
                                <td>
                                    {{ $user->spas_count }}
                                </td>
                                <td>
                                    {{ $user->therapist_count }}
                                </td>
                                <td>
                                    {{ ucfirst($user->contract_type) }}
                                </td>
                              
                                    @if(empty($user->payment_proof))
                                    <td>
                                       <span>None</span>
                                    </td>
                                    @else
                                    <td class="py-1">
                                        <img 
                                            id="myImg"
                                            class="myImg"
                                            style="width: 50px; height: 50px; border-radius: none !important;" 
                                            src="{{ asset('/fileupload/owner/payment').'/'.$user->payment_proof }}"
                                            alt="image"
                                        />
                                    </td>
                                    @endif
                                
                                <td>
                                    <?php
                                        $color = "";
                                        $text = "";
                                        if($user->status == 'Pending') {
                                            $color = "warning";
                                        } else if($user->status == 'Approved') {
                                            $color = "success";
                                        } else if($user->status == 'Rejected') {
                                            $color = "danger";
                                        } else if($user->status === null) {
                                            $color = "danger";
                                            $text = "No Proof of payment";
                                        }
                                    ?>
                                    <?php if ($user->status === null): ?>
                                    <span class="badge badge-{{ $color }} p-2 booking_status">
                                        {{ $text }}
                                    </span>
                                    <?php else: ?>
                                        <span class="badge badge-{{ $color }} p-2 booking_status" onclick="updateBookingStatus('{{ $user->id }}','{{ strtolower($user->status) }}')">
                                            {{ $user->status }}     
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <div class="modal fade" data-bs-backdrop='static' id="booking_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Contract Status</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                          <span aria-hidden="true">×</span>
                          </button>
                      </div>
                      <form action="{{ route('update.contract.status') }}" method="POST">
                          @csrf
                          <div class="modal-body text-center">
                              <input type="hidden" id="user_id" name="user_id">
                              <!-- <input type="hidden" name="booking_status" id="booking_status" value="Pending">
                              <input type="checkbox" id="booking_status_toggle" data-toggle="toggle" data-on="Approved" data-off="Pending" data-onstyle="success" data-offstyle="primary" data-width="100" > -->
                              
                              <div class="radio-tile-group">
                                  <div class="input-container">
                                      <input id="pending" class="radio-button" type="radio" name="contract_status" value="Pending" />
                                      <div class="radio-tile">
                                          <div class="icon icon-pending">
                                              <svg viewBox="0 0 24 24" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{opacity:0.2;fill:none;stroke:#000000;stroke-width:5.000000e-02;stroke-miterlimit:10;} </style> <g id="grid_system"></g> <g id="_icons"> <path d="M17,2c-1.3,0-2.4,0.5-3.3,1.2c0,0-0.1,0-0.1-0.1C11.9,2.8,10,3.1,8.5,3.9C6.3,5.2,5,7.5,5,10v5.5c-0.6,0.5-1,1.2-1,2 C4,18.9,5.1,20,6.5,20h2.7c0.4,1.2,1.5,2,2.8,2s2.4-0.8,2.8-2h2.7c1.4,0,2.5-1.1,2.5-2.5c0-0.8-0.4-1.5-1-2v-3.9c0,0,0,0,0,0 c1.8-0.8,3-2.5,3-4.6C22,4.2,19.8,2,17,2z M17.5,18H14h-4H6.5C6.2,18,6,17.8,6,17.5S6.2,17,6.5,17h11c0.3,0,0.5,0.2,0.5,0.5 S17.8,18,17.5,18z M17,15H7v-5c0-1.8,1-3.4,2.5-4.3C10.4,5.2,11.4,5,12.4,5C12.1,5.6,12,6.3,12,7c0,2.8,2.2,5,5,5V15z M17,10 c-1.7,0-3-1.3-3-3s1.3-3,3-3s3,1.3,3,3S18.7,10,17,10z"></path> <path d="M18.7,5.3c-0.4-0.4-1-0.4-1.4,0L17,5.6l-0.3-0.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4L15.6,7l-0.3,0.3c-0.4,0.4-0.4,1,0,1.4 C15.5,8.9,15.7,9,16,9s0.5-0.1,0.7-0.3L17,8.4l0.3,0.3C17.5,8.9,17.7,9,18,9s0.5-0.1,0.7-0.3c0.4-0.4,0.4-1,0-1.4L18.4,7l0.3-0.3 C19.1,6.3,19.1,5.7,18.7,5.3z"></path> </g> </g></svg>
                                          </div>
                                          <label for="walk" class="radio-tile-label-pending">Pending</label>
                                      </div>
                                  </div>
              
                                  <div class="input-container">
                                      <input id="approved" class="radio-button" type="radio" name="contract_status" value="Approved" />
                                      <div class="radio-tile">
                                          <div class="icon icon-approved">
                                              <svg fill="#000000" viewBox="0 0 32 32" enable-background="new 0 0 32 32" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Approved"></g> <g id="Approved_1_"></g> <g id="File_Approve"></g> <g id="Folder_Approved"></g> <g id="Security_Approved"></g> <g id="Certificate_Approved"> <g> <path d="M30.538,25.184l-6.115-6.115C26.089,17.094,27,14.621,27,12c0-0.286-0.011-0.584-0.033-0.859 c-0.044-0.551-0.541-0.975-1.076-0.917c-0.551,0.044-0.961,0.526-0.917,1.076C24.991,11.524,25,11.767,25,12 c0,2.421-0.946,4.69-2.662,6.388c-1.309,1.29-2.947,2.144-4.748,2.47c-0.954,0.185-2.122,0.197-3.241-0.012 c-1.783-0.325-3.413-1.184-4.712-2.483C7.937,16.662,7,14.402,7,12c0-4.962,4.038-9,9-9c2.421,0,4.694,0.949,6.399,2.673 c0.388,0.392,1.022,0.396,1.414,0.008c0.393-0.388,0.396-1.021,0.008-1.414C21.737,2.16,18.959,1,16,1C9.935,1,5,5.935,5,12 c0,2.601,0.901,5.063,2.55,7.036l-6.257,6.257c-0.286,0.286-0.372,0.716-0.217,1.09C1.231,26.756,1.596,27,2,27h3v3 c0,0.404,0.244,0.769,0.617,0.924C5.741,30.975,5.871,31,6,31c0.26,0,0.516-0.102,0.707-0.293l7.819-7.819 C15.017,22.955,15.509,23,16,23c0.499,0,0.971-0.042,1.424-0.102l7.809,7.809C25.424,30.898,25.68,31,25.94,31 c0.129,0,0.259-0.025,0.383-0.076c0.374-0.155,0.617-0.52,0.617-0.924v-3h3c0.003,0,0.007,0,0.01,0c0.595-0.028,1.01-0.444,1.01-1 C30.96,25.663,30.793,25.365,30.538,25.184z M7,27.586V26c0-0.552-0.448-1-1-1H4.414l4.547-4.547 c0.062,0.051,0.128,0.096,0.19,0.146c0.154,0.124,0.31,0.245,0.47,0.359c0.092,0.066,0.186,0.128,0.28,0.191 c0.157,0.105,0.315,0.207,0.477,0.303c0.098,0.059,0.197,0.116,0.297,0.171c0.166,0.092,0.334,0.179,0.504,0.262 c0.099,0.048,0.197,0.097,0.297,0.142c0.186,0.084,0.375,0.16,0.565,0.233c0.068,0.026,0.133,0.058,0.202,0.083L7,27.586z M25.94,25c-0.552,0-1,0.448-1,1v1.586l-5.23-5.231c0.076-0.027,0.149-0.063,0.225-0.092c0.179-0.069,0.357-0.139,0.533-0.217 c0.109-0.049,0.216-0.102,0.324-0.153c0.162-0.079,0.322-0.16,0.479-0.247c0.107-0.059,0.213-0.119,0.318-0.181 c0.156-0.092,0.308-0.188,0.459-0.288c0.1-0.066,0.199-0.131,0.296-0.2c0.158-0.112,0.312-0.23,0.464-0.351 c0.064-0.051,0.132-0.096,0.195-0.148L27.526,25H25.94z"></path> <path d="M11.376,10.299c-0.402-0.377-1.036-0.356-1.413,0.047c-0.377,0.403-0.356,1.036,0.047,1.413l5.313,4.971 C15.514,16.91,15.76,17,16.005,17s0.491-0.09,0.683-0.27l10.688-10c0.403-0.377,0.424-1.01,0.047-1.413 c-0.378-0.404-1.011-0.424-1.413-0.047l-10.004,9.36L11.376,10.299z"></path> </g> </g> <g id="User_Approved"></g> <g id="ID_Card_Approved"></g> <g id="Android_Approved"></g> <g id="Privacy_Approved"></g> <g id="Approved_2_"></g> <g id="Message_Approved"></g> <g id="Upload_Approved"></g> <g id="Download_Approved"></g> <g id="Email_Approved"></g> <g id="Data_Approved"></g> </g></svg>
                                          </div>
                                          <label for="bike" class="radio-tile-label-approved">Approved</label>
                                      </div>
                                  </div>
              
                                  <div class="input-container">
                                      <input id="rejected" class="radio-button" type="radio" name="contract_status" value="Rejected"/>
                                      <div class="radio-tile">
                                          <div class="icon icon-rejected">
                                              <svg height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#000000;} </style> <g> <path class="st0" d="M61.429,355.664l-8.526-26.171l9.907-3.227l18.279,22.993l13.248-4.324l-20.62-24.57 c0.927-0.91,1.992-2.462,2.731-4.023c1.585-3.348,1.87-7.566,1.853-9.59c-0.024-2.032-0.423-4.218-1.178-6.551 c-0.902-2.763-2.17-5.218-3.812-7.372c-1.65-2.153-3.584-3.852-5.811-5.136c-2.244-1.276-4.714-2.065-7.42-2.382 c-2.715-0.3-5.543,0.033-8.502,0.992l-22.961,7.477l21.376,65.606L61.429,355.664z M43.776,301.485l10.785-3.52 c2.519-0.82,4.796-0.674,6.827,0.431c2.024,1.105,3.462,2.95,4.308,5.527c0.829,2.576,0.756,4.917-0.228,7.005 c-0.991,2.089-2.739,3.544-5.267,4.365l-10.777,3.503L43.776,301.485z"></path> <polygon class="st0" points="128.84,261.14 90.258,273.705 111.625,339.311 150.207,326.746 146.484,315.318 119.338,324.161 114.145,308.223 137.26,300.689 133.537,289.261 110.43,296.796 105.415,281.41 132.562,272.559 "></polygon> <path class="st0" d="M177.239,305.915c-1.918,0.626-3.527,0.756-4.828,0.398c-1.292-0.358-2.584-0.902-3.852-1.642l-8.055,7.095 c3.43,3.991,9.038,6.494,11.703,6.746c2.658,0.252,5.584-0.138,8.754-1.179c2.69-0.87,5.128-2.194,7.315-3.958 c2.186-1.764,3.934-3.877,5.258-6.348c1.317-2.471,2.081-5.258,2.309-8.396c0.219-3.13-0.26-6.51-1.439-10.127l-14.345-44.052 l-11.428,3.731l14.167,43.491c1.243,3.804,1.316,6.9,0.252,9.282C181.97,303.354,180.043,304.997,177.239,305.915z"></path> <polygon class="st0" points="237.961,225.597 199.379,238.163 220.747,303.769 259.328,291.204 255.606,279.776 228.46,288.611 223.266,272.68 246.373,265.154 242.65,253.736 219.543,261.254 214.537,245.868 241.675,237.025 "></polygon> <path class="st0" d="M274.665,226.695c1.032-1.016,2.34-1.789,3.942-2.309c2.836-0.918,5.316-0.772,7.429,0.488 c2.105,1.244,3.901,3.121,5.381,5.64l11.688-3.819c-3.349-6.518-7.518-10.884-12.509-13.094c-4.99-2.211-10.232-2.43-15.718-0.642 c-3.397,1.114-6.169,2.674-8.299,4.689c-2.13,2.024-3.861,4.471-5.169,7.34c-0.943,2.146-1.52,4.242-1.731,6.275 c-0.212,2.04-0.155,4.177,0.179,6.421c0.341,2.226,0.87,4.616,1.609,7.168c0.74,2.544,1.61,5.389,2.642,8.51 c1.016,3.137,1.983,5.949,2.877,8.444c0.91,2.487,1.886,4.731,2.926,6.738c1.049,2.008,2.26,3.771,3.641,5.291 c1.366,1.528,3.064,2.869,5.088,4.047c2.747,1.545,5.584,2.512,8.502,2.886c2.901,0.382,6.055,0.008,9.46-1.097 c5.486-1.789,9.598-5.04,12.33-9.769c2.73-4.731,3.535-10.712,2.389-17.946l-11.59,3.771c0.26,2.902-0.089,5.478-1.081,7.729 c-0.991,2.268-2.918,3.861-5.77,4.796c-1.593,0.512-3.097,0.666-4.536,0.455c-1.438-0.212-2.73-0.708-3.892-1.479 c-0.772-0.496-1.48-1.114-2.113-1.862c-0.634-0.747-1.277-1.755-1.942-3.039c-0.658-1.284-1.374-2.926-2.162-4.958 c-0.772-2.016-1.674-4.592-2.698-7.729c-1.016-3.13-1.813-5.738-2.374-7.835c-0.553-2.089-0.943-3.852-1.162-5.283 c-0.22-1.406-0.293-2.609-0.22-3.592c0.073-0.975,0.276-1.886,0.602-2.747C272.869,228.865,273.625,227.71,274.665,226.695z"></path> <polygon class="st0" points="328.234,208.838 345.879,263.017 357.315,259.287 339.662,205.108 354.974,200.126 351.252,188.698 309.215,202.393 312.938,213.812 "></polygon> <polygon class="st0" points="404.781,171.264 366.198,183.83 387.558,249.436 426.148,236.87 422.426,225.444 395.279,234.286 390.085,218.339 413.201,210.814 409.486,199.394 386.372,206.92 381.356,191.527 408.502,182.692 "></polygon> <path class="st0" d="M467.769,172.004c-0.829-1.804-1.755-3.406-2.787-4.804c-1.033-1.398-2.219-2.649-3.552-3.788 c-3.169-2.641-6.429-4.259-9.777-4.868c-3.348-0.602-7.03-0.252-11.029,1.049l-21.14,6.884l21.359,65.606l21.148-6.892 c3.999-1.301,7.185-3.186,9.534-5.648c2.348-2.463,4.023-5.69,5.031-9.689c0.414-1.698,0.634-3.421,0.642-5.152 c0.008-1.731-0.178-3.576-0.577-5.519c-0.39-1.951-0.918-4.047-1.601-6.315c-0.674-2.251-1.447-4.738-2.325-7.445 c-0.886-2.698-1.714-5.153-2.503-7.388C469.411,175.816,468.598,173.8,467.769,172.004z M464.518,207.245 c-1.049,3.34-3.454,5.608-7.233,6.844l-8.722,2.845l-13.922-42.76l8.712-2.836c3.788-1.235,7.071-0.805,9.883,1.268 c0.781,0.561,1.48,1.252,2.081,2.073c0.593,0.82,1.204,1.877,1.797,3.137c0.593,1.268,1.227,2.829,1.885,4.682 c0.666,1.861,1.414,4.072,2.26,6.656c0.837,2.585,1.536,4.811,2.097,6.714c0.56,1.885,0.959,3.519,1.227,4.892 c0.268,1.374,0.39,2.568,0.399,3.584C464.974,205.368,464.827,206.335,464.518,207.245z"></path> <polygon class="st0" points="198.03,121.604 208.661,110.673 223.697,113.241 216.586,99.758 223.68,86.25 208.652,88.834 197.998,77.927 195.819,93.02 182.149,99.774 195.827,106.511 "></polygon> <polygon class="st0" points="313.97,390.41 303.331,401.325 288.304,398.772 295.407,412.257 288.32,425.756 303.348,423.164 313.995,434.079 316.181,418.986 329.844,412.224 316.173,405.495 "></polygon> <path class="st0" d="M467.81,111.982l-30.397,9.899c-0.951-1.276-1.804-2.625-2.78-3.877c-20.271-26.26-46.661-48.108-76.311-63.16 C304.6,27.519,243.447,22.748,186.131,41.417C128.799,60.095,82.179,99.961,54.853,153.676 C39.768,183.31,31.3,216.502,30.357,249.68c-0.049,1.584,0.056,3.186,0.041,4.779L0,264.358l4.154,12.753L471.971,124.75 L467.81,111.982z M47.376,242.333c1.837-28.326,9.355-55.61,22.319-81.106c25.317-49.765,68.49-86.697,121.58-103.993 c53.082-17.279,109.732-12.866,159.497,12.443c25.512,12.98,47.644,30.618,65.802,52.407c1.43,1.715,2.649,3.527,4.023,5.275 l-84.82,27.626c-1.447-1.138-2.87-2.324-4.349-3.389c-5.348-3.876-11.086-7.371-17.044-10.403 c-30.624-15.597-65.492-18.327-98.376-7.615c-32.681,10.639-59.242,33.38-74.807,64.029c-3.04,5.966-5.616,12.168-7.656,18.442 c-0.568,1.731-1.016,3.536-1.512,5.307l-84.796,27.617C47.311,246.754,47.23,244.552,47.376,242.333z M320.001,160.13 L147.81,216.218c0.934-2.552,1.861-5.121,2.966-7.575c0.764-1.674,1.536-3.324,2.374-4.966 c13.995-27.463,37.826-47.839,67.118-57.381c29.292-9.542,60.551-7.104,88.039,6.851c1.641,0.83,3.242,1.707,4.852,2.618 C315.498,157.098,317.749,158.618,320.001,160.13z"></path> <path class="st0" d="M512,247.656l-4.153-12.752L40.029,387.264l4.161,12.76l30.422-9.908c0.95,1.276,1.812,2.634,2.788,3.885 c20.238,26.228,46.62,48.058,76.294,63.128c53.715,27.349,114.868,32.128,172.208,13.451 c57.332-18.678,103.953-58.552,131.253-112.283c15.11-29.69,23.571-62.875,24.48-95.963c0.049-1.65,0.041-3.211,0.049-4.804 L512,247.656z M364.167,295.804c-0.935,2.536-1.845,5.088-2.967,7.558c-0.731,1.666-1.536,3.332-2.357,4.933 c-13.979,27.48-37.809,47.872-67.109,57.414c-29.3,9.542-60.576,7.103-88.047-6.876c-1.61-0.812-3.243-1.682-4.82-2.601 c-2.357-1.341-4.592-2.86-6.844-4.356L364.167,295.804z M464.624,269.674c-1.828,28.317-9.33,55.601-22.294,81.098 c-25.318,49.765-68.5,86.697-121.581,103.993c-53.09,17.287-109.723,12.874-159.497-12.444 c-25.488-12.964-47.62-30.592-65.776-52.407c-1.414-1.69-2.666-3.536-4.032-5.284l84.788-27.61c1.447,1.139,2.861,2.317,4.356,3.39 c5.429,3.909,11.151,7.412,17.028,10.411c30.632,15.598,65.533,18.312,98.271,7.648c32.738-10.664,59.347-33.413,74.92-64.062 c2.983-5.876,5.551-12.078,7.625-18.433c0.576-1.748,1.024-3.536,1.52-5.307l84.828-27.634 C464.697,265.252,464.779,267.471,464.624,269.674z"></path> <polygon class="st0" points="119.769,186.707 132.213,177.897 117.64,173.378 113.112,158.821 104.31,171.281 89.071,171.094 98.199,183.31 93.313,197.76 107.748,192.844 119.972,201.954 "></polygon> <polygon class="st0" points="392.232,325.291 379.788,334.109 394.361,338.62 398.888,353.177 407.69,340.725 422.937,340.904 413.81,328.696 418.687,314.254 404.252,319.154 392.028,310.044 "></polygon> <polygon class="st0" points="186.7,392.23 177.89,379.787 173.379,394.352 158.822,398.895 171.274,407.68 171.087,422.928 183.302,413.801 197.746,418.694 192.836,404.25 201.956,392.027 "></polygon> <polygon class="st0" points="325.284,119.776 334.103,132.211 338.614,117.646 353.178,113.12 340.718,104.318 340.906,89.07 328.69,98.197 314.239,93.312 319.156,107.747 310.037,119.971 "></polygon> </g> </g></svg>
                                          </div>
                                          <label for="drive" class="radio-tile-label-rejected">Rejected</label>
                                      </div>
                                  </div>
                              </div>
              
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                              <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                      </form>
                  </div>
                </div>
              </div>
              <div id="myModal" class="modal-picture">
                <span id="close">&times;</span>
                <img class="modal-contents" id="img01">
              </div>
            <div class="pl-5 pr-5">
                {!! $ownerContracts->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/js/bootstrap-toogle.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.contract_status').change(function() {
            let status = "";
            if(this.checked) {
                status = "Approved";
            }
            else {
                status = "Reject";
            }
            Lobibox.confirm({
                msg: `Are you sure you want to ${status} this booking?`,
                callback: function ($this, type, ev) {
                    //Your code goes here
                }
            });    
        });

        var modal = $("#myModal");
            var modalImg = $("#img01");
            // Select all elements with the class "myImg"
            var images = $(".myImg");

            // Loop through each image and attach the click event
            images.click(function() {
                modal.css("display", "block");
                modalImg.attr("src", $(this).attr("src"));
            });

            var span = $("#close");
            span.click(function() {
                modal.css("display", "none");

            $(document).keydown(function(event) {
                if(event.key === "Escape" && modal.css("display") === "block") {
                    modal.css("display", "none");
                }
            });
        });
    });

    function updateBookingStatus(user_id, status) {
        event.preventDefault();
        $(document).ready(function() {
            $('#booking_status_modal').modal('toggle');
            $("#user_id").val(user_id)
            $('#'+status).prop('checked', true);
        });
    }

    function closeModal() {
        $('#booking_status_modal').modal('toggle');
    }

   
</script>
@endsection
