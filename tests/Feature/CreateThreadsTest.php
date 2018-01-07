<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	function guests_may_not_create_threads(){
		$this->expectException('Illuminate\Auth\AuthenticationException');

		//$thread = factory('App\Thread')->make();
		$thread = make('App\Thread');


    	$this->post('/threads', $thread->toArray());

	}	
    

    /** @test*/
    function guests_cannot_see_create_thread_page()
    {
        /*$this->get('/threads/create')
            ->assertRedirect('/login');*/
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test*/
    function an_authenticated_user_can_create_new_forum_threads(){
    	//Givven we have a signed in user
        //$this->actingAs(factory('App\User')->create());
    	$this->signIn();


    	// When we hit the endpoint to create a new threadd
    	$thread = make('App\Thread');
    	//$thread = factory('App\Thread')->make();
    	$this->post('/threads', $thread->toArray());
    	//Then, when we visit the thread page
    	$response = $this->get($thread->path());
    	// We show see the new thread
    	$response->assertSee($thread->title)
    		->assertSee($thread->body);
    }
}
