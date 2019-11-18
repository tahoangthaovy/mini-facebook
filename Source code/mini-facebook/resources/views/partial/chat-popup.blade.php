<input type="hidden" id="current_user_id" value="{{Auth::user()->id}}">
@if(count($current_user_friends) > 0)
    @foreach($current_user_friends as $current_user_friend)
        <div class="popup chat-popup" data-user-id="{{$current_user_friend->user_data->id}}" data-user-avatar="{{$current_user_friend->user_data->avatar}}" id="chat-popup-{{$current_user_friend->user_data->id}}" style="display: none">
            <input type="hidden" id="user_avatar-{{$current_user_friend->user_data->id}}" value="{{$current_user_friend->user_data->avatar}}">
            <div class="popup-header">
        <span class="user-name">
            <a href="{{route('user-detail', ['id' => $current_user_friend->user_data->id])}}">
                {{$current_user_friend->user_data->name}}
            </a>
        </span>
                <span class="close-popup">&times;</span>
            </div>
            <div class="popup-content container">
                @foreach($current_user_friend->messages as $message)
                    @if($message->sent_user == $current_user->id)
                        {{--Loops current message here--}}
                        <div class="row current-user" data-message-id="{{$message->id}}">
                            <div class="col-sm-12">
                                <p class="message">{{$message->message_content}}</p>
                            </div>
                        </div>
                    @elseif($message->sent_user == $current_user_friend->user_data->id)
                        {{--Loops orther message here--}}
                        <div class="row other-user" data-message-id="{{$message->id}}">
                            <div class="col-sm-2">
                                <img class="user-image" src="{{$current_user_friend->user_data->avatar}}">
                            </div>
                            <div class="col-sm-10">
                                <p class="message">{{$message->message_content}}</p>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
            <div class="popup-input">
                <input type="text" name="message_content" class="form-control message_content" data-user-id="{{$current_user_friend->user_data->id}}" placeholder="Type a message...">
                {{--<button type="button" class="btn btn-default add-photo-message"><i class="fas fa-camera"></i></button>--}}
            </div>
        </div>
    @endforeach

    @foreach($groups as $group)
        <div class="popup group-popup" data-group-id="{{$group->id}}" data-group-avatar="{{$group->group_avatar}}" id="group-popup-{{$group->id}}" style="display: none">
            <div class="popup-header">
        <span class="user-name">
            <a href="{{route('user-detail', ['id' => $current_user_friend->user_data->id])}}">
                {{ (strlen($group->name) > 20)? substr($group->name, 0, 20) . '...' : $group->name}}
            </a>
        </span>
                <span class="close-popup">&times;</span>
            </div>
            <div class="popup-content container">
                @foreach($group->messages as $message)
                    @if($message->sent_user == $current_user->id)
                        {{--Loops current message here--}}
                        <div class="row current-user" data-message-id="{{$message->id}}">
                            <div class="col-sm-12">
                                <p class="message">{{$message->message_content}}</p>
                            </div>
                        </div>
                    @else
                        {{--Loops orther message here--}}
                        <div class="row other-user" data-message-id="{{$message->id}}">
                            <div class="col-sm-2">
                                <img class="user-image" src="{{$message->sent_user_data->avatar}}">
                            </div>
                            <div class="col-sm-10">
                                <p class="message">{{$message->message_content}}</p>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
            <div class="popup-input">
                <input type="text" name="message_content" class="form-control message_content" data-group-id="{{$group->id}}" placeholder="Type a message...">
                {{--<button type="button" class="btn btn-default add-photo-message"><i class="fas fa-camera"></i></button>--}}
            </div>
        </div>
    @endforeach
@endif