<?php
    use function Laravel\Folio\{middleware, name};

	middleware('auth');
    name('products');
?>
<x-layouts.app>
    <x-app.container x-data="{ hours: 1, basePrice: {{$server['hourly_price']}}, serviceCharge: 5, trnxId: '' }" x-cloak>
        
        <x-app.heading
            title="Confirm Your Server Order"
            description="Specify the necessary hours and transaction details to complete your purchase."
            :border="false"
        />

        <div class="mt-5 space-y-5">
            <div class="flex flex-col overflow-hidden relative p-6 w-full max-w-lg mx-auto bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-slate-200 dark:border-zinc-700">
                
                <!-- Server Information -->
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">{{$server['server_name']}}</h3>
                <ul class="text-gray-700 dark:text-gray-300 space-y-1 mb-4">
                    <li><b>vCPU:</b> {{$server['vcpu']}}</li>
                    <li><b>RAM:</b> {{$server['ram']}} GB</li>
                    <li><b>Disk Storage:</b> {{$server['disk_storage']}} GB</li>
                </ul>

                <!-- Hours Input and Calculation -->
                <label class="block text-lg font-medium text-gray-800 dark:text-gray-300 mb-2" for="hours">Enter Hours:</label>
                <input type="number" id="hours" x-model.number="hours" min="1" class="p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" />

                <!-- Price Calculation Display -->
                <div class="mt-4 text-lg font-medium text-gray-700 dark:text-gray-300">
                    <p><b>Base Price:</b> <span x-text="(basePrice * hours).toFixed(2)"></span> BDT</p>
                    <p><b>Service Charge:</b> <span x-text="serviceCharge"></span> BDT</p>
                    <p class="mt-2 text-xl font-semibold text-gray-900 dark:text-white"><b>Total Price:</b> <span x-text="((basePrice * hours) + serviceCharge).toFixed(2)"></span> BDT</p>
                </div>

                <!-- Transaction ID Input -->
                <label class="block mt-6 text-lg font-medium text-gray-800 dark:text-gray-300" for="trnxId">bKash Transaction ID:</label>
                <input type="text" id="trnxId" x-model="trnxId" placeholder="Enter your bKash Transaction ID" class="p-2 w-full border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" />

                <!-- Confirm Order Button -->
                <button @click="confirmOrder" :disabled="!trnxId || hours < 1" class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 ease-in-out shadow-sm hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed">
                    Confirm Order
                </button>
            </div>
        </div>
    </x-app.container>

    <script>
        function confirmOrder() {
            // Handle the order confirmation (could include form submission or AJAX request)
            alert('Order confirmed with ' + this.trnxId + ' for ' + this.hours + ' hours.');
        }
    </script>
</x-layouts.app>
