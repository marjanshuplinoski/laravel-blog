@extends('layouts.app')
@section('title')
    @if($post)
        {{$post->title}}
        @if(!Auth::guest() && ($post->author_id == Auth::user()->id || $post->author_id == Auth::user()->is_admin()))
            <button class="btn-info" style="float:right"><a href="{{url('edit/'.$post->slug)}}">Edit Post</a></button>
        @endif
    @else
        You are not authorized to preview
    @endif
@endsection

@section('title-meta')
    <p>{{$post->created_at->format("d-m-Y")}} by <a
            href="{{url("/user/". $post->author_id)}}">{{$post->author->name}}</a></p>
@endsection
@section('content')
    @if($post)
        <div>
            {!! $post->body !!}
        </div>
        <div class='list-group-item col-md-12' style="text-align: right">
            <span class="col-md-8"></span>
            <span title="Likes"  data-type="like"
                  data-post="{{ $post->id}}" class="col-md-2 saveLikeDislike">
                                        <button class="btn btn-block btn-primary">
                                            <i class="fa fa-thumbs-up">Like</i>
                                        </button>
                                        <span class="like-count">{{$post->likes()}}
                                        </span>
                                    </span>
            <span title="Dislikes" data-type="dislike"
                  data-post="{{ $post->id}}" class="col-md-2 saveLikeDislike">
                                        <button class="btn btn-block btn-primary">
                                                 <i class="fa fa-thumbs-down">Dislike</i>
                                        </button>
                                        <span class="dislike-count">{{$post->dislikes()}}
                                        </span>
                                    </span>
        </div>
        <div>
            <h2>Leave a comment</h2>
        </div>

        @if(Auth::guest())
            <p>Login to Comment</p>
        @else
            <div class="panel-body">
                <form method="post" action="comment/add">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="on_post" value="{{ $post->id }}">
                    <input type="hidden" name="slug" value="{{ $post->slug }}">
                    <div class="form-group">
                        <textarea required="required" placeholder="Enter comment here" name="body"
                                  class="form-control"></textarea>
                    </div>
                    <input type="submit" name='post_comment' class="btn btn-success" value="Post"/>
                </form>
            </div>
        @endif
        <div class="list-group-item">
            @if($comments)
                <ul style="list-style: none; padding: 0">
                    @foreach($comments as $comment)
                        <li class="panel-body">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <h3>{{ $comment->author->name }}</h3>
                                    <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
                                </div>
                                <div class="list-group-item">
                                    <p>{{ $comment->body }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    @else
        404 error
    @endif

@endsection
