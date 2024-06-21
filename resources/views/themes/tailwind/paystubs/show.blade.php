@extends('theme::layouts.app')

@section('content')
<!-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> -->

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Owner Draw Earning Statement</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Company Information -->
        <div>
            <h2 class="font-semibold text-lg mb-2">Company Information</h2>
            <p><strong>{{ $paystub['companyname'] }}</strong></p>
            <p>{{ $paystub['companystreet'] }}</p>
            <p>{{ $paystub['companycity'] }}, {{ $paystub['companystate'] }} {{ $paystub['companyzip'] }} {{ $paystub['companycountry'] }}</p>
            <p>PHONE: {{ $paystub['companyphone'] }}</p>
            <p>EIN: {{ $paystub['einno'] }}</p>
        </div>

        <!-- Employee Information -->
        <div>
            <h2 class="font-semibold text-lg mb-2">Employee Information</h2>
            <p><strong>{{ $paystub['firstname'] }} {{ $paystub['middlename'] }} {{ $paystub['lastname'] }}</strong></p>
            <p>{{ $paystub['street'] }}</p>
            <p>{{ $paystub['city'] }}, {{ $paystub['state'] }} {{ $paystub['zip'] }} {{ $paystub['country'] }}</p>
            <p>Social Sec. No.: xxx-xx-{{ $paystub['ssn'] }}</p>
            <p>Position: {{ $paystub['title'] }}</p>
            <p>Email: {{ $paystub['email'] }}</p>
        </div>

        <!-- Pay Information -->
        <div>
                <h2 class="font-semibold text-lg mb-2">Pay Information</h2>
                <p>Pay Period: {{ $paystub['paystartday'] }} - {{ $paystub['payendday'] }}</p>
                <p>Pay Date: {{ $paystub['payday'] }}</p>
                <br />
                <h2 class="text-lg font-semibold">Summary</h2>
                <p>Pay Stub No.: {{ $paystub['stubno'] }}</p>
                <p>Net Pay: ${{ number_format($paystub['netpayamount'], 2) }}</p>
                <p>YTD Net Pay: ${{ number_format($paystub['netpayamount'] + $totalPrevOwnerDraws, 2) }}</p>
        </div>

    </div>

    <h2 class="font-semibold text-lg mb-2">Current Earnings</h2>
    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border px-4 py-2 w-1/3">Description</th>
                <th class="border px-4 py-2 w-1/3">Pay Date</th>
                <th class="border px-4 py-2 w-1/3">Current Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">Owner's Draw</td>
                <td class="border px-4 py-2">{{ $paystub['payday'] }}</td>
                <td class="border px-4 py-2">${{ number_format($paystub['netpayamount'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h2 class="font-semibold text-lg mb-2 mt-4">YTD Earnings</h2>
    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="border px-4 py-2 w-1/3">Description</th>
                <th class="border px-4 py-2 w-1/3">Pay Date</th>
                <th class="border px-4 py-2 w-1/3">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prevOwnerDraws as $draw)
            <tr>
                <td class="border px-4 py-2">Owner's Draw</td>
                <td class="border px-4 py-2">{{ $draw['date']->format('Y-m-d') }}</td>
                <td class="border px-4 py-2">${{ number_format($draw['amount'], 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td class="border px-4 py-2">Owner's Draw</td>
                <td class="border px-4 py-2">{{ $paystub['payday'] }}</td>
                <td class="border px-4 py-2">${{ number_format($paystub['netpayamount'], 2) }}</td>
            </tr>
        </tbody>
    </table>
    
</div>
@endsection
