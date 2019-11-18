@extends('layouts.user-layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="/css/custom-home.css">
<link rel="stylesheet" type="text/css" href="/css/custom-user-detail.css">
{{--<link rel="stylesheet" type="text/css" href="/css/custom-friend-list.css">--}}
<link rel="stylesheet" type="text/css" href="/css/custom-about.css">
@endpush
@push('scripts')
<script src="/js/custom-home.js"></script>
<script src="/js/custom-about.js"></script>
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
    <div class="edit-about">
        {!! Form::open(['method'=>'POST', 'action'=>'UserController@updateAbout']) !!}
        {{ csrf_field() }}

        <div class="form-group about-content">
            {!! Form::textarea('about', null, ['class'=>'form-control', 'id'=>'about', 'placeholder' => 'Tell something about you...', 'rows'=>3]) !!}
        </div>

        <div class="form-group action-button">
            {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
            {!! Form::button('Cancel', ['class'=>'btn btn-default cancel-update']) !!}
        </div>

        {!! Form::close() !!}
    </div>
    <div class="about">
        @if(!$user->about)
            <p style="text-align: center">Nothing here</p>
        @else
            <p style="padding: 20px;">{{$user->about}}</p>
            <input type="hidden" id="about-content" value="{{$user->about}}">
        @endif
        @if(Auth::user()->id == $user->id)
            <button type="button" class="btn btn-primary edit" data-user-id="{{$user->id}}"><i class="fas fa-edit"></i> Edit</button>
        @endif
    </div>
@endsection
