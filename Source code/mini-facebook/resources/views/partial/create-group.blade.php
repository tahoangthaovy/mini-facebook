<!-- Modal -->
<div class="modal fade" id="add-group-modal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {!! Form::open(['method'=>'POST', 'action'=>'GroupController@addNewGroup', 'id'=>'post', 'enctype'=>'multipart/form-data']) !!}
            <div class="modal-header">
                <h4 class="modal-title">Add Group</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{ csrf_field() }}

                <div class="form-group group-name">
                    {!! Form::label('name', 'Group Name:') !!}
                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Enter name...', 'required']) !!}
                </div>

                <div class="form-group group-avatar">
                    {!! Form::label('image', 'Choose Avatar:') !!}
                    {!! Form::file('image', ['class'=>'form-control']) !!}
                </div>

                {!! Form::label('users', 'Add Friends:') !!}
                <div class="form-group select-users">
                    {{--Loop checkboxes here--}}

                    <div class="container">
                        @foreach($current_user_friends as $current_user_friend)
                            <div class="row">
                                <div class="col-sm-1">
                                    <input name="users[]" type="checkbox" value="{{$current_user_friend->user_data->id}}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="avatar-container">
                                        <img src="{{$current_user_friend->user_data->avatar}}" class="avatar" style="width: 30px;">
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <label for="users[]">
                                        {{$current_user_friend->user_data->name}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                {!! Form::submit('Submit', ['class'=>'btn btn-primary submit-new-group']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>