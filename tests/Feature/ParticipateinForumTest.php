<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateinForum extends TestCase
{	
	use DatabaseMigrations;

	/** @test */
	function unauthenticated_user_may_not_add_replies(){

		// kiem tra loi co fai loi Illuminate\Auth\AuthenticationException  khi them ko?
		$this->expectException('Illuminate\Auth\AuthenticationException');
   		$thread = factory('App\Thread')->create();
		$reply = factory('App\Reply')->create();
   		//$this->post($thread->path().'/replies', $reply->toArray());
   		$this->post('threads/1/replies', []);
	}

    /** @test*/
   public function an_authenticated_user_may_participate_in_forum_threads()
   {
   		//Given we have a authenticated user
   		//$user = factory('App\User')->create();
   		$this->be($user = factory('App\User')->create());

   		//And an exiting thread
   		$thread = factory('App\Thread')->create();

   		//When the user adds a reply to the thread
   		$reply = factory('App\Reply')->create();
   		$this->post($thread->path().'/replies', $reply->toArray());

   		//Then their reply should be visible on the page
   		$this->get($thread->path())
   			->assertSee($reply->body);

   }
}
