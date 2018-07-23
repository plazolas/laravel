<?php

use App\Task;
use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
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
        $this->actingAs($this->user)
            ->withSession(['foo' => 'bar'])
            ->visit('/tasks')
            ->type('Task 96', 'name')
            ->press('add-task')
            ->see('Task 96')
            ->seeInDatabase('tasks', [ 'name' => 'Task 96']);

    }
    
    public function test_long_tasks_cant_be_created()
    {
        $this->user = factory(App\User::class)->make();
        
        $bogus_task = str_random(300);
        
        $this->actingAs($this->user)
            ->withSession(['foo' => 'bar'])
            ->visit('/tasks')
            ->type(str_random(300), 'name')
            ->press('add-task')
            ->dontSee($bogus_task);
    }
    
    public function test_tasks_can_be_deleted()
    {
        
        $this->user = factory(App\User::class)->make();
        
        $toDeleted = Task::latest()->first();
        
        $this->actingAs($this->user)
            ->withSession(['foo' => 'bar'])
            ->visit('/tasks')
            ->see($toDelete->name)
            ->press('delete-task-'.$toDelete->id)
            ->dontSee($toDeleted->name)
            ->notSeeInDatabase('tasks', [ 'name' => $toDelete->name]);
               
    }

}
