$(document).ready(function () {
    $('textarea#content').on('focus', function () {
        $(this).parents('.post').animate({ height: 280 }, 'slow');
        $('.image-upload').fadeIn(500);
        $('.image-show').fadeIn(500);
        $('.post-action').fadeIn(1000);
    });
    $(document).mouseup(function(e)
    {
        var container = $("div.post");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $('.image-upload').hide();
            $('.image-show').hide();
            $('.post-action').hide();
            $('div.post').animate({ height: 142 }, 'slow');
        }
    });
});

