<?php
use App\Task;
use App\User;

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
}