<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //

    protected $guarded = [];

    protected $with = ['creator', 'channel'];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });

        // static::addGlobalScope('creator', function($builder){
        //     $builder->with('creator');
        // });
    }

    public function path(){
        //return '/threads/'.$this->id;
        return "/threads/{$this->channel->slug}/{$this->id}";
    	//return '/threads/'.$this->channel->slug.'/'.$this->id;
    }

    public function replies(){
    	return $this->hasMany('App\Reply');
    }
    public function creator(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function addReply($reply){
        $this->replies()->create($reply);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }
}
