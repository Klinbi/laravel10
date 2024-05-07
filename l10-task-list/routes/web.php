<?php

use \App\Models\Task;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\TaskRequest;

Route::get('/', function () {
    return redirect()->route('task.index');
});

Route::get('/tasks', function () {
    return view('index', [
         'tasks' => Task::latest()->where('completed', false)->get()
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')
    ->name('tasks.create');

Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.show');

Route::get('/tasks/{task}', function (Task $task) {
    return view('show', [
      'task' => $task
    ]);
})->name('tasks.show');

Route::post('/tasks', function (TaskRequest $request) {
    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task])
        ->with('success', 'Task created successfully!');

})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task, TaskRequest $request) {
    $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task])
        ->with('success', 'Task updated successfully!');

})->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')
        ->with('success', 'Task deleted successfully.');
})->name('tasks.destroy');

Route::fallback(function () {
    return 'Still got somewhere!';
});

