@extends('layouts.user-layout')

@push('styles')
<link rel="stylesheet" type="text/css" href="/css/custom-search.css">
<link rel="stylesheet" type="text/css" href="/css/custom-home.css">
<link rel="stylesheet" type="text/css" href="/css/custom-user-detail.css">
<link rel="stylesheet" type="text/css" href="/css/custom-friend-list.css">
@endpush
@push('scripts')
<script src="/js/custom-search.js"></script>
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

@section('content')
    {{--Add loop posts here--}}
    <div class="friend-list">
        <ul class="friend-list">
            @if(count($users) == 0)
                <div class="container" style="text-align: center">
                    You have no friends
                </div>
            @endif
            {{--Loops friends here--}}
            @foreach($users as $user)
                <li id="friend-{{$user->id}}">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="image-container">
                                    <img src="{{$user->avatar}}">
                                </div>
                                <div class="user-info">
                                    <p class="user-name"><a href="{{route('user-detail', ['id'=>$user->id])}}">{{$user->name}}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
            {{--End loops friends--}}

        </ul>
    </div>
    {{--End loop posts--}}
@endsection