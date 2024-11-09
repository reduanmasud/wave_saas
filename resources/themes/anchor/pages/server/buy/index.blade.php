<?php
    use function Laravel\Folio\{middleware, name};
    use App\Models\Server;
	middleware('auth');
    name('products');
?>

<x-layouts.app>
	<x-app.container x-data class="lg:space-y-6" x-cloak>
        
		<x-app.alert id="dashboard_alert" class="hidden lg:flex">This is the user dashboard where users can manage settings and access features. <a href="https://devdojo.com/wave/docs" target="_blank" class="mx-1 underline">View the docs</a> to learn more.</x-app.alert>

        <x-app.heading
                title="Buy A Server"
                description="Welcomde to an example application product. A content about product will go here.."
                :border="false"
            />

        <div class="flex flex-col w-full mt-6 space-y-5 md:flex-row lg:mt-0 md:space-y-0 md:space-x-5">

        </div>

		<div class="flex flex-col w-full mt-5 space-y-5 md:flex-row md:space-y-0 md:mb-0 md:space-x-5">
			
		</div>

		<div class="mt-5 space-y-5">
			
            <div class="grid grid-cols-3 gap-4 ">
                @php
                    $servers = Server::all();
                @endphp
                @foreach ($servers as $server)
                <div class="flex flex-col overflow-hidden relative p-6 w-full max-w-sm bg-white dark:bg-zinc-800 rounded-lg shadow-lg border transition-transform duration-300 ease-out group border-slate-200 dark:border-zinc-700 hover:scale-105">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">{{$server['server_name']}}</h3>
                    
                    <ul class="text-gray-700 dark:text-gray-300 space-y-1">
                        <li><b>vCPU:</b> {{$server['vcpu']}}</li>
                        <li><b>RAM:</b> {{$server['ram']}} GB</li>
                        <li><b>Disk Storage:</b> {{$server['disk_storage']}} GB</li>
                    </ul>
            
                
                    <p class="text-lg font-medium text-gray-700 dark:text-gray-300 mt-4">
                        <b>Price:</b> {{$server['hourly_price']}} BDT/hr
                    </p>
                
                    <a href="/server/buy/{{$server['id']}}" class="mt-6 bg-blue-600 hover:bg-blue-700 text-center text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200 ease-in-out shadow-sm hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Select
                    </a>
                </div>
                
                @endforeach
            </div>

			{{-- @subscriber
				<p>You are a subscribed user with the <strong>{{ auth()->user()->roles()->first()->name }}</strong> role. Learn <a href="https://devdojo.com/wave/docs/features/roles-permissions" target="_blank" class="underline">more about roles</a> here.</p>
				<x-app.message-for-subscriber />
			@else
				<p>This current logged in user has a <strong>{{ auth()->user()->roles()->first()->name }}</strong> role. To upgrade, <a href="{{ route('settings.subscription') }}" class="underline">subscribe to a plan</a>. Learn <a href="https://devdojo.com/wave/docs/features/roles-permissions" target="_blank" class="underline">more about roles</a> here.</p>
			@endsubscriber
			
			@admin
				<x-app.message-for-admin />
			@endadmin --}}
		</div>
    </x-app.container>
</x-layouts.app>
