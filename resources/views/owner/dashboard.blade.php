@extends('layouts.admin.app_admin')

@section('content')
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">View Transactions</h4>
                </div>
                <div class="input-group">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary">search</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Completed Bookings</th>
                                <th>Cancelled Bookings</th>
                                <th>SPA Therapist</th>
                                <th>Count of SPA</th>
                                <th>Count of Services</th>
                               {{--  <th>Completed Date</th> --}}
                             {{--    <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                         
                            @foreach($list as $user)
                               
                                <tr>
                                    <td class="py-1">
                                        {{ $completedCount }}
                                    </td>
                                    <td>
                                        {{ $cancelCount }}
                                        
                                    </td>
                                    <td>
                                        {{ $user->therapist_count }}
                                    </td>
                                    <td>
                                        {{ $user->spas_count }}
                                    </td>
                                    <td>
                                        {{ $user->services_count }}
                                    </td>
                                    {{-- <td>
                                        {{ $transaction->approved_date }}
                                    </td> --}}
                                    <td>
                                        {{-- <?php
                                        $color = "";
                                            if($transaction->status == 'Approved') {
                                                $color = "success";
                                            } else if ($transaction->status == 'Pending') {
                                                $color = "warning";
                                            }
                                        ?>
                                        <?php if($transaction->status == 'Approved'):?>
                                        <span class="badge badge-{{ $color }} p-2 booking_status">
                                            Completed  
                                        </span>
                                        <?php else: ?>
                                        <span class="badge badge-{{ $color }} p-2 booking_status">
                                            Ongoing  
                                        </span>
                                        <?php endif; ?> --}}
                                    </td>
                                </tr>
                              
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>    
            <div class="pl-5 pr-5">
               {{--  {!! $transactions->withQueryString()->links('pagination::bootstrap-5') !!} --}}
            </div>
        </div>
    </div>
</div>
@endsection
