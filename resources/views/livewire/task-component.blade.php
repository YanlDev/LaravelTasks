<div wire:poll='renderAllTasks'>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-2 m-2">
        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md my-2"
            wire:click="openCreateModal">Nueva Tarea</button>
        <table class="w-full text-sm text-left text-gray-700 bg-white">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tareas
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripcion
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            {{ $task->title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $task->description }}
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center space-x-2">

                            @if ((isset($task->pivot) && $task->pivot->permission == 'edit') || auth()->user()->id == $task->user_id)
                                <button wire:click="editTask({{ $task->id }})"
                                    class="bg-yellow-400 text-white px-4 py-2 rounded-md hover:bg-amber-500">Editar</button>
                                <button wire:click='deleteTask({{ $task->id }})'
                                    class="bg-red-400 text-white px-4 py-2 rounded-md hover:bg-red-500">Eliminar</button>
                                <button wire:click='openShareModal({{ $task->id }})'
                                    class="bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-500">Compartir</button>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Main modal -->

    @if ($modal)
        <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-60 py-10">
            <div class="max-h-full w-full max-w-md overflow-y-auto rounded-xl bg-white shadow-2xl">
                <div class="w-full p-6">
                    <div class="mb-6">
                        <h1 class="mb-4 text-2xl font-bold text-gray-800">Tarea</h1>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-700">Título</label>
                            <input wire:model='title' type="text" name="titulo" id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                                placeholder="Título de la tarea" required />
                        </div>
                        <div>
                            <label for="descripcion"
                                class="block mb-2 text-sm font-medium text-gray-700">Descripción</label>
                            <input wire:model='description' type="text" name="descripcion" id="description"
                                class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
                                placeholder="Descripción de la tarea" required />
                        </div>
                        <div class="flex space-x-4 pt-4">
                            <button wire:click.prevent='createOrUpdateTask'
                                class="p-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white w-full font-medium transition-colors duration-200 shadow-md">
                                {{ $task_id ? 'Actualizar' : 'Guardar' }}
                            </button>
                            <button
                                class="p-3 bg-gray-100 border border-gray-200 hover:bg-gray-200 rounded-lg text-gray-700 w-full font-medium transition-colors duration-200"
                                wire:click='closeCreateModal'>Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($shareModal)
        <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-60 py-10">
            <div class="max-h-full w-full max-w-md overflow-y-auto rounded-xl bg-white shadow-2xl">
                <div class="w-full p-6">
                    <div class="mb-6">
                        <h1 class="mb-4 text-2xl font-bold text-gray-800">Compartir Tarea</h1>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-700">Usurario a
                                compartir</label>
                            <select wire:model='user_id'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                <option value="">Seleecione usuario</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="descripcion"
                                class="block mb-2 text-sm font-medium text-gray-700">Permisos</label>
                            <select wire:model='permission'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                                <option value="">Seleccionar un permiso</option>
                                <option value="edit">Editar</option>
                                <option value="view">Ver</option>
                                
                            </select>
                        </div>
                        <div class="flex space-x-4 pt-4">
                            <button wire:click='shareTask'
                                class="p-3 bg-blue-600 hover:bg-blue-700 rounded-lg text-white w-full font-medium transition-colors duration-200 shadow-md">
                                Compartir Tarea
                            </button>
                            <button
                                class="p-3 bg-gray-100 border border-gray-200 hover:bg-gray-200 rounded-lg text-gray-700 w-full font-medium transition-colors duration-200"
                                wire:click='closeShareModal'>Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
