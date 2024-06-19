@extends('theme::layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Owner Draw Earning Statement</h1>
    <div class="border p-4">
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Company Information</h2>
            <p><strong>{{ $paystub->companyname }}</strong></p>
            <p>{{ $paystub->companystreet }}</p>
            <p>{{ $paystub->companycity }}, {{ $paystub->companystate }} {{ $paystub->companyzip }} {{ $paystub->companycountry }}</p>
            <p>PHONE: {{ $paystub->companyphone }}</p>
            <p>EIN: {{ $paystub->einno }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">Employee Information</h2>
            <p><strong>{{ $paystub->firstname }} {{ $paystub->middlename }} {{ $paystub->lastname }}</strong></p>
            <p>{{ $paystub->street }}</p>
            <p>{{ $paystub->city }}, {{ $paystub->state }} {{ $paystub->zip }} {{ $paystub->country }}</p>
            <p>Social Sec. No.: xxx-xx-{{ substr($paystub->ssn, -4) }}</p>
            <p>Position: {{ $paystub->title }}</p>
            <p>Email: {{ $paystub->email }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">Pay Information</h2>
            <p>Pay Period: {{ $paystub->paystartday }} - {{ $paystub->payendday }}</p>
            <p>Pay Date: {{ $paystub->payday }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">Current Earnings</h2>
            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Pay Date</th>
                        <th class="px-4 py-2">Current Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2">Owner's Draw</td>
                        <td class="border px-4 py-2">{{ $paystub->payday }}</td>
                        <td class="border px-4 py-2">${{ number_format($paystub->grossincome, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">YTD Earnings</h2>
            <table class="table-auto w-full border">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Pay Date</th>
                        <th class="px-4 py-2">Amount</th>
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
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold">Summary</h2>
            <p>Pay Stub No.: {{ $paystub->stubno }}</p>
            <p>Net Pay: ${{ number_format($paystub->netpayamount, 2) }}</p>
            <p>YTD Net Pay: ${{ number_format($paystub->netpayamount + ($totalPrevOwnerDraws ?? 0), 2) }}</p>
        </div>
    </div>
</div>
@endsection
