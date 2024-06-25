<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Draw Earning Statement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 0px;
        }
        .header h1 {
            text-align: left;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .main-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .main-table th, .main-table td {
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        .summary h2 {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .summary p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Owner Draw Earning Statement</h1>
        </div>
        <table class="main-table" style="width: 100%; table-layout: fixed;">
            <tr>
                <!-- Company Information -->
                <td style="width: 33%;">
                    <h3>Company Information</h3>
                    <p><strong>{{ $paystub['companyname'] }}</strong><br />
                    {{ $paystub['companystreet'] }}<br />
                    {{ $paystub['companycity'] }}, {{ $paystub['companystate'] }} {{ $paystub['companyzip'] }} {{ $paystub['companycountry'] }}<br />
                    Phone: {{ $paystub['companyphone'] }}<br />
                    EIN: {{ $paystub['einno'] }}</p>
                </td>
                <!-- Employee Information -->
                <td style="width: 33%;">
                    <h3>Employee Information</h3>
                    <p><strong>{{ $paystub['firstname'] }} {{ $paystub['middlename'] }} {{ $paystub['lastname'] }}</strong><br />
                    {{ $paystub['street'] }}<br />
                    {{ $paystub['city'] }}, {{ $paystub['state'] }} {{ $paystub['zip'] }} {{ $paystub['country'] }}<br />
                    Social Sec. No.: xxx-xx-{{ substr($paystub['ssn'], -4) }}<br />
                    Position: {{ $paystub['title'] }}<br />
                    Email: {{ $paystub['email'] }}</p>
                </td>
                <!-- Pay Information -->
                <td style="width: 33%;">
                    <h3>Pay Information</h3>
                    <p><b>Pay Period:</b><br />
                    {{ $paystub['paystartday'] }}
                    - {{ $paystub['payendday'] }}<br />
                    <!-- <div class="summary"> -->
                        <h3>Summary</h3>
                        Pay Stub No.: {{ $paystub['stubno'] }}<br />
                        Net Pay: ${{ number_format($paystub['netpayamount'], 2) }}<br />
                        YTD Net Pay: ${{ number_format($paystub['netpayamount'] + $totalPrevOwnerDraws, 2) }}<br />
                        Pay Date: {{ $paystub['payday'] }}
                    </p>
                    <!-- </div> -->
                </td>
            </tr>
        </table>
        <div class="table-container">
            <h3>Current Earnings</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 33%;">Description</th>
                        <th style="width: 33%;">Pay Date</th>
                        <th style="width: 33%;">Current Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 33%;">Owner's Draw</td>
                        <td style="width: 33%;">{{ $paystub['payday'] }}</td>
                        <td style="width: 33%;">${{ number_format($paystub['netpayamount'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-container">
            <h3>YTD Earnings</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 33%;">Description</th>
                        <th style="width: 33%;">Pay Date</th>
                        <th style="width: 33%;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prevOwnerDraws as $draw)
                    <tr>
                        <td style="width: 33%;">Owner's Draw</td>
                        <td style="width: 33%;">{{ $draw['date']->format('Y-m-d') }}</td>
                        <td style="width: 33%;">${{ number_format($draw['amount'], 2) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="width: 33%;">Owner's Draw</td>
                        <td style="width: 33%;">{{ $paystub['payday'] }}</td>
                        <td style="width: 33%;">${{ number_format($paystub['netpayamount'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
