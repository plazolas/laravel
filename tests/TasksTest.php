<?php
use App\Task;
use App\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TasksTest extends TestCase
{
    protected $user;
    public function __construct() {
        
    }
    public function test_home_and_task_pages_access()
    {
        $this->visit('/')->see('Waltz Realty');
        $this->visit('/home')->see('Waltz Realty');
        $this->visit('/tasks')->see('Login or Register');
        
        $this->user = factory(App\User::class)->make();
        
        $this->actingAs($this->user)
        ->withSession(['foo' => 'bar'])
        ->visit('/tasks')
        ->see('Current Tasks');
    }
    
    public function test_tasks_can_be_created()
    {
        $this->user = factory(App\User::class)->make();
        
        //factory(Task::class)->create(['name' => 'Task 96']);
        $newTask = str_random(3);
        
        $this->actingAs($this->user)
            ->withSession(['foo' => 'bar'])
            ->visit('/tasks')
            ->type('Task '.$newTask, 'name')
            ->press('add-task')
            ->see('Task '.$newTask)
            ->seeInDatabase('tasks', [ 'name' => 'Task '.$newTask]);
    }
    
    public function test_long_tasks_cant_be_created()
    {
        $this->user = factory(App\User::class)->make();
        
        $bogus_task = str_random(300);
        echo $bogus_task;
        
        $this->actingAs($this->user)
            ->withSession(['foo' => 'bar'])
            ->visit('/tasks')
            ->type($bogus_task, 'name')
            ->press('add-task')
            ->dontSee($bogus_task);
    }
    
    public function test_tasks_can_be_deleted()
    {
        
        $this->user = factory(App\User::class)->make();
        
        $toDelete = Task::latest()->first();
        
        echo "toDelete task id: ".$toDelete->id; 
        
        $this->actingAs($this->user)
            ->withSession(['foo' => 'bar'])
            ->visit('/tasks')
            ->see($toDelete->name)
            ->press('delete-task-'.$toDelete->id)
            ->dontSee($toDelete->name)
            ->notSeeInDatabase('tasks', [ 'name' => $toDelete->name]);
    }
    
    public function test_insert_tables() {
       
        DB::table('users')->insert([
            'name' => 'registered',
            'email' => 'registered@laravelrealstate.com',
            'role' => 'registered',
            'password' => bcrypt('registered'),
            'role' => 'registered'
        ]);
        
        DB::statement("
          INSERT INTO `tasks` (`id`, `name`, `created_at`, `updated_at`) VALUES
            (0, 'Git pull laravel repository', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'run composer on app root directory', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'create MySQL Database', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'Update database cofig file for your MySQL credential', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'Login as admin and change password', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."')  
        ");
        
        $this->seeInDatabase('users', ['email' =>  'registered@laravelrealstate.com']);
        $this->seeInDatabase('tasks', ['name' =>  'Login as admin and change password']);
    }
}