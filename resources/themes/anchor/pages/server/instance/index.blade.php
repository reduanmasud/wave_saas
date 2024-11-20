<?php
    use function Laravel\Folio\{middleware, name};
    use App\Models\Project;
    use Livewire\Volt\Component;
    middleware('auth');
    name('instances');

    new class extends Component{
        public $instances;

        public function mount()
        {
            $user = auth()->user();
            
            $this->instances = $user->instances()
                                ->with('product')
                                ->get()
                                ->map(function ($instance) {
                                    $instance->end_date = $this->calculateEndDate(
                                        $instance->product->provisioned_at,
                                        $instance->product->durations
                                    );
                                    return $instance;
                                });

        }

        public function deleteProject(Project $project)
        {
            // $project->delete();
            // $this->projects = auth()->user()->projects()->latest()->get();
        }

        public function calculateEndDate($date, $duration)
    {
        if (!$date) {
            return 'N/A';
        }

        $d = new DateTime($date);
        $d->modify("+$duration days");
        return $d->format('Y-m-d H:i:s');
    }
    }
?>

<x-layouts.app>
    @volt('projects')
        <x-app.container>

            <div class="flex items-center justify-between mb-5">
                <x-app.heading
                        title="Instances"
                        description="Check out your projects below"
                        :border="false"
                    />
                {{-- <x-button tag="a" href="/projects/create">New Project</x-button> --}}
            </div>

            @if($instances->isEmpty())
                <div class="w-full p-20 text-center bg-gray-100 rounded-xl">
                    <p class="text-gray-500">You don't have any projects yet.</p>
                </div>
            @else
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full bg-white">
                        <thead class="text-sm bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Start Date</th>
                                <th class="px-4 py-2 text-left">End Date</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instances as $instance)
                                {{-- @dd($instance->server->server_name); --}}
                                <tr>
                                    <td class="px-4 py-2">{{ $instance->server->server_name }}</td>
                                    <td class="px-4 py-2">{{ $instance->product->provisioned_at ? $instance->product->provisioned_at->format('Y-m-d') : 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $instance->end_date }}</td>
                                    <td class="px-4 py-2">
                                        {{-- <a href="/project/edit/{{ $project->id }}" class="mr-2 text-blue-500 hover:underline">Edit</a> --}}
                                        {{-- <button wire:click="deleteProject({{ $project->id }})" class="text-red-500 hover:underline">Delete</button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-app.container>
    @endvolt
</x-layouts.app>
