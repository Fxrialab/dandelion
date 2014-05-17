$(document).ready(function()
{
    var uploadPhotoGroup = {
        url: "/content/group/uploadphoto",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $('#displayPhotoGroup').html(data);

        },
        onError: function(files, status, errMsg)
        {
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    };
    var uploadPhotoSingleFile = {
        url: "/uploadPhoto",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $('.displayPhoto').html(data);
            $('.editdropdown').css('display', 'none');
            $('.timeLineMenuNav').html('<nav class="ink-navigation "><ul class="menu horizontal uiTimeLineHeadLine float-right">\n\
                            <li><button type="submit" class="ink-button closeDialog">Cancel</button></li>\n\
                            <li><button type="submit" class="ink-button green-button">Save Changes</button></li>\n\
                            </ul></nav>');

        },
        onError: function(files, status, errMsg)
        {
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    };
    var uploadAvatar = {
        url: "/uploadavatar",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $('#imgAvatar').html(data);

        },
        onError: function(files, status, errMsg)
        {
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    };
    var settingSingleFile = {
        url: "/content/photo/loadingPhoto",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: false,
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
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
        url: "/content/photo/loadingPhoto",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: true,
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $.each(data.results, function() {
                console.log(this.url);
                $('#embedPhotos').append("<div class='photoWrap' id='photoItem-" + this.photoID + "'>" +
                        "<input type='hidden' id ='imgID' name='imgID[]' value='" + this.photoID + "'/>" +
                        "<img src='" + this.url + "' title='" + this.fileName + "'/>" +
                        "</div>");
                $('#removePhoto' + this.photoID).click(function() {
                    var photoID = $(this).attr('id').replace('removePhoto', '');
                    console.log(photoID);
                    $.ajax({
                        type: 'POST',
                        url: '/content/photo/removePhoto',
                        data: {photoID: photoID},
                        cache: false,
                        success: function() {
                            $('#photoItems-' + photoID).detach();
                        }
                    });
                });
            });
            new Hover();
        },
        onError: function(files, status, errMsg)
        {
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    };
    var settingMultiFiles2 = {
        url: "/content/photo/loadingPhoto",
        method: "POST",
        allowedTypes: "jpg,png,gif",
        fileName: "myfile",
        multiple: true,
        onSuccess: function(files, data, xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $.each(data.results, function() {
                console.log(this.url);
                $('#displayPhotos').append("<div class='photoWrap' id='photoItem" + this.photoID + "'>" +
                        "<div class='loadedPhoto' id='photo" + this.photoID + "'>" +
                        "<img src='" + this.url + "' title='" + this.fileName + "'/>" +
                        "</div> " +
                        "</div>");
                $('#removePhoto' + this.photoID).click(function() {
                    var photoID = $(this).attr('id').replace('removePhoto', '');
                    console.log(photoID);
                    $.ajax({
                        type: 'POST',
                        url: '/content/photo/removePhoto',
                        data: {photoID: photoID},
                        cache: false,
                        success: function() {
                            $('#photoItems-' + photoID).detach();
                        }
                    });
                });
            });
            new Hover();
        },
        onError: function(files, status, errMsg)
        {
            $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    };
    $("#uploadAvatar").uploadFile(uploadAvatar);
    $("#uploadPhotoCover").uploadFile(uploadPhotoSingleFile);
    $("#uploadPhotoGroup").uploadFile(uploadPhotoGroup);
    $("#singleFile").uploadFile(settingSingleFile);
    $("#multiFiles").uploadFile(settingMultiFiles);
    $("#multiFiles2").uploadFile(settingMultiFiles2);


});