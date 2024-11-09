<?php
    use function Laravel\Folio\{middleware, name};
    middleware('auth');
    name('products');
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

        <div class="mt-5 space-y-5">
            <a href="/server/buy" class="inline-block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Buy Server</a>
            <p>We are handling the payment part manually.</p>
            <ul type='disc'>
                <li>First Pay for the server you want. Or you can buy a server in advance.</li>
                <li>Within 1 hour we will verify your payment.</li>
                <li>Once verified, you can spin up any server you have purchased.</li>
            </ul>

            <!-- List of Purchased Servers -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Purchased Servers</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @php
                        $servers = auth()->user()->servers; // Assuming you have a relationship `servers()` on the User model
                    @endphp

                    @foreach ($servers as $server)
                    <div class="flex flex-col overflow-hidden p-6 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-slate-200 dark:border-zinc-700">
                        <h4 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">{{$server->server_name}}</h4>
                        <ul class="text-gray-700 dark:text-gray-300 space-y-1">
                            <li><b>vCPU:</b> {{$server->vcpu}}</li>
                            <li><b>RAM:</b> {{$server->ram}} GB</li>
                            <li><b>Disk Storage:</b> {{$server->disk_storage}} GB</li>
                        </ul>
                        <p class="mt-4 text-lg font-medium text-gray-700 dark:text-gray-300">
                            <b>Status:</b> {{$server->status}} <!-- You can use status to show if it's active or not -->
                        </p>

                        <!-- Button to Spin Up the Server -->
                        @if($server->status !== 'active')
                            <a href="/server/spin-up/{{$server->id}}" class="mt-6 bg-blue-600 hover:bg-blue-700 text-center text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 ease-in-out shadow-sm hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Spin Up Server
                            </a>
                        @else
                            <button disabled class="mt-6 w-full bg-green-600 text-white font-bold py-2 px-4 rounded-lg opacity-50 cursor-not-allowed">
                                Server Active
                            </button>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </x-app.container>
</x-layouts.app>
