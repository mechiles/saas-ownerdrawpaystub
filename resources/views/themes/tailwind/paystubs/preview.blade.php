@extends('theme::layouts.app')

@section('content')
<!-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Owner Draw Pay Stub Preview</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <h2 class="text-lg font-semibold">Company Information</h2>
            <p>{{ $data['companyname'] }}</p>
            <p>{{ $data['companystreet'] }}</p>
            <p>{{ $data['companycity'] }}, {{ $data['companystate'] }} {{ $data['companyzip'] }} {{ $data['companycountry'] }}</p>
            <p>PHONE: {{ $data['companyphone'] }}</p>
            <p>EIN: {{ $data['einno'] }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold">Employee Information</h2>
            <p>{{ $data['firstname'] }} {{ $data['middlename'] }} {{ $data['lastname'] }}</p>
            <p>{{ $data['street'] }}</p>
            <p>{{ $data['city'] }}, {{ $data['state'] }} {{ $data['zip'] }} {{ $data['country'] }}</p>
            <p>Social Sec. No.: xxx-xx-{{ substr($data['ssn'], -4) }}</p>
            <p>Position: {{ $data['title'] }}</p>
            <p>Email: {{ $data['email'] }}</p>
        </div>
        <div>
            <h2 class="text-lg font-semibold">Pay Information</h2>
            <p>Pay Period: {{ $data['paystartday'] }} - {{ $data['payendday'] }}</p>
            <p>Pay Date: {{ $data['payday'] }}</p>
            <br />
            <h2 class="text-lg font-semibold">Summary</h2>
            <p>Net Pay: ${{ number_format($data['netpayamount'], 2) }}</p>
            <p>YTD Net Pay: ${{ number_format($data['ytdNetPay'], 2) }}</p>
        </div>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Current Earnings</h2>
        <table class="table-auto w-full border-separate">
        <thead>
            <tr class="bg-blue-500 text-white">
                <th class="px-4 py-2 w-1/3 rounded">Description</th>
                <th class="px-4 py-2 w-1/3 rounded">Pay Date</th>
                <th class="px-4 py-2 w-1/3 rounded">Current Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2 w-1/3 rounded">Owner's Draw</td>
                <td class="border px-4 py-2 w-1/3 rounded">{{ $data['payday'] }}</td>
                <td class="border px-4 py-2 w-1/3 rounded">${{ number_format($data['grossincome'], 2) }}</td>
            </tr>
        </tbody>
    </table>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">YTD Earnings</h2>
        <table class="table-auto w-full border-separate">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="px-4 py-2 w-1/3 rounded">Description</th>
                    <th class="px-4 py-2 w-1/3 rounded">Pay Date</th>
                    <th class="px-4 py-2 w-1/3 rounded">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($data['prevpayday']) && !empty($data['ownerdrawamount']))
                    @foreach ($data['prevpayday'] as $index => $prevpayday)
                        @if (!empty($prevpayday) && isset($data['ownerdrawamount'][$index]) && $data['ownerdrawamount'][$index] > 0)
                            <tr>
                                <td class="border px-4 py-2 w-1/3 rounded">Owner's Draw</td>
                                <td class="border px-4 py-2 w-1/3 rounded">{{ $prevpayday }}</td>
                                <td class="border px-4 py-2 w-1/3 rounded">${{ number_format($data['ownerdrawamount'][$index], 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                <tr>
                    <td class="border px-4 py-2 rounded">Owner's Draw</td>
                    <td class="border px-4 py-2 rounded">{{ $data['payday'] }}</td>
                    <td class="border px-4 py-2 rounded">${{ number_format($data['grossincome'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        
    </div>

    <div class="flex space-x-4 mt-4">
        <form action="{{ route('paystubs.create') }}" method="GET">
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">Edit</button>
        </form>
        <form action="{{ route('paystubs.store') }}" method="POST">
            @csrf
            <input type="hidden" name="companyname" value="{{ $data['companyname'] }}">
            <input type="hidden" name="einno" value="{{ $data['einno'] }}">
            <input type="hidden" name="companyphone" value="{{ $data['companyphone'] }}">
            <input type="hidden" name="companystreet" value="{{ $data['companystreet'] }}">
            <input type="hidden" name="companycity" value="{{ $data['companycity'] }}">
            <input type="hidden" name="companystate" value="{{ $data['companystate'] }}">
            <input type="hidden" name="companyzip" value="{{ $data['companyzip'] }}">
            <input type="hidden" name="companycountry" value="{{ $data['companycountry'] }}">
            <input type="hidden" name="firstname" value="{{ $data['firstname'] }}">
            <input type="hidden" name="middlename" value="{{ $data['middlename'] }}">
            <input type="hidden" name="lastname" value="{{ $data['lastname'] }}">
            <input type="hidden" name="street" value="{{ $data['street'] }}">
            <input type="hidden" name="city" value="{{ $data['city'] }}">
            <input type="hidden" name="state" value="{{ $data['state'] }}">
            <input type="hidden" name="zip" value="{{ $data['zip'] }}">
            <input type="hidden" name="country" value="{{ $data['country'] }}">
            <input type="hidden" name="ssn" value="{{ $data['ssn'] }}">
            <input type="hidden" name="title" value="{{ $data['title'] }}">
            <input type="hidden" name="employeeid" value="{{ $data['employeeid'] }}">
            <input type="hidden" name="email" value="{{ $data['email'] }}">
            <input type="hidden" name="paystartday" value="{{ $data['paystartday'] }}">
            <input type="hidden" name="payendday" value="{{ $data['payendday'] }}">
            <input type="hidden" name="payday" value="{{ $data['payday'] }}">
            <input type="hidden" name="grossincome" value="{{ $data['grossincome'] }}">
            <input type="hidden" name="stubno" value="{{ $data['stubno'] }}">
            <input type="hidden" name="netpayamount" value="{{ $data['netpayamount'] }}">
            @foreach ($data['prevpayday'] ?? [] as $index => $prevpayday)
                <input type="hidden" name="prevpayday[]" value="{{ $prevpayday }}">
                <input type="hidden" name="ownerdrawamount[]" value="{{ $data['ownerdrawamount'][$index] }}">
            @endforeach
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Pay Stub</button>
        </form>
    </div>
</div>
@endsection
