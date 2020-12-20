<?php

namespace Tests\Feature;

use App\Folder;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Task;

class TaskTest extends TestCase
{
    // テストケースごとにデータベースをリフレッシュしてマイグレーションを再実行する
    use RefreshDatabase;

    /**
     * 各テストメソッドの実行前に呼ばれる
     */
    public function setUp():void
    {
        parent::setUp();

        $this->setTestData();
    }


    /**
     * 期限日が日付ではない場合はバリデーションエラー
     * @test
     */
    public function due_date_should_be_date()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => 123, // 不正なデータ（数値）
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には日付を入力してください。',
        ]);
    }

    /**
     * 期限日が過去日付の場合はバリデーションエラー
     * @test
     */
    public function due_date_should_not_be_past()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'), // 不正なデータ（昨日の日付）
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    /**
     * 状態が定義された値ではない場合はバリデーションエラー
     * @test
    */
    public function status_should_be_within_defined_numbers()
    {
        // Factoryを使ってデータを作成する
        $folder = factory(Folder::class)->create();
        $task = factory(Task::class)->create();
        $due_date = Carbon::today()->addDay(5);

        $response = $this->post('/folders/' . $folder->id . '/tasks/' . $task->id . '/edit', [
            'title' => 'Sample task',
            'due_date' => $due_date,
            'status' => 999,
        ]);

        $response->assertSessionHasErrors([
            'status' => '状態 には 未着手、着手中、完了 のいずれかを指定してください。',
        ]);     
    }

    /**
     * テストデータをセット
     */
    private function setTestData()
    {
        $this->seed('UsersTableSeeder');
        // テストケース実行前にフォルダデータを作成する
        $this->seed('FoldersTableSeeder');
    }
}