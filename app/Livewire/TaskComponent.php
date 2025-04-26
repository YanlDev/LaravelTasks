<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class TaskComponent extends Component
{
    public $tasks = [];
    public $title;
    public $description;
    public $modal = false;
    public $task_id; // Añadimos esta propiedad para manejar el ID de la tarea en edición

    public function mount()
    {
        $this->tasks = $this->getTasks();
    }

    public function getTasks()
    {
        return Task::where('user_id', auth()->user()->id)->get();
    }

    public function render()
    {
        return view('livewire.task-component');
    }

    private function clearFields()
    {
        $this->title = '';
        $this->description = '';
        $this->task_id = null; // Limpiamos también el ID
    }

    public function openCreateModal()
    {
        $this->clearFields();
        $this->modal = true;
    }

    public function closeCreateModal()
    {
        $this->modal = false;
    }

    // Añadimos un método específico para editar
    public function editTask($id)
    {
        $task = Task::find($id);
        if ($task) {
            $this->task_id = $task->id;
            $this->title = $task->title;
            $this->description = $task->description;
            $this->modal = true;
        }
    }

    public function createOrUpdateTask()
    {
        if ($this->task_id) {
            // Actualizar tarea existente
            $task = Task::find($this->task_id);
            if ($task) {
                $task->title = $this->title;
                $task->description = $this->description;
                $task->save();
            }
        } else {
            // Crear nueva tarea
            Task::create([
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => auth()->user()->id
            ]);
        }

        $this->clearFields();
        $this->modal = false;
        $this->tasks = $this->getTasks();
    }

    public function deleteTask($id)
    {
        // Encuentra la tarea por su ID
        $task = Task::find($id);

        // Verifica que exista y pertenezca al usuario actual por seguridad
        if ($task && $task->user_id == auth()->user()->id) {
            // Elimina la tarea
            $task->delete();
        }
        // Actualiza la lista de tareas
        $this->tasks = $this->getTasks();
    }
}
