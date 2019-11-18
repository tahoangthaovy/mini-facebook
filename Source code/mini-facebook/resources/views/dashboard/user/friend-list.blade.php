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
            @if(count($friends) == 0)
                <div class="container" style="text-align: center">
                    You have no friends
                </div>
            @endif
            {{--Loops friends here--}}
            @foreach($friends as $friend)
            <li id="friend-{{$friend->user_data->id}}">
                <div class="container">
                   <div class="row">
                       <div class="col-sm-6">
                           <div class="image-container">
                               <img src="{{$friend->user_data->avatar}}">
                           </div>
                           <div class="user-info">
                               <p class="user-name"><a href="{{route('user-detail', ['id'=>$friend->user_data->id])}}">{{$friend->user_data->name}}</a></p>
                           </div>
                       </div>
                       <div class="col-sm-6 button-container" style="text-align: right">
                           @if($current_user->id != $user->id)
                               @if($friend->is_mutual)
                                   <p class="mutual-friend">Mutual Friend</p>
                               @else
                               @endif
                           @else
                               <button type="button" class="btn btn-default friend-list-buttons remove-friend" data-user-id="{{$friend->user_data->id}}">
                                   <i class="fas fa-trash"></i> Remove Friend
                               </button>

                           @endif



                       </div>
                   </div>
                </div>
            </li>
            @endforeach
            {{--End loops friends--}}

        </ul>
    </div>
@endsection
