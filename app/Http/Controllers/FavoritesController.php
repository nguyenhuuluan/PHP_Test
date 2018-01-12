<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new favorite in the database.
     *
     * @param  Reply $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back();
    }

    public function loginRedirect(Replies $replies)
    {

        $thread = Thread::where('id', $replies->thread_id)->get();

        return redirect('threads/'.$thread[0]->channel->name.'/'.$thread[0]->id);

    }
}