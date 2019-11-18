@foreach($groups as $group)
    {{--<span class="edit-group" data-group-id="{{$group->id}}"><i class="fas fa-edit"></i></span>--}}
    <span class="edit-group delete-group" data-group-id="{{$group->id}}"><i class="fas fa-trash"></i></span>

    <li class="group-item" id="group-item-{{$group->id}}" data-group-id="{{$group->id}}">
        <div class="avatar-container">
            <img src="{{$group->group_avatar}}">
        </div>

        <span class="name">{{(strlen($group->name) > 12)? substr($group->name, 0, 12) . '...' : $group->name}}</span>
        @if($group->has_new_message)
            <span class="message-notification">{{$group->new_message_count}}</span>
        @endif
    </li>

@endforeach