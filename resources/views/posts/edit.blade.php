@extends('layouts.app')
@section('title')
    Edit Post
@endsection
@section('content')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea'});</script>

    <form method="post" action="{{url("/update")}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="post_id" value="{{$post->id}}{{old('post_id')}}">
        <div class="form-group">
            <input type="text" required="required" placeholder="Enter Title" name="title" class="form-control"
                   value="@if(!old('title')){{$post->title}}@endif {{old('title')}}">
        </div>
        <div class="form-group">
            <input type="text" required="required" placeholder="Enter SubTitle" name="subtitle" class="form-control"
                   value="@if(!old('subtitle')){{$post->subtitle}}@endif {{old('subtitle')}}">
        </div>
        <div class="form-group">
            <textarea name="body" id="" cols="30" rows="10" class="form-control">
                @if (!old('body'))
                    {!! $post->body !!}
                @endif
                {!! old('body') !!}
            </textarea>
        </div>
        @if($post->active == '1')
            <input type="submit" name='publish' class="btn btn-success" value="Update"/>
        @else
            <input type="submit" name='publish' class="btn btn-success" value="Publish"/>
        @endif
        <input type="submit" name='save' class="btn btn-default" value="Save As Draft"/>
        <a href="{{  url('delete/'.$post->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
    </form>
@endsection
