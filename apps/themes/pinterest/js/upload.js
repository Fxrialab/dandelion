$(document).ready(function()
{
    var uploadPhotoGroup = {
        url: "/content/group/uploadphoto",
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
        onSuccess: function(files, data, xhr)
        {
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
        beforeSend: function() {
            //Lets add a loading image
            $('.infoUser').addClass('loading');
        },
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $('.avatar').html(data);

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
        url: "/upload",
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
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $(".msg").html('');
            $.each(data.results, function() {
                $("#imgTemplate").tmpl(data.results).appendTo("#embedPhotos");
            });
            new Hover();
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
    $("#multiFiles2").uploadFile(settingMultiFiles2);
    $("#multiFiles3").uploadFile(settingMultiFiles2);
   
});