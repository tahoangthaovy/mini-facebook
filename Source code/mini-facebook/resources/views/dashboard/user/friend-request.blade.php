@extends('layouts.user-layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="/css/custom-home.css">
<link rel="stylesheet" type="text/css" href="/css/custom-user-detail.css">
<link rel="stylesheet" type="text/css" href="/css/custom-friend-list.css">
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
    <div class="friend-list">
        <ul class="friend-list">
            {{--Loops friends here--}}
            @if(count($requests) == 0)
                <div class="container" style="text-align: center">
                    You have no requests
                </div>
            @endif
            @foreach($requests as $request)
            <li id="request-{{$request->user_data->id}}">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="image-container">
                                <img src="{{$request->user_data->avatar}}">
                            </div>
                            <div class="user-info">
                                <p class="user-name"><a href="{{route('user-detail', ['id'=>$request->user2])}}">{{$request->user_data->name}}</a></p>
                            </div>
                        </div>
                        <div class="col-sm-6 button-container" style="text-align: right">
                            <button type="button" class="btn btn-default friend-list-buttons accept-request" data-user-id="{{$request->user_data->id}}">
                                <i class="fas fa-user-plus"></i> Accept
                            </button>
                            <button type="button" class="btn btn-default friend-list-buttons remove-request" data-user-id="{{$request->user_data->id}}">
                                <i class="fas fa-trash"></i> Remove Request
                            </button>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
            {{--End loops friends--}}
        </ul>
    </div>
@endsection
