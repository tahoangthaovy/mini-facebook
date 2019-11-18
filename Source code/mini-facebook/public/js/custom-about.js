$(document).ready(function () {
    $(document).on('click', '.cancel-update', function () {
        $('textarea#about').val('');
        $('.edit-about').hide();

    });
    $(document).on('click', 'button.edit', function () {
        aboutContent = $('#about-content').val();
        $('.edit-about').css('display', 'block');
        $('textarea#about').val(aboutContent);
    });
});
