<div class="profile-images">
    <div class="cover-container">
        <img class="cover" src="{{$user->cover}}">
    </div>
    <div class="avatar-container">
        <img class="avatar" src="{{$user->avatar}}">
        @if($user->id == Auth::id())
        <button type="button" class="btn btn-default change-avatar" data-toggle="modal" data-target="#avatar-modal"><i class="fas fa-camera"></i> </button>
        @endif
    </div>
    <div class="username-container">
        <p>{{$user->name}}</p>
    </div>

    @if($user->id == Auth::id())
    <button type="button" class="btn btn-default change-cover" data-toggle="modal" data-target="#cover-modal"><i class="fas fa-camera"></i> </button>
    @endif
    <ul class="friend-option">
        <li><a href="{{route('user-about', ['id' => $user->id])}}">About</a> </li>
        <li><a href="{{route('user-friend-list', ['id' => $user->id])}}">Friends</a> </li>
        @if($user->id == Auth::user()->id)
            <li><a href="{{route('user-friend-request', ['id' => $user->id])}}">Request
                    @if(count($requests) > 0)
                    <span class="request-notification">{{count($requests)}}</span>
                    @endif
                </a> </li>
        @endif
    </ul>

    @if($user->is_friend)
        {{--<div class="btn-group profile-image-buttons">--}}
            {{--<button type="button" class="btn btn-default">--}}
                {{--<i class="fas fa-comment"></i> Message--}}
            {{--</button>--}}
        {{--</div>--}}
    @elseif($user->id != Auth::user()->id)
    <div class="btn-group profile-image-buttons">
        @if($user->is_request)
            <button type="button" class="btn btn-default" disabled>
                <i class="fas fa-user-plus"></i> Request Sent
            </button>
        @else
            <button type="button" class="btn btn-default add-friend" data-user-id="{{$user->id}}">
                <i class="fas fa-user-plus"></i> Add Friend
            </button>
        @endif

        {{--<button type="button" class="btn btn-default">--}}
            {{--<i class="fas fa-comment"></i> Message--}}
        {{--</button>--}}
    </div>
    @endif

    <div id="avatar-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                {!! Form::open(['method'=>'POST', 'action'=>'UserController@updateAvatar', 'enctype'=>'multipart/form-data']) !!}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Change Avatar</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group cover-upload">
                        {!! Form::label('image', 'Upload Image:') !!}
                        {!! Form::file('image', ['class'=>'form-control', 'onchange' => 'readURL(this);']) !!}
                        <div class="avatar-cover-container">
                            <img class="avatar-cover" src="#" alt="Cover"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

    <div id="cover-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                {!! Form::open(['method'=>'POST', 'action'=>'UserController@updateCover', 'enctype'=>'multipart/form-data']) !!}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">Change Cover</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group cover-upload">
                        {!! Form::label('image', 'Upload Image:') !!}
                        {!! Form::file('image', ['class'=>'form-control', 'onchange' => 'readURL(this);']) !!}
                        <div class="avatar-cover-container">
                            <img class="avatar-cover" src="#" alt="Cover"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

</div>