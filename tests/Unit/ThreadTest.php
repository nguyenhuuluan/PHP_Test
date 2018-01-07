<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{	
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */

    protected $thread;
    public function setUp(){
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

     /** @test*/
    public function a_thread_has_replies()
    {
        //$thread = factory('App\Thread')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test*/
    public function a_thread_has_a_creator()
    {
    	$thread = factory('App\Thread')->create();

    	$this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_reply(){

        $this->thread->addReply([
            'body'=> 'Foobar',
            'user_id'=> 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
