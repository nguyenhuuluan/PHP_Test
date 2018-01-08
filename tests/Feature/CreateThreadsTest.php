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
		//$this->expectException('Illuminate\Auth\AuthenticationException');

		//$thread = factory('App\Thread')->make();
		//$thread = make('App\Thread');



    	$this->withExceptionHandling();
        $this->post('/threads')
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');

	}	

    /** @test*/
    function an_authenticated_user_can_create_new_forum_threads(){
    	//Givven we have a signed in user
        //$this->actingAs(factory('App\User')->create());
    	$this->signIn();


    	// When we hit the endpoint to create a new threadd
        //$thread = create('App\Thread');
    	$thread = make('App\Thread');
    	//$thread = factory('App\Thread')->make();
    	$response = $this->post('/threads', $thread->toArray());

        //dd($response->headers->get('Location'));

        //dd($thread->path());
    	//Then, when we visit the thread page
        //$response = $this->get($thread->path());
    	$response = $this->get($response->headers->get('Location'));
    	// We show see the new thread
    	$response->assertSee($thread->title)
    		->assertSee($thread->body);
    }

    /** @test */
    function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test */
    function a_thread_requires_a_title()
    {   

        $this->publishThread(['title'=>null])
            ->assertSessionHasErrors('title');

        // $this->withExceptionHandling()->signIn();

        // $thread = make('App\Thread', ['title' => null]);

        // $this->post('/threads', $thread->toArray())
        //     ->assertSessionHasErrors('title');
    }
    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }
    /** @test */
    function a_thread_requires_a_valid_channel()
    {   
        //xet tao thread co channel fai ton tai trong he thong
        // dao 2 channel co id 1,2
        //xet neu co channel_id = null hoac khac 1,2 thi testcase pass
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id'=>null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id'=>3])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {

        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
