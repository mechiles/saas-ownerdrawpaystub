<div class="p-8">
    @if(auth()->user()->hasRole('admin'))
        <p>This user is an admin user and therefore does not need a subscription</p>
    @else

        @if (env('CASHIER_VENDOR') == 'stripe')
            <div class="flex flex-col">
                <h5 class="mb-2 text-xl font-semibold text-gray-700">Your active subscription is: <span class="font-normal underline">{{ auth()->user()->role->display_name }}</span></h5>
                {{-- <p class="text-wave-700">You are currently on a free plan or your plan is in trial mode</p> --}}
            </div>

            <hr class="my-8">
             @if(auth()->user()->hasRole('trial'))
              <div class="flex flex-col">
                <span>You have <b>{{ auth()->user()->trial_ends_at->diffInDays(now()) }} days left.</b></span>
                </div>
                <p class="text-gray-600">Please <a href="{{ route('wave.settings', 'plans') }}">Subscribe to a Plan</a> in order to keep your subscription after your trial.</p>
                        <a href="{{ route('wave.settings', 'plans') }}" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700">View Plans</a></p>    
            @else

            <div class="flex flex-col">
                <h5 class="mb-2 text-xl font-bold text-gray-700">Modify your Subscription</h5>
                <p>Click the button below to update your subscription or payment methods</p>
                <a href="{{ route('stripe.billing-portal') }}" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md checkout-update bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700">Update details</a>
            </div>
            @endif

           
        @else
            @if(auth()->user()->subscriber())
                @if (auth()->user()->subscription)
                    <div class="flex flex-col">
                        <h5 class="mb-2 text-xl font-bold text-gray-700">Modify Payment Information</h5>
                        <p>Click the button below to update your default payment method</p>
                        <button data-url="{{ auth()->user()->subscription->update_url }}" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md checkout-update bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700">Update Payment Info</button>
                    </div>
                    
                    <hr class="my-8 border-gray-200">
                    
                    <div class="flex flex-col">
                        <h5 class="mb-2 text-xl font-bold text-gray-700">Danger Zone</h5>
                        <p class="text-red-400">Click the button below to cancel your subscription.</p>
                        <p class="text-xs">Note: Your account will be immediately downgraded.</p>
                        <button onclick="document.getElementById('confirmCancel').__x.$data.open = true;" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-500 border border-transparent rounded-md hover:bg-red-600 focus:outline-none focus:border-red-600 focus:shadow-outline-red-500 active:bg-red-600">Cancel Subscription</button>
                    </div>    
                @else
                    <div class="flex flex-col">
                        <h5 class="mb-2 text-xl font-semibold text-gray-700">Your active subscription is: <span class="font-normal">{{ auth()->user()->role->display_name }}</span></h5>
                        {{-- <p class="text-wave-700">You are currently on a free plan or your plan is in trial mode</p> --}}
                    </div>    
                @endif

                @if (auth()->user()->subscription)
                    @include('theme::partials.cancel-modal')
                @endif
            @else
                <p class="text-gray-600">Please <a href="{{ route('wave.settings', 'plans') }}">Subscribe to a Plan</a> in order to see your subscription information.</p>
                <a href="{{ route('wave.settings', 'plans') }}" class="inline-flex self-start justify-center w-auto px-4 py-2 mt-5 text-sm font-medium text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-wave-600 hover:bg-wave-500 focus:outline-none focus:border-wave-700 focus:shadow-outline-wave active:bg-wave-700">View Plans</a>
            @endif
        @endif
    @endif
</div>
<script>
	window.cancelClicked = function(){
		Alpine.store('confirmCancel').openModal();
	}
</script>