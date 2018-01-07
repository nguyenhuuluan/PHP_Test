<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
     use DatabaseMigrations;
     public function setUp(){
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
     }
    /** @test*/
    public function a_user_can_view_all_threads()
    {
    	//$thread = factory('App\Thread')->create();

        $this->get('/threads')
            ->assertSee($this->thread->title);

    }

    /** @test*/
    public function a_user_can_read_single_thread(){
    	//$thread = factory('App\Thread')->create();
        //$response = $this->get('/threads/'.$this->thread->id);

    	$this->get($this->thread->path())
            ->assertSee($this->thread->title);

    }

    /** @test*/
    public function a_user_can_read_replies_that_are_associated_with_a_thread(){
         //Given we have a thread
        //And that thread includes replies
        $reply = factory('App\Reply')
            ->create(['thread_id'=>$this->thread->id]);
        //When we visit a thread page
        $this->get($this->thread->path())            
            ->assertSee($reply->body);
        //Then we should see the replies
    }
    
}