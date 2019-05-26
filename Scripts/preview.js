$( document ).ready(function() {

    $('#preview-btn').click(function() {

        $('#preview-div').css('visibility', 'visible');
        $('#user_name-preview').html($('#user_name').val());
        $('#user_email-preview').html($('#user_email').val());
        $('#text-preview').html($('#text').val());

        var preview = document.querySelector('#task_img-preview');
        var file    = document.querySelector('input[type=file]').files[0];
        var reader  = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }

    });

});