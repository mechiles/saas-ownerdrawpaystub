@extends('theme::layouts.app')

@section('content')

<?php
$data = session()->all();
$user = Auth::user()->id;
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <div class="flex flex-col justify-start flex-1 mb-5 overflow-hidden bg-white border rounded-lg border-gray-150">
            <div class="flex flex-wrap items-center justify-between p-5 bg-white border-b border-gray-150 sm:flex-no-wrap">
                <div class="flex items-center justify-center w-12 h-12 mr-5 rounded-lg bg-wave-100">
                    <svg class="w-6 h-6 text-wave-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="relative flex-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-700">
                        Welcome to your Dashboard, {{ Auth::user()->name }}. Your user ID is {{ Auth::user()->id }}.
                    </h3>
                </div>
            </div>
            <div class="relative p-5">
                <h3 class="text-lg font-medium leading-6 text-gray-700">
                    Get started below!
                </h3>
                <span class="inline-flex mt-5 rounded-md shadow-sm">
                    <a href="{{ url('paystubs/create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">
                    Click Here To Create a New Paystub</a>
                </span>
            </div>
        </div>
    </div>

    <div class="flex flex-col justify-start flex-1 overflow-hidden bg-white border rounded-lg border-gray-150">
        <div class="flex flex-wrap items-center justify-between p-5 bg-white border-b border-gray-150 sm:flex-no-wrap">
            <div class="flex items-center justify-center w-12 h-12 mr-5 rounded-lg bg-wave-100">
                <svg class="w-6 h-6 text-wave-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                </svg>
            </div>
            <div class="relative flex-1">
                <h3 class="text-lg font-medium leading-6 text-gray-700">
                    Below are your generated paystubs:
                </h3>
            </div>
        </div>
        <div class="relative p-5">
            <div class="container mx-auto px-4 py-8">
                <?php
                $paystubs = DB::table('paystubs')->where('user_id', $user)->orderBy('created_at', 'desc')->get();
                if(count($paystubs) == 0) {
                    echo '<p class="text-sm leading-5 text-gray-500 mt">You haven\'t created any paystubs, yet.</p>';
                } else {
                ?>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200 text-gray-600">
                        <tr>
                            <th class="py-2 px-4 border">Paystub No</th>
                            <th class="py-2 px-4 border">Employee Name</th>
                            <th class="py-2 px-4 border">Pay Date</th>
                            <th class="py-2 px-4 border">Pay Amount</th>
                            <th class="py-2 px-4 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paystubs as $paystub)
                        <tr class="text-gray-700">
                            <td class="py-2 px-4 border">{{ $paystub->stubno }}</td>
                            <td class="py-2 px-4 border">{{ $paystub->firstname }} {{ $paystub->lastname }}</td>
                            <td class="py-2 px-4 border">{{ $paystub->payday }}</td>
                            <td class="py-2 px-4 border">${{ number_format($paystub->netpayamount, 2) }}</td>
                            <td class="py-2 px-4 border">
                                <a href="{{ url('paystubs/' . $paystub->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 mr-2">View Paystub</a>
                                <a href="{{ route('paystubs.print', ['id' => $paystub->id]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-blue-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50">Print Paystub</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
@endsection
