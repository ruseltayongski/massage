<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>
        h4 {
            margin: 0;
        }
        .w-full {
            width: 100%;
        }
        .w-half {
            width: 50%;
        }
        .margin-top {
            margin-top: 1.25rem;
        }
        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }
        table {
            width: 100%;
            border-spacing: 0;
        }
        table.products {
            font-size: 1rem;
        }
        table.products tr {
            background-color: rgb(96 165 250);
        }
        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }
        table tr.items {
            background-color: rgb(241 245 249);
        }
        table tr.items td {
            padding: 1rem;
            border: solid 0.5px rgb(177, 188, 212);
        }
        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <table class="w-full">
        <tr>
            <td class="w-half">
                <h2>Invoice ID: {{ time() . mt_rand(100000, 999999) }}</h2>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>Customer Name: </h4></div>
                    <div>{{ $user->fname .' ' . $user->lname }}</div>
                </td>
            
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Number</th>
                <th>Service</th>
                <th>SPA</th>
                <th>Therapist</th>
                <th>Booking</th>
                <th>Date & Time</th>
                <th>Amount</th>
               
                
                
               
            </tr>
            <tr class="items">
                <td>{{ ucfirst(strtolower($booking->receipt_number)) }}</td>
                <td>{{ ucfirst(strtolower($booking->services)) }}</td>
                <td>{{ ucfirst(strtolower($booking->spa_name)) }}</td>
                <td>{{ ucfirst(strtolower($booking->therapist)) }}</td>
                <td> @if(ucfirst(strtolower($booking->booking_type == 'home_service')))
                    Home Service
                    @else
                        Onsite
                    @endif
                </td>
                <td>
                    {{ ucfirst(strtolower(date("M j, Y", strtotime($booking->start_date)))) }}
                    <small>({{ date("g:i a",strtotime($booking->start_time)) }})</small>
                </td>
                <td>{{ number_format($booking->amount_paid, 2) }}</td>
                <!-- Add other columns based on your needs -->
            </tr>
        </table>
    </div>
 
    <div class="total">
       <span>Total: </span>{{ $booking->amount_paid }}
    </div>
 
    <div class="footer margin-top">
        <div>Thank you</div>
    </div>
</body>
</html>

