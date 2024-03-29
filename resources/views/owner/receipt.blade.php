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
                    <div>{{ ucfirst($user->fname) .' ' . ucfirst($user->lname) }}</div>
                </td>
            
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Receipt Number</th>
                <th>Contract Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Amount</th>
            </tr>
            <tr class="items">
                <td>{{ time() . mt_rand(100000, 999999) }}</td>
                <td> 
                    {{ ucfirst($contracts->type) }}
                </td>
                <td>
                    {{ (date("M j, Y", strtotime($contracts->start_date))) }}
                    
                </td>
                <td>
                    {{ (date("M j, Y", strtotime($contracts->end_date))) }}
                </td>
                <td>{{ number_format($contracts->amount_paid, 2) }}</td>
            </tr>
        </table>
    </div>
 
    <div class="total">
       <span>Total: </span>{{ $contracts->amount_paid }}
    </div>
 
    <div class="footer margin-top">
        <div>Thank you</div>
    </div>
</body>
</html>

