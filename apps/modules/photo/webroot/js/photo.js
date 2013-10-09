/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 10/4/13 - 10:50 AM
 * Project: userwired Network - Version: 1.0
 */
$(function() {
    $(".uploadAlbum").click(function() {
        $('#lightBox').show();
        $('#fade').show();
    });
    $("#closeLightBox").click(function() {
        $('#lightBox').hide();
        $('#fade').hide();
    });
    $(".uploadPhoto").click(function() {
        //console.log('clicked upload btn');
        $('#lightUpload').show();
        $('#fade').show();
    });
    $("#icon-menu").click(function(){
        $('#lightUpload').hide();
        $('#fade').hide();
    }) ;
});

$(document).ready(function()
{
    var settings = {
        url: "/content/photo/loadingPhoto",
        method: "POST",
        allowedTypes:"jpg,png,gif",
        fileName: "myfile",
        multiple: true,
        onSuccess:function(files,data,xhr)
        {
            $('.ajax-file-upload-statusbar').fadeOut('slow');
            $.each(data.results, function(){
                console.log(this.url);
                $('#displayPhotos').append("<form class='photoDataItems' id='photoItems-"+ this.photoID +"'>" +
                    "<div class='photoWrap'>" +
                    "<div class='loadedPhoto' id='photo"+ this.photoID +"'>" +
                    "<div class='wrapperHoverDelete deleteImg removeImg' title='Remove' id='removePhoto"+ this.photoID +"'></div>" +
                    "<img src='"+ this.url +"' title='"+ this.fileName +"'/>" +
                    "</div> " +
                    "<div class='writeSomething'>" +
                    "<textarea rows='4' id='someThingAboutPhoto-"+ this.photoID +"' placeholder='Write something about this photo'></textarea>" +
                    "</div>" +
                    "</div>" +
                    "</form>");
                $('#removePhoto'+this.photoID).click(function(){
                    var photoID = $(this).attr('id').replace('removePhoto','');
                    console.log(photoID);
                    $.ajax({
                        type: 'POST',
                        url: '/content/photo/removePhoto',
                        data: {photoID: photoID},
                        cache: false,
                        success: function(){
                            $('#photoItems-'+photoID).detach();
                        }
                    });
                });
            });
            new Hover();
        },
        onError: function(files,status,errMsg)
        {
        $("#status").html("<font color='red'>Upload is Failed</font>");
        }
    };
$("#mulitplefileuploader").uploadFile(settings);

});

function Hover()
{
    $('.loadedPhoto').hover(function(){
        $(this).children('.wrapperHoverDelete').show();
    }) ;
    $('.loadedPhoto').mouseleave(function(){
        $(this).children('.wrapperHoverDelete').hide();
    });
}

$(function(){
    $('#cbQualityPhoto').live('click', function()
    {
        var stageCB = $('#cbQualityPhoto').attr('value');
        if (stageCB == '')
        {
            $(this).attr('value', 'checked');
        }
        if (stageCB == 'checked')
        {
            $(this).attr('value', '');
        }
    });
    //agree upload photos
    $('#uploadPhoto').live('click', function()
    {
        var stageCB = $('#cbQualityPhoto').attr('value');
        var photos  = [];
        var albumID = $('#albumID').attr('value');
        $('.photoDataItems').each(function()
        {
            var photoID = $(this).attr('id').replace('photoItems-','');
            var somethingPhoto = $('#someThingAboutPhoto-'+photoID).val();
            photos.push({photoID:photoID, description:somethingPhoto});
        });
        $.ajax({
            type: "POST",
            url: "/content/photo/uploadPhoto",
            data: {data: photos, stage: stageCB, albumID:albumID},
            cache: false,
            success: function(){
                if (albumID == 'none')
                    window.location.replace('/content/photo/myPhoto');
                else
                    window.location.replace('/content/photo/viewAlbum?id='+albumID);
            }
        });
    });
    //Close or cancel upload on popUp
    $('#cancelUpload').live('click', function(){
        var existPhotoItems = $('.photoDataItems').length;
        if (existPhotoItems == 0)
        {
            $('#lightUpload').hide();
            $('#fade').hide();
        }else {
            var photos  = [];
            $('.photoDataItems').each(function()
            {
                var photoID = $(this).attr('id').replace('photoItems-','');
                photos.push(photoID);
            });
            $.ajax({
                type: "POST",
                url: "/content/photo/removePhoto",
                data: {photoID: photos},
                cache: false,
                success: function(){
                    window.location.replace('/content/photo/myPhoto');
                }
            });
        }
    });
    $(".createAlbumButton").click(function() {
        if($('.titleAlbum').val() !='') {
            $.ajax({
                type: "POST",
                url:  "/content/photo/createAlbum",
                data: $('#albumInfo').serialize(),
                cache: false,
                success:function(html)
                {
                    var album   = html.replace(':','_');
                    window.location.replace('/content/photo/viewAlbum?id='+album);
                }
            });
            $('#lightBox').css('display', 'none');
            $('#fade').css('display', 'none');
            return false;
        }else {
            $(".titleAlbum").css('border', '1px solid red');
            $(".titleAlbum").focus();
            $('.msgCheckAlbum').show();
            return false;
        }
    });
});


