<?php

namespace App\Http\Controllers;


use App\Folder;
use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\CreateTask;


class TaskController extends Controller
{
    public function index(int $id)
    {
        //全てのフォルダを取得する
        $folders = Folder::all();

        //選ばれたフォルダを取得する
        $current_folder = Folder::find($id);

        //選ばれたフォルダに紐づくタスクを取得する
        // $tasks = Task::where('folder_id', $current_folder->id)->get();

        $tasks = $current_folder->tasks()->get(); // ★

    return view('tasks/index', [
        'folders' => $folders,
        'current_folder_id' => $current_folder->id,
        'tasks' => $tasks,
    ]);

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);

        // その2
        // $current_folder_id = $id;
        // return view('tasks/index', compact('folders', 'current_folder_id', 'tasks'));
    }
    /**
     * GET /folders/{id}/tasks/create 
     * コントローラーのメソッドの引数で受け取りview関数でテンプレートに渡す
     */
    public function showCreateForm(int $id)
    {
    return view('tasks/create', [
        'folder_id' => $id
    ]);
}

public function create(int $id, CreateTask $request)
{
    $current_folder = Folder::find($id);

    $task = new Task();
    $task->title = $request->title;
    $task->due_date = $request->due_date;

    $current_folder->tasks()->save($task);

    return redirect()->route('tasks.index', [
        'id' => $current_folder->id,
    ]);
}

public function showEditForm(int $id, int $task_id)
{
    $task = Task::find($task_id);

    return view('tasks/edit', [
        'task' => $task,
    ]);
}

public function edit(int $id, int $task_id, EditTask $request)
{
    // 1 クリエイトされたIDでタスクデータを取得する
    $task = Task::find($task_id);

    // 2　編集対象のタスクデータに入力値をつめてsave
    $task->title = $request->title;
    $task->status = $request->status;
    $task->due_date = $request->due_date;
    $task->save();

    // 3 最後に編集対象のタスクが属するタスク一覧画面へリダイレクト
    return redirect()->route('tasks.index', [
        'id' => $task->folder_id,
    ]);
}

}