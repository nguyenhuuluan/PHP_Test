@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                <a href="">{{ $thread->creator->name }}</a>
                    {{ $thread->title }}
                </div>

                <div class="panel-body">
                    {{$thread->body}}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach ($thread->replies as $reply)
              @include('threads.reply')
            @endforeach
            
        </div>
    </div>

    @if(auth()->check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ $thread->path().'/replies' }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                     <textarea name="body" id="body" cols="30" rows="10" class="form-control", placeholder="Have something say!"></textarea>
                </div>
                <button type="submit" class="btn btn-default">Post</button>
               

            </form>
        </div>
    </div>
    @else
    <p class="text-center">Please <a href="{{ route('login') }}">sign in </a>to participate in this disscussion</p>
    @endif
</div>
@endsection
