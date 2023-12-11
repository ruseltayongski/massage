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
            <th style="background-color:yellow;">Spa</th>
            <th style="background-color:yellow;">Address</th>
            <th style="background-color:yellow;">Income</th>
        </tr>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ date('F', strtotime($booking->start_date)) }}</td>
                <td>{{ $booking->spa_name }}</td>
                <td>{{ $booking->spa_address }}</td>
                <td>{{ $booking->amount_paid }}</td>
                <?php $grand_total += $booking->amount_paid; ?>
            </tr>
        @endforeach
        <tr>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td><b style="float:right;">Grand Total</b></td>
            <td>{{ $grand_total }}</td>
        </tr>
    </table>
</body>
</html>