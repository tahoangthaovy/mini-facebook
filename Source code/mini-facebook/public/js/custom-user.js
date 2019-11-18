$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('button.remove-friend').on('click', function () {
        friendId = $(this).data('user-id');
        var url = '/friends/delete/' + friendId;
        var confirmDelete = confirm('Are you sure?');
        if (confirmDelete){
            $.ajax({
                url: url,
                type: 'POST',
                contentType: 'application/json',
                success: function(response){
                    console.log(JSON.parse(response));
                    $('li#friend-' + friendId).remove();
                },
                error: function (req, status, err) {
                    console.log('Something went wrong', status, err);
                }
            });
        }

    });

    $('button.accept-request').on('click',function () {
        friendId = $(this).data('user-id');
        var url = '/friends/accept/' + friendId;
        $.ajax({
            url: url,
            type: 'POST',
            contentType: 'application/json',
            success: function(response){
                console.log(JSON.parse(response));
                $('li#request-' + friendId).remove();
            },
            error: function (req, status, err) {
                console.log('Something went wrong', status, err);
            }
        });
    });

    $('button.remove-request').on('click',function () {
        friendId = $(this).data('user-id');
        var url = '/friends/delete/' + friendId;
        var confirmDelete = confirm('Are you sure?');
        if (confirmDelete) {
            $.ajax({
                url: url,
                type: 'POST',
                contentType: 'application/json',
                success: function (response) {
                    console.log(JSON.parse(response));
                    $('li#request-' + friendId).remove();
                },
                error: function (req, status, err) {
                    console.log('Something went wrong', status, err);
                }
            });
        }
    });

    $('button.add-friend').on('click',function () {
        friendId = $(this).data('user-id');
        var url = '/friends/add/' + friendId;
        $.ajax({
            url: url,
            type: 'POST',
            contentType: 'application/json',
            success: function(response){
                console.log("success");
                $('button.add-friend').replaceWith(
                    '<button type="button" class="btn btn-default" disabled>' +
                    '<i class="fas fa-user-plus"></i> Request Sent' +
                    '</button>'
                );
                $('li#friend-' + friendId).remove();
            },
            error: function (req, status, err) {
                console.log('Something went wrong', status, err);
            }
        });
    });

    $('textarea.comment').keypress(function (e) {
        var input = $(this);
        if (e.which === 13 && !e.shiftKey) {
            var userId = $(this).data('user-id');
            var postId = $(this).data('post-id');
            var commentContent = $(this).val();
            var url = '/comments/create';
            $(this).val('');
            var formData = JSON.stringify({
                'image_path': '',
                'user_id': userId,
                'post_id': postId,
                'comment_content': commentContent
            });
            console.log(formData);
            $.ajax({
                url: url,
                type: 'POST',
                contentType: 'application/json',
                data: formData,
                success: function(response){
                    data = JSON.parse(response);
                    $('#post-item-'+postId).find('span.comment-count').html(data.comment_count);
                    console.log(data.comment.id);
                    console.log("success");
                    $('#post-item-' + postId + ' .show-comment-container').prepend(
                        '<div class="row comment-item">' +
                        '<div class="col-sm-1">' +
                        '<div class="avatar-container">' +
                        '<img src="' + data.current_user.avatar + '" class="avatar-small">' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-sm-11">' +
                        '<p class="comment-content"> <a href="/users/' + data.current_user.id + '"><span class="comment-owner">' + data.current_user.name + '</span></a>' + commentContent + '</p>' +
                        '</div>' +
                        '' +
                        '<div class="col-sm-12">' +
                        '<div class="comment-action">' +
                        ' <div class="btn-group">' +
                        '<button type="button" class="btn btn-default edit-comment" data-comment-id="'+data.comment.id+'" data-post-id="' + postId + '">' +
                        ' <i class="fas fa-edit"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-default delete-comment" data-comment-id="'+data.comment.id+'" data-post-id="' + postId + '">' +
                        '<i class="fas fa-trash-alt"></i>' +
                        '</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'

                    );
                    $('textarea.comment').val('');
                },
                error: function (req, status, err) {
                    console.log('Something went wrong', status, err);
                }
            });
        }
    });


    $(document).on('click', '.delete-comment', function () {
        commentId = $(this).data('comment-id');
        url = "/comments/"+commentId;
        var postId = $(this).data('post-id');
        var formData = JSON.stringify({
            'post_id': postId
        });
        var commentCount = ($('#post-item-'+postId).find('span.comment-count').html());
        console.log(commentCount);
        commentCount = commentCount - 1;
        console.log(commentCount);
        confirmDelete = confirm('Are you sure?');
        if (confirmDelete){
            $.ajax({
                url: url,
                type: 'DELETE',
                contentType: 'application/json',
                data: formData,
                success: function(response){
                    data = JSON.parse(response);
                    $('#post-item-'+postId).find('span.comment-count').html(commentCount);
                    $('button.delete-comment[data-comment-id='+commentId+']').parents('.comment-item').remove();
                },
                error: function (req, status, err) {
                    console.log('Something went wrong', status, err);
                }
            });
        }
    });

    $(document).on('click', '.edit-comment', function () {
        $('.comment-item').show();
        commentId = $(this).data('comment-id');
        postId = $(this).data('post-id');
        url = "/comments/"+commentId;

        $.ajax({
            url: url,
            type: 'GET',
            contentType: 'application/json',
            success: function(response){
                data = JSON.parse(response);
                $('#post-item-' + postId).find('textarea.comment').val(data.comment_content).focus().addClass('edit');

            },
            error: function (req, status, err) {
                console.log('Something went wrong', status, err);
            }
        });

        $.ajax({
            url: url,
            type: 'DELETE',
            contentType: 'application/json',
            success: function(response){
                data = JSON.parse(response);
                console.log("success");
                $('button.delete-comment[data-comment-id='+commentId+']').parents('.comment-item').remove();
            },
            error: function (req, status, err) {
                console.log('Something went wrong', status, err);
            }
        });
    });

    $('.change-avatar').on('click', function () {

    });


});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.avatar-cover')
                .attr('src', e.target.result)
                .width('100%');
            $('.avatar-cover-container').css('display', 'block');
        };

        reader.readAsDataURL(input.files[0]);
    }
}