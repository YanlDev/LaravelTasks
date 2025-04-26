<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <h1 class="text-4xl font-bold my-1 mx-1 p-2">Bienvenido al administrador de tareas!!</h1>
            <p class="text-3xl my-1 mx-1 p-2">Usuario que inicio Sesión: {{ Auth::user()->name }}</p>
            <div>
                {{-- @foreach ($tasks as $task)
                    <p class="p-2 m-1 font-medium text-xl">
                        {{$task->title}}
                    </p>
                    <p class="p-2 m-1">
                        {{ $task->description }}
                    </p>
                @endforeach --}}
                @livewire('task-component',['tasks'=>$tasks])
                
            </div>
        </div>
    </div>
</x-layouts.app>
