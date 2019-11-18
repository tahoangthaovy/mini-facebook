@extends('layouts.user-layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="/css/custom-home.css">
<link rel="stylesheet" type="text/css" href="/css/custom-user-detail.css">
@endpush
@push('scripts')
<script src="/js/custom-home.js"></script>
@endpush

@section('contacts')
    @include('partial.contacts')
@endsection

@section('groups')
    @include('partial.groups')
@endsection

@section('sidebar')
    @parent

    {{--<p>This is appended to the master sidebar.</p>--}}
@endsection

@section('profile-images')
    @include('partial.profile-images')
@endsection

@section('content')
    <div class="post write-post">
        {!! Form::open(['method'=>'POST', 'action'=>'PostController@store', 'id'=>'post', 'enctype'=>'multipart/form-data']) !!}
        {{ csrf_field() }}

        <div class="form-group post-content">
            {!! Form::textarea('post_content', null, ['class'=>'form-control', 'placeholder' => 'What\'s in your mind...', 'id'=>'content', 'rows'=>3]) !!}
            {!! Form::hidden('user_id', $current_user->id) !!}
            {!! Form::hidden('post_id', null) !!}
        </div>

        <div class="form-group image-upload">
            {!! Form::label('image', 'Upload Image:') !!}
            {!! Form::file('image', ['class'=>'form-control']) !!}
        </div>

        <div class="form-group post-action">
            {!! Form::submit('Post', ['class'=>'btn btn-primary post-btn']) !!}
        </div>

        {!! Form::close() !!}
    </div>

    {{--Add loop posts here--}}
    @foreach ($posts as $post)
        <div class="post-item" id="post-item-{{$post->id}}">
            <div class="container-fluid">
                <div class="row" style="height: 40px; line-height: 20px">
                    <div class="col-sm-9">
                        <div class="avatar-container-large">
                            <img src="{{$post->post_author->avatar}}" class="avatar">
                        </div>

                        <a href="{{route('user-detail', ['id' => $post->post_author->id])}}"><span class="user-name">{{$post->post_author->name}}</span></a>
                    </div>
                    @if($post->user_id === $current_user->id)
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary btn-edit-post" style="float: left; margin-left: 10px" data-post-id="{{$post->id}}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('posts.destroy' , $post->id)}}" method="POST">
                                <input name="_method" type="hidden" value="DELETE">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-delete-post" onclick="return confirm('Are you sure?')" style="float:left; margin-left: 10px">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="row time-dif" style="padding-left: 50px; margin-top: -20px;">
                    <div class="col-sm-12">
                        <span class="posted-time">{{$post->date}}</span>
                    </div>
                </div>
                <div class="row content-container">
                    <div class="col-sm-12">
                        <div class="update-area">
                            <textarea class="form-control update-content" row="3"></textarea>
                            <div class="update-action">
                                <button class="btn btn-default cancel-update-post" data-post-id="{{$post->id}}">Cancel</button>
                                <button class="btn btn-primary update-post" data-post-id="{{$post->id}}">Update</button>
                            </div>
                        </div>
                        <p>{{$post->post_content}}</p>
                    </div>
                </div>
                @if($post->image_path != null)
                    <div class="row image-container">
                        <div class="col-sm-12" style="text-align: center">
                            <img class="post-image" src="{{$post->image_path}}">
                        </div>
                    </div>
                @endif
                <div class="row react">
                    <div class="col-sm-12">
                        <ul class="react">
                            @if($post->is_liked)
                                <li>
                                    <a href="#" class="btn btn-default btn-unlike" data-post-id="{{$post->id}}">
                            <span class="like-status">
                                Unlike
                            </span> (<span class="like-count">{{count($post->likes)}}</span>)
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="#" class="btn btn-default btn-like" data-post-id="{{$post->id}}">
                        <span class="like-status">
                            Like
                        </span> (<span class="like-count">{{count($post->likes)}}</span>)
                                    </a>
                                </li>
                            @endif
                            <li><a href="#" class="btn btn-default btn-comment" data-post-id="{{$post->id}}">Comment (<span class="comment-count">{{count($post->comments)}}</span>)</a></li>
                        </ul>
                    </div>
                </div>

                <div class="row comment-container">
                    <div class="col-sm-1">
                        <div class="avatar-container">
                            <img src="{{$current_user->avatar}}" class="avatar-small">
                        </div>

                    </div>
                    <div class="col-sm-11">
                        <textarea type="text" class="comment form-control" placeholder="Leave a comment..." data-post-id="{{$post->id}}" data-user-id="{{$current_user->id}}"></textarea>
                    </div>
                    {{--<div class="col-sm-1" style="text-align: center; font-size: 13px; padding: 0">--}}
                        {{--<button type="button" class="upload btn btn-default"><i class="fas fa-camera"></i></button>--}}
                    {{--</div>--}}

                </div>

                <div class="show-comment-container">
                    @foreach($post->comments as $comment)
                        {{--Add loops comments here--}}
                        <div class="row comment-item">
                            <div class="col-sm-1">
                                <div class="avatar-container">
                                    <img src="{{$comment->comment_author->avatar}}" class="avatar-small">
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <p class="comment-content"><a href="{{route('user-detail', ['id' => $comment->comment_author->id])}}"><span class="comment-owner">{{$comment->comment_author->name}}</span></a>{{$comment->comment_content}}</p>
                            </div>

                            @if($comment->comment_author->id == $current_user->id)
                                <div class="col-sm-12">
                                    <div class="comment-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default edit-comment" data-comment-id="{{$comment->id}}" data-post-id="{{$post->id}}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-default delete-comment" data-comment-id="{{$comment->id}}" data-post-id="{{$post->id}}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>
                        {{--End loop comments--}}
                    @endforeach
                </div>


            </div>
        </div>
    @endforeach
    {{--End loop posts--}}
@endsection