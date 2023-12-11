<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barchart Export Excel</title>
</head>
<body>
    <?php $grand_total = 0; ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th style="background-color:yellow;">Month</th>
            <th style="background-color:yellow;">Start Date</th>
            <th style="background-color:yellow;">End Date</th>
            <th style="background-color:yellow;">Fullname</th>
            <th style="background-color:yellow;">Contract Type</th>
            <th style="background-color:yellow;">Income</th>
        </tr>
        @foreach($contracts as $contract)
            <tr>
                <td>{{ date('F', strtotime($contract->active_date)) }}</td>
                <td>{{ $contract->start_date }}</td>
                <td>{{ $contract->end_date }}</td>
                <td>{{ $contract->customer_name }}</td>
                <td>{{ $contract->contract_type }}</td>
                <td>{{ $contract->amount_paid }}</td>
                <?php $grand_total += $contract->amount_paid; ?>
            </tr>
        @endforeach
        <tr>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td><b style="float:right;">Grand Total</b></td>
            <td>{{ $grand_total }}</td>
        </tr>
    </table>
</body>
</html>