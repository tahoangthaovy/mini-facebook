@foreach($current_user_friends as $current_user_friend)
    <li class="contact-item" id="contact-item-{{$current_user_friend->user_data->id}}" data-user-id="{{$current_user_friend->user_data->id}}">
        <img src="{{$current_user_friend->user_data->avatar}}">
        <span class="name">{{$current_user_friend->user_data->name}}</span>
        @if($current_user_friend->has_new_message)
            <span class="message-notification">{{$current_user_friend->new_message_count}}</span>
        @endif
    </li>
@endforeach