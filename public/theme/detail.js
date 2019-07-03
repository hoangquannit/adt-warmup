(function ($) {
    'use strict';
    // **********************************************************************//
// ! Read URL upload file
// Image Feature
// **********************************************************************//
    var readURLFeature = function () {
        var $blockFeature = $('#block-feature');
        $blockFeature.on('click', function (e) {
            if ($(e.target).is('.upload-file')) {
                $('.upload-control').click();
                $('.upload-control').on('change', function () {
                    var $this = $(this),
                        input = $this[0]
                    if (input.files && input.files[0]) {
                        var imagefile = input.files[0].type;
                        var size      = input.files[0].size;

                        var match= ["image/jpeg","image/png","image/jpg"];
                        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
                        {
                            $(".message-errors").html('image error');
                            $(".message-errors").show().delay(5000).fadeOut();
                            return false;
                        }else if(size > 2097152) {
                            $(".message-errors").html('image size error > 2Mb');
                            $(".message-errors").show().delay(5000).fadeOut();
                            return false;
                        }else {
                            $('#upload_cover_image').submit();
                        }
                    }
                });
            }
        });
    };

// **********************************************************************//
// !  upload avatar
// **********************************************************************//
    var uploadCoverImage = function () {
        $("#upload_cover_image").on('submit',(function(e) {
            e.preventDefault();
            $.blockUI();
            $.ajax({
                url: 'user/avatar',
                type: "POST",
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,        // To send DOMDocument or non processed data file it is set to false
                success: function (data)
                {
                    var d = new Date();
                    $('#main-cover-image').attr('src', data);
                    setTimeout($.unblockUI, 2000);
                },
                error: function (xhr, textStatus) {
                    $.unblockUI();
                    $(".message-errors").html(textStatus);
                    $(".message-errors").show().delay(5000).fadeOut();
                    return false;
                }
            });
        }));
    };


    $(document).ready(function () {
        readURLFeature();
        uploadCoverImage();
    });
})(jQuery);