

$("body").on('click', '#addMember', function (e) {
    e.preventDefault();
    var title = $(this).attr('title');
    var href = $(this).attr('href');
    var groupID = $(this).attr('rel');
    $.ajax({
        type: "POST",
        url: href,
        data: {groupID: groupID},
        success: function (data) {
            $(".dialog").dialog({
                width: "500",
                height: "160",
                position: ['top', 120],
                title: title,
                resizable: false,
                modal: true,
                open: function (event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $(".dialog").html(data);
                }
            });


        }
    });
});

$("body").on('click', '.removeGroup', function (e) {
    e.preventDefault();
    var title = $(this).attr('title');
    var href = $(this).attr('href');
    var userID = $(this).attr('rel');
    var groupID = $("#group_id").val();

    $.ajax({
        type: "POST",
        url: href,
        data: {groupID: groupID, userID: userID},
        success: function (data) {
            $(".dialog").dialog({
                width: "500",
                height: "160",
                position: ['top', 120],
                title: title,
                resizable: false,
                modal: true,
                open: function (event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $('.dialog').html('<div><img src="<?php echo IMAGES ?>/loadingIcon.gif"</div>');
                }
            });
            $(".dialog").html(data);

        }
    });
});
$("body").on('click', '.roleGroup', function (e) {
    e.preventDefault();
    var title = $(this).attr('title');
    var href = $(this).attr('href');
    var userID = $(this).attr('rel');
    var groupID = $("#group_id").val();
    $.ajax({
        type: "POST",
        url: href,
        data: {groupID: groupID, userID: userID},
        success: function (data) {
            $(".dialog").dialog({
                width: "500",
                height: "160",
                position: ['top', 120],
                title: title,
                resizable: false,
                modal: true,
                open: function (event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $('.dialog').html('<div><img src="<?php echo IMAGES ?>/loadingIcon.gif"</div>');
                }
            });
            $(".dialog").html(data);

        }
    });
});

$("body").on('click', '.removeImgUser', function (e) {
    var title = $(this).attr('title');
    var data = [
        {role: $(this).attr('role')},
    ];
    $(".dialog").dialog({
        width: "500",
        height: "160",
        position: ['top', 100],
        title: title,
        resizable: false,
        modal: true,
        open: function (event, ui) {
            $(".ui-dialog-titlebar-close").hide();
            $('body').css('overflow', 'hidden'); //this line does the actual hiding
//            $(".dialog").html(data);
            $("#comfirmTemplate").tmpl(data).appendTo(".dialog");
        }
    });
});


$("body").on('click', '.comfirmDialogGroup', function (e) {
    e.preventDefault();
    var groupID = $("#groupID").val();
    $.ajax({
        type: "POST",
        url: "/content/group/remove",
        data: {groupID: groupID},
        success: function () {
            $('.imgCoverGroup').remove();
            $('.rCoverGroup').remove();
            $('.removeImgGroup').remove();
            $(".dialog").dialog("close");
        }
    });
});


$("body").on('click', '.cancelCoverGroup', function (e) {
    e.preventDefault();
    var target = $(this).attr('id');
    var groupID = $('#groupID').attr('value');
    $.ajax({
        type: "POST",
        url: "/content/group/cancelCover",
        data: {target: target, groupID: groupID},
        success: function (data) {
            var obj = jQuery.parseJSON(data);
            if (target == 'coverGroup')
            {
                if (obj.src)
                {
                    $('.displayPhoto .imgCoverGroup').html('<div style="width:' + obj.width + 'px; height:' + obj.height + 'px;  position: relative; left: -' + obj.left + 'px; top: -' + obj.top + 'px" > \n\
                    <img src="' + obj.src + '" style="width:100%;"> \n\
                    </div>');
                } else {
                    $('.displayPhoto .imgCoverGroup').remove();
                }
                $('.actionCover').css('display', 'block');
                $('.actionCoverGroup').css('display', 'none');
            }
            return false;
        }
    });

});

$("body").on('click', '.changePhoto_group', function (e) {
    e.preventDefault();
    $.pgwModal('close');
    var url = $(this).attr('href');
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            $(".displayPhoto").html(data);

            $('.actionCover').css('display', 'none');

        }
    });
});
$("body").on('click', '.rCoverGroup', function (e) {
    e.preventDefault();
    var id = $(this).attr('rel');
    $.ajax({
        type: "POST",
        url: "/content/group/reposition",
        data: {id: id},
        success: function (data) {
            $('.imgCoverGroup').html(data);
            $('.actionCover').css('display', 'none');
        }
    });
});

$("body").on('submit', '#coverPhotoGroup', function (e) {
    $.ajax({
        type: "POST",
        url: "/content/group/saveCover",
        data: $("#coverPhotoGroup").serialize(), // serializes the form's elements.
        success: function ()
        {
            $('.actionCoverGroup').css('display', 'none');
            $('.actionCover').css('display', 'block');
            $('.dragCover').css('cursor', 'pointer');
        }
    });
    return false; // avoid to execute the actual submit of the form.
});
