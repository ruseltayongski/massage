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
                                <th>Client Name</th>
                                <th>Spa</th>
                                <th>Services</th>
                                <th>Book Date</th>
                                <th>Therapist</th>
                               {{--  <th>Completed Date</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            @foreach($transactions as $transaction)
                                @if($transaction->status == "Approved")
                                <tr>
                                    <td class="py-1">
                                        {{ $transaction->client_name }}
                                    </td>
                                    <td>
                                        {{ $transaction->spa_name }}
                                        
                                    </td>
                                    <td>
                                        {{ $transaction->services_name }}
                                    </td>
                                    <td>
                                    {{ $transaction->start_date }}
                                    </td>
                                    <td>
                                        {{ $transaction->therapist_name }}
                                    </td>
                                    {{-- <td>
                                        {{ $transaction->approved_date }}
                                    </td> --}}
                                    <td>
                                        <?php
                                        $color = "";
                                            if($transaction->status == 'Approved') {
                                                $color = "success";
                                            }
                                        ?>
                                        <span class="badge badge-{{ $color }} p-2 booking_status">
                                            Completed  
                                        </span>
                                    </td>
                                </tr>
                                @endif
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