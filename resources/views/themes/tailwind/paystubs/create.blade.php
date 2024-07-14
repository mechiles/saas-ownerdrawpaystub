@extends('theme::layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Owner Draw Pay Stub</h1>

    <form action="{{ route('paystubs.preview') }}" method="POST" class="space-y-8" onsubmit="return updateHiddenNetPay()">
        @csrf

        <!-- Step 1: Company Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 1: Company Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="companyname" class="border p-2 w-full rounded" placeholder="Company Name" value="{{ old('companyname', $data['companyname'] ?? '') }}" required>
                <input type="text" name="einno" class="border p-2 w-full rounded" placeholder="EIN No." value="{{ old('einno', $data['einno'] ?? '') }}" required>
                <input type="text" name="companyphone" class="border p-2 w-full rounded" placeholder="Phone No." value="{{ old('companyphone', $data['companyphone'] ?? '') }}" required>
                <input type="text" name="companystreet" class="border p-2 w-full col-span-2 rounded" placeholder="Company Address" value="{{ old('companystreet', $data['companystreet'] ?? '') }}" required>
                <input type="text" name="companycity" class="border p-2 w-full rounded" placeholder="Company City" value="{{ old('companycity', $data['companycity'] ?? '') }}" required>
                <select name="companystate" class="border p-2 w-full rounded" required>
                    <option value="">-- Select a State --</option>
                    @foreach(['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'] as $state)
                        <option value="{{ $state }}" @if(old('companystate', $data['companystate'] ?? '') == $state) selected @endif>{{ $state }}</option>
                    @endforeach
                </select>
                <input type="text" name="companyzip" class="border p-2 w-full rounded" placeholder="Company Zip Code" value="{{ old('companyzip', $data['companyzip'] ?? '') }}" required>
                <input type="text" name="companycountry" class="border p-2 w-full rounded" value="United States" readonly>
            </div>
        </div>

        <!-- Step 2: Employee Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 2: Employee Information</h2>
            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                <input type="text" name="firstname" class="border p-2 w-full rounded" placeholder="First name" value="{{ old('firstname', $data['firstname'] ?? '') }}" required>
                <input type="text" name="middlename" class="border p-2 w-full rounded" placeholder="Middle name" value="{{ old('middlename', $data['middlename'] ?? '') }}">
                <input type="text" name="lastname" class="border p-2 w-full rounded" placeholder="Last name" value="{{ old('lastname', $data['lastname'] ?? '') }}" required>
                <input type="text" name="street" class="border p-2 w-full col-span-2 rounded" placeholder="Street Address" value="{{ old('street', $data['street'] ?? '') }}" required>
                <input type="text" name="city" class="border p-2 w-full rounded" placeholder="City" value="{{ old('city', $data['city'] ?? '') }}" required>
                <select name="state" class="border p-2 w-full rounded" required>
                    <option value="">-- Select a State --</option>
                    @foreach(['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'] as $state)
                        <option value="{{ $state }}" @if(old('state', $data['state'] ?? '') == $state) selected @endif>{{ $state }}</option>
                    @endforeach
                </select>
                <input type="text" name="zip" class="border p-2 w-full rounded" placeholder="Zip" value="{{ old('zip', $data['zip'] ?? '') }}" required>
                <input type="text" name="country" class="border p-2 w-full rounded" value="United States" readonly>
                <input type="text" name="ssn" class="border p-2 w-full rounded" placeholder="SSN Last Four" value="{{ old('ssn', $data['ssn'] ?? '') }}" required>
                <input type="text" name="title" class="border p-2 w-full rounded" placeholder="Job Title" value="{{ old('title', $data['title'] ?? '') }}" required>
                <input type="text" name="employeeid" class="border p-2 w-full rounded" placeholder="Employee ID" value="{{ old('employeeid', $data['employeeid'] ?? '') }}" required>
                <input type="email" name="email" class="border p-2 w-full col-span-1 rounded" placeholder="Email Address" value="{{ old('email', $data['email'] ?? '') }}" required>
            </div>
        </div>

        <!-- Step 3: Owner Draw Pay Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 3: Enter your owner draw pay information</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="paystartday" class="block text-md font-medium text-gray-700">Pay Period Start Date</label>
                    <input type="date" name="paystartday" class="border p-2 w-full rounded" value="{{ old('paystartday', $data['paystartday'] ?? '') }}" required>
                </div>
                <div>
                    <label for="payendday" class="block text-md font-medium text-gray-700">Pay Period End Date</label>
                    <input type="date" name="payendday" class="border p-2 w-full rounded" value="{{ old('payendday', $data['payendday'] ?? '') }}" required>
                </div>
                <div>
                    <label for="payday" class="block text-md font-medium text-gray-700">Pay Date</label>
                    <input type="date" name="payday" class="border p-2 w-full rounded" value="{{ old('payday', $data['payday'] ?? '') }}" required>
                </div>
                <div>
                    <label for="grossIncome" class="block text-md font-medium text-gray-700">Pay Amount</label>
                    <input type="number" id="grossIncome" name="grossincome" class="border p-2 w-full rounded" placeholder="Pay amount" value="{{ old('grossincome', $data['grossincome'] ?? '') }}" required>
                </div>
                <div>
                    <label for="stubno" class="block text-md font-medium text-gray-700">Pay Stub Number</label>
                    <input type="text" name="stubno" class="border p-2 w-full col-span-4 rounded" placeholder="Pay Stub Number" value="{{ old('stubno', $data['stubno'] ?? '') }}" required>
                </div>
            </div>
        </div>

        <!-- Step 4: Previous Owner Draws -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 4: Enter your previous owner draws (optional)</h2>
            <div id="previous-owner-draws" class="space-y-4">
                @if (old('prevpayday', $data['prevpayday'] ?? []))
                    @foreach (old('prevpayday', $data['prevpayday'] ?? []) as $index => $prevpayday)
                        <div class="flex previous-owner-draw-row">
                            <div class="mb-4 mr-5">
                                <label for="prevpayday" class="block text-md font-medium text-gray-700">Previous Pay Date</label>
                                <input type="date" name="prevpayday[]" class="border p-2 w-full rounded" value="{{ $prevpayday }}">
                            </div>
                            <div class="mb-4">
                                <label for="ownerdrawamount" class="block text-md font-medium text-gray-700">Previous Pay Amount</label>
                                <input type="number" name="ownerdrawamount[]" class="border p-2 w-full pay-amount rounded" value="{{ old('ownerdrawamount.' . $index, $data['ownerdrawamount'][$index] ?? '') }}" onkeyup="Calculator()">
                            </div>
                            <a href="#" class="remove_field" align="center"><i class="fa fa-trash-o" id="remove_field" style="font-size:24px;color:red;"></i></a>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="mt-4 bg-green-500 text-white px-4 py-2 rounded" onclick="addPreviousOwnerDraw()">Add Previous Owner Draws</button>
        </div>

        <!-- Net Pay and YTD Net Pay -->
        <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="netPayAmount" class="block text-md font-medium text-gray-700">Current Net Pay</label>
                    <input type="text" id="netPayAmount" name="netpayamount" class="border p-2 w-full rounded" placeholder="Current Net Pay" value="{{ old('netpayamount', $data['netpayamount'] ?? '') }}" readonly>
                </div>
                <div>
                    <label for="ytdNetPayAmount" class="block text-md font-medium text-gray-700">YTD Net Pay</label>
                    <input type="text" id="ytdNetPayAmount" name="ytdnetpayamount" class="border p-2 w-full rounded" placeholder="YTD Net Pay" value="{{ old('ytdnetpayamount', $data['ytdNetPay'] ?? '') }}" readonly>
                </div>
            </div>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Preview Pay Stub</button>
    </form>
</div>

<script>
function addPreviousOwnerDraw() {
    const container = document.getElementById('previous-owner-draws');
    const newRow = document.createElement('div');
    newRow.classList.add('flex', 'previous-owner-draw-row');
    newRow.innerHTML = `
        <div class="mb-4 mr-5">
            <label for="prevpayday" class="block text-md font-medium text-gray-700">Previous Pay Date</label>
            <input type="date" name="prevpayday[]" class="border p-2 w-full rounded" placeholder="Prev. Pay Date">
        </div>
        <div class="mb-4">
            <label for="ownerdrawamount" class="block text-md font-medium text-gray-700">Previous Pay Amount</label>
            <input type="number" name="ownerdrawamount[]" class="border p-2 w-full pay-amount rounded" placeholder="Previous Pay Amount" onkeyup="Calculator()">
        </div>
        <a href="#" class="remove_field" align="center"><i class="fa fa-trash-o" id="remove_field" style="font-size:24px;color:red;"></i></a>
    `;
    container.appendChild(newRow);
}

function Calculator() {
    var grossIncome = parseFloat(document.getElementById("grossIncome").value) || 0;

    // Set Net Pay to the current paystub's amount
    $('#netPayAmount').val(grossIncome);
    $('#hiddenNetPayAmount').val(grossIncome); // Set hidden input value

    // Calculate YTD Net Pay by adding previous owner draw amounts
    var ytdNetPay = grossIncome;
    $('.pay-amount').each(function () {
        ytdNetPay += parseFloat(this.value) || 0;
    });

    $('#ytdNetPayAmount').val(ytdNetPay);
    $('#hiddenYtdNetPayAmount').val(ytdNetPay); // Ensure hidden input value is updated
}

function updateHiddenNetPay() {
    var grossIncome = parseFloat(document.getElementById("grossIncome").value) || 0;
    $('#hiddenNetPayAmount').val(grossIncome); // Ensure hidden input value is updated before form submission
    return true; // Ensure the form is submitted
}

document.getElementById('grossIncome').addEventListener('input', Calculator);

$(document).on('input', '.pay-amount', function() {
    Calculator();
});

$(document).ready(function() {
    var wrapper = $(".input_fields_wrap");
    var add_button = $(".add_field_button");
    $(add_button).click(function(e) {
        e.preventDefault();
        $(wrapper).append('<div class="flex previous-owner-draw-row">\
            <div class="mb-4 mr-5" id="holder">\
                <small id="label" for="input">Prev. Pay Date</small>\
                <input type="date" class="block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="prevpayday[]" placeholder="mm/dd/yyyy" id="datepicker">\
            </div>\
            <div class="mb-4">\
                <small id="label" for="input">Prev. Pay Amount</small>\
                <input type="text" class="block w-full border border-gray-400 p-2 rounded pay-amount" name="ownerdrawamount[]" id="ownerdrawamount[]" placeholder="Owner Draw amount"/ onkeyup="Calculator()">\
            </div>\
            <a href="#" class="remove_field" align="center"><i class="fa fa-trash-o" id="remove_field" style="font-size:24px;color:red;"></i></a>\
            </div>');
    });
    //user click on remove text
    $(wrapper).on("click", ".remove_field", function(e) {
        e.preventDefault();
        $(this).parent('.previous-owner-draw-row').remove();
        // Called Calculator function to make changes
        Calculator();
    })
});
</script>

@endsection
