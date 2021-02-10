@extends('layouts.app')
@section('title')
    Add new Post
@endsection

@section('content')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea'});</script>

    <form action="save_post" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-group">
            <input required="required" value="{{old('title')}}" placeholder="Enter title" type="text" name="title" class="form-control">
        </div>
        <div class="form-group">
            <input required="required" value="{{old('subtitle')}}" placeholder="Enter subtitle" type="text" name="subtitle" class="form-control">
        </div>
        <div class="form-group">
            <textarea name="body" id="body" cols="30" rows="10">{{old('body')}}</textarea>
        </div><div class="form-group">
            <select name="category" id="category">
                <option value="politics">Politics</option>
                <option value="sport">Sport</option>
            </select>
        </div>
        <input type="submit" value="Save" name="save" class="btn btn-default">
        <br>
        <input type="submit" value="Publish" name="publish" class="btn btn-info">
    </form>
@endsection
