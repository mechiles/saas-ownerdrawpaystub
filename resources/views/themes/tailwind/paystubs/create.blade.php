@extends('theme::layouts.app')

@section('content')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Owner Draw Pay Stub</h1>

    <form action="{{ route('paystubs.preview') }}" method="POST" class="space-y-8" onsubmit="return updateHiddenNetPay()">
        @csrf

        <!-- Step 1: Company Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 1: Company Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="companyname" class="border p-2 w-full rounded" placeholder="Company Name" required>
                <input type="text" name="einno" class="border p-2 w-full rounded" placeholder="EIN No." required>
                <input type="text" name="companyphone" class="border p-2 w-full rounded" placeholder="Phone No." required>
                <input type="text" name="companystreet" class="border p-2 w-full col-span-2 rounded" placeholder="Company Address" required>
                <input type="text" name="companycity" class="border p-2 w-full rounded" placeholder="Company City" required>
                <select name="companystate" class="border p-2 w-full rounded" required>
                    <!-- Add options for states -->
                    <option value="">-- Select a State --</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>

                </select>
                <input type="text" name="companyzip" class="border p-2 w-full rounded" placeholder="Company Zip Code" required>
                <input type="text" name="companycountry" class="border p-2 w-full rounded" value="United States" required readonly>
            </div>
        </div>

        <!-- Step 2: Employee Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 2: Employee Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="firstname" class="border p-2 w-full rounded" placeholder="First name" required>
                <input type="text" name="middlename" class="border p-2 w-full rounded" placeholder="Middle name">
                <input type="text" name="lastname" class="border p-2 w-full rounded" placeholder="Last name" required>
                <input type="text" name="street" class="border p-2 w-full col-span-3 rounded" placeholder="Street Address" required>
                <input type="text" name="city" class="border p-2 w-full rounded" placeholder="City" required>
                <select name="state" class="border p-2 w-full rounded" required>
                    <!-- Add options for states -->
                    <option value="">-- Select a State --</option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>

                </select>
                <input type="text" name="zip" class="border p-2 w-full rounded" placeholder="Zip" required>
                <input type="text" name="country" class="border p-2 w-full rounded" value="United States" required readonly>
                <input type="text" name="ssn" class="border p-2 w-full rounded" placeholder="SSN Last Four" required>
                <input type="text" name="title" class="border p-2 w-full rounded" placeholder="Job Title" required>
                <input type="text" name="employeeid" class="border p-2 w-full rounded" placeholder="Employee ID" required>
                <input type="email" name="email" class="border p-2 w-full col-span-3 rounded" placeholder="Email Address" required>
            </div>
        </div>

        <!-- Step 3: Owner Draw Pay Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 3: Enter your owner draw pay information</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="date" name="paystartday" class="border p-2 w-full rounded" placeholder="Pay Period Start" required>
                <input type="date" name="payendday" class="border p-2 w-full rounded" placeholder="Pay Period End" required>
                <input type="date" name="payday" class="border p-2 w-full rounded" placeholder="Pay Date" required>
                <input type="number" id="grossIncome" name="grossincome" class="border p-2 w-full rounded" placeholder="Pay amount" required>
                <input type="text" name="stubno" class="border p-2 w-full col-span-4 rounded" placeholder="Pay Stub Number" required>
            </div>
        </div>

        <!-- Step 4: Previous Owner Draws -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Step 4: Enter your previous owner draws (optional)</h2>
            <div id="previous-owner-draws" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="date" name="prevpayday[]" class="border p-2 w-full rounded" placeholder="Prev. Pay Date">
                    <input type="number" name="ownerdrawamount[]" class="border p-2 w-full pay-amount rounded" placeholder="Prev. Pay Amount" onkeyup="Calculator()">
                </div>
            </div>
            <button type="button" class="mt-4 bg-green-500 text-white px-4 py-2 rounded" onclick="addPreviousOwnerDraw()">Add Previous Owner Draws</button>
        </div>

        <!-- Net Pay and YTD Net Pay -->
        <div class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" id="netPayAmount" name="netpayamount" class="border p-2 w-full rounded" style="background-color: #ADD8E6;" placeholder="Net Pay" readonly>
                <input type="text" id="ytdNetPayAmount" class="border p-2 w-full rounded" style="background-color: rgb(196, 173, 43);" placeholder="YTD Net Pay" readonly>
            </div>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Preview Pay Stub</button>
    </form>
</div>

<script>
function addPreviousOwnerDraw() {
    const container = document.getElementById('previous-owner-draws');
    const newRow = document.createElement('div');
    newRow.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2', 'gap-4');
    newRow.innerHTML = `
        <input type="date" name="prevpayday[]" class="border p-2 w-full" placeholder="Prev. Pay Date">
        <input type="number" class="border p-2 w-full pay-amount" name="ownerdrawamount[]" placeholder="Prev. Pay Amount" onkeyup="Calculator()">
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
</script>
@endsection
