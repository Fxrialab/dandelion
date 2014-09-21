$(document).ready(function()
{
    var uploadPhotoGroup = {
        url: "/content/group/uploadCover",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onBeforeSend: function() {
            $('.ajax-file-upload-statusbar').hide();
            $(".msg").html("<div class='loadingUpload'></div>");
        },
        onSuccess: function(files, data, xhr)
        {
            $(".msg").html("");
            $('.displayPhoto').html(data);
            $('.actionCover').css('display', 'none');
            //$("#navCoverPhotoGroupTemplate").tmpl(data).appendTo(".displayPhoto");
        }
    };
    var uploadPhotoSingleFile = {
        url: "/uploadCover",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onBeforeSend: function() {
            $('.ajax-file-upload-statusbar').hide();
            $(".uploadCoverStatusBar").html("<div class='loadingUpload'></div>");
        },
        onSuccess: function(files, data, xhr)
        {
            $(".uploadCoverStatusBar").html("");
            $('.arrow_timeLineMenuNav').hide();
            $('.displayPhoto').html(data);
            $('.timeLineMenuNav div').remove();
            $("#navCoverUserTemplate").tmpl(data).appendTo(".timeLineMenuNav");
        }
    };
    var uploadAvatar = {
        url: "/uploadAvatar",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onBeforeSend: function() {
            //Lets add a loading image
            $(".uploadCoverStatusBar").html("<div class='loadingUpload'></div>");
        },
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $('.infoUser').html(data);
            $('.profileInfo .dropdown').css('display', 'none');
            $('.profilePic .profileInfo').css('display', 'none');

        }
    };
    var settingSingleFile = {
        url: "/content/photo/loadingPhoto",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onBeforeSend: function() {
            $('.ajax-file-upload-statusbar').hide();
            $(".msg").html("<div class='loadingUpload'></div>");
        },
        onSuccess: function(files, data, xhr)
        {
            $.each(data.results, function() {
                console.log(this.url);
                $('#displayPhotoGroup').html("<div id='photoItem-" + this.photoID + "'>" +
                        "<input type='hidden' id ='imgID' name='imgID[]' value='" + this.photoID + "'/>" +
                        "<img src='" + this.url + "' title='" + this.fileName + "'/>" +
                        "</div>");
            });
            new Hover();
        },
        onError: function(files, status, errMsg)
        {
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    };
    var settingMultiFiles = {
        url: "/uploading",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: true,
        onBeforeSend: function() {
            $('.ajax-file-upload-statusbar').hide();
            $(".msg").html("<div class='loadingUpload'></div>");
        },
        onSuccess: function(files, data, xhr)
        {
            if ($('#iStatus').hasClass('hide-all'))
            {
                $('#iStatus').removeClass('hide-all');
                $('#iStatus').addClass('active');
                $('#iPhoto').removeClass('active');
                $('#iPhoto').addClass('hide-all');
                $('li#statusTab').addClass('active');
                $('li#photoTab').removeClass('active');
            }
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $(".msg").html('');
            $.each(data.results, function() {
                $("#imgTemplate").tmpl(data.results).appendTo("#embedPhotos");
            });
        },
        onError: function(files, status, errMsg)
        {
            $("#status").html("Upload is Failed");
        }
    };
    var settingMultiFiles2 = {
        url: "/upload",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: true,
        onBeforeSend: function() {
            $(".viewUpload").show();
            $('.ajax-file-upload-statusbar').hide();
            $(".msg").html("<div class='loadingUpload'></div>");
            $(".photoBoxArrow").hide();
            $(".postPhoto").show();
            $("#statusPhoto").show();
        },
        onSuccess: function(files, data, xhr)
        {
            $(".msg").html("");
            $.each(data.results, function() {
                $("#imgTemplate2").tmpl(data.results).appendTo(".viewUpload");
            });
            new Hover();
        },
        onError: function(files, status, errMsg)
        {
            $(".imgUpload").html("Upload is Failed");
        }
    };

    $("#uploadAvatar").uploadFile(uploadAvatar);
    $("#uploadPhotoCover").uploadFile(uploadPhotoSingleFile);
    $("#uploadPhotoGroup").uploadFile(uploadPhotoGroup);
    $("#singleFile").uploadFile(settingSingleFile);
    $("#multiFiles").uploadFile(settingMultiFiles);
    $("#multiFiles2").uploadFile(settingMultiFiles);
    $("#multiFiles3").uploadFile(settingMultiFiles2);
   
});