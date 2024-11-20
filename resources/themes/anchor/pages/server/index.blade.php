<?php
    use function Laravel\Folio\{middleware, name};
    use Livewire\Volt\Component;
    use App\Controllers;
    use App\Factories\Server\VultrServerFactory;
    use App\Models\Product;
    middleware('auth');
    name('products');

    new class extends Component {


        public $verifiedProducts = [];
        public $unverifiedProducts = [];
        public $loadingProducts = [];

        public function mount()
        {
            $user = auth()->user();

            $products = $user->products()
                        ->whereNull('provisioned_at')
                        ->with('server')
                        ->get();

            $this->verifiedProducts = $products->whereNotNull('verified_at')->values();
            $this->unverifiedProducts = $products->whereNull('verified_at')->values();
        }


        function spinUpServer($product) : void {

            $this->loadingProducts[$product['id']] = true;
            
            try {

                $getProvider = new VultrServerFactory();
                $_server = $getProvider->createServer();
                $_server->setData($product);
                $_server->provision();

                session()->flash('success', 'Server spun up successfully!');
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to spin up the server. Try again.');
            } finally {
                unset($this->loadingProducts[$product['id']]); // Remove from loading state once done
            }
        }
    }
?>

<x-layouts.app>
    <x-app.container x-data class="lg:space-y-6" x-cloak>

        <x-app.alert id="dashboard_alert" class="hidden lg:flex">
            This is the user dashboard where users can manage settings and access features. 
            <a href="https://devdojo.com/wave/docs" target="_blank" class="mx-1 underline">View the docs</a> to learn more.
        </x-app.alert>

        <x-app.heading
            title="Your Servers"
            description="Here are the servers you've bought. You can spin up a server anytime you need."
            :border="false"
        />
        @volt
        <div class="mt-5 space-y-5">
            <a href="/server/buy" class="inline-block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Buy Server</a>
            <p>We are handling the payment part manually.</p>
            <ul class="list-disc list-inside text-gray-700 dark:text-gray-300 mt-2">
                <li>First, pay for the server you want. You can also buy a server in advance.</li>
                <li>Verification will be completed within 1 hour.</li>
                <li>Once verified, you can spin up any server you have purchased.</li>
            </ul>

            <!-- List of Purchased Servers -->
            {{-- @php
                $servers = auth()
                    ->user()
                    ->products()
                    ->join('servers', 'products.server_id', '=', 'servers.id')
                    ->get();
                $verifiedServers = $servers->where('verified_at', '!=', null);
                $unverifiedServers = $servers->where('verified_at', null);
            @endphp --}}

            <div class="mt-8 space-y-8">
                <!-- Verified Servers Section -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Verified Servers</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">These servers are ready to be spun up.</p>
                    <ul class="divide-y divide-slate-200 dark:divide-zinc-700 mt-4">
                        @foreach ($verifiedProducts as $product)
                        <li class="flex justify-between items-center py-4 px-6 bg-white dark:bg-zinc-800 rounded-lg shadow-sm">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">{{$product->server->server_name}}</h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <b>vCPU:</b> {{$product->server->vcpu}} | 
                                    <b>RAM:</b> {{$product->server->ram}} GB | 
                                    <b>Disk Storage:</b> {{$product->server->disk_storage}} GB
                                </p>
                                <p class="text-gray-700 dark:text-gray-300 mt-1">
                                    <b>Status:</b> {{$product->server->status}}
                                </p>
                            </div>
                            {{-- <a href="/server/spin-up/{{$server->id}}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 ease-in-out shadow-sm">
                                Spin Up Server
                            </a> --}}
                            <button
                                wire:click="spinUpServer({{ $product}})"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 ease-in-out shadow-sm flex items-center justify-center"
                                @if (isset($loadingServers[$product->id])) disabled @endif
                            >
                                @if (isset($loadingServers[$product->id]))
                                    <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    Spinning Up...
                                @else
                                    Spin Up Server
                                @endif
            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Unverified Servers Section -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Unverified Servers</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">These servers will be verified by the admin soon.</p>
                    <ul class="divide-y divide-slate-200 dark:divide-zinc-700 mt-4">
                        @foreach ($unverifiedProducts as $server)
                        <li class="flex justify-between items-center py-4 px-6 bg-gray-100 dark:bg-zinc-900 rounded-lg shadow-sm opacity-75">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">{{$server->server_name}}</h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    <b>vCPU:</b> {{$server->vcpu}} | 
                                    <b>RAM:</b> {{$server->ram}} GB | 
                                    <b>Disk Storage:</b> {{$server->disk_storage}} GB
                                </p>
                                <p class="text-red-600 dark:text-red-400 mt-1">
                                    <b>Status:</b> Awaiting Verification
                                </p>
                            </div>
                            <button disabled class="bg-gray-500 text-white font-bold py-2 px-4 rounded-lg opacity-50 cursor-not-allowed">
                                Spin Up Not Available
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endvolt
    </x-app.container>
</x-layouts.app>
