@extends('layouts.app')
@section("title")
    {{$user->name}}
@endsection
<style>
    td {
        padding: 20px !important;
    }
</style>
@section("content")
    <div class="col-md-12" style="background-color: lawngreen">
        <ul class="list-unstyled">
            <li class="list-group-item-heading"><h2>{{$user->name}} joined
                    on {{$user->created_at->format('d-m-Y')}}</h2></li>
            <hr>
            <li class="list-group-item-heading"><h3>Total comments: {{$comments_count}}</h3></li>

            <li class="list-group-item-heading">
                <table class="col-md-12" border="1">
                    <tr>
                        <td class="list-group-item-heading">Total posts</td>
                        <td>{{$posts_count}}</td>
                        @if($author && $posts_count)
                            <td class="list-group-item-heading"><a href="{{url("/my_posts")}}">Show all posts</a>
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td class="list-group-item-heading">Total published posts</td>
                        <td class="list-group-item-heading"> {{$posts_published_count}}</td>
                        @if($posts_published_count)
                            <td><a href="{{url("/user/".$user->id."/posts")}}">Show all published posts</a></td>
                        @endif
                    </tr>
                    <tr>
                        <td class="list-group-item-heading">Total unpublished posts</td>
                        <td class="list-group-item-heading"> {{$posts_unpublished_count}}</td>
                        @if($author && $posts_unpublished_count)
                            <td><a href="{{url("/my-unpublished-posts")}}">Show all unpublished posts</a></td>
                        @endif
                    </tr>
                </table>

            </li>
            <li class="list-group-item-heading">

                <div class="col-md-12">
                    <hr>
                    <div class="panel-heading"><h3>Latest Published Posts</h3></div>
                    @if(!empty($latest_published_posts))
                        <ul>
                            @foreach($latest_published_posts as $post)
                                <li><a href="{{url("/".$post->slug)}}">{{$post->title}}</a>
                                     <span class="info">Created on {{$post->created_at->format("d-m-Y")}}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="col-md-12">
                    <hr>
                    <div class="panel-heading"><h3>Latest Comments</h3></div>
                    @if(!empty($latest_comments))
                        <ul>
                            @foreach($latest_comments as $comment)
                                <li>On post <a href="{{url("/".$comment->post->slug)}}">{{$comment->post->title}}</a>
                                     <span class="info">Created on {{$comment->created_at->format("d-m-Y")}}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="alert-warning">You have no comments.</span>
                    @endif
                </div>
            </li>
        </ul>
    </div>
@endsection
