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
    });
    $('.pt-photo-wrapper').hover(function(){
        $(this).children('.wrapperHoverDelete').show();
        $(this).children('.wrapperHoverLike').show();
    }) ;
    $('.pt-photo-wrapper').mouseleave(function(){
        $(this).children('.wrapperHoverDelete').hide();
        $(this).children('.wrapperHoverLike').hide();
    });
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
                    "<div class='wrapperHoverDelete removeImg' title='Remove' id='removePhoto"+ this.photoID +"'></div>" +
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
    $('body').on('click', '#cbQualityPhoto', function()
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
    $('body').on('click', '#uploadPhoto', function()
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
                    window.location.replace('/content/photo/viewAlbum?albumID='+albumID);
            }
        });
    });
    //Close or cancel upload on popUp
    $('body').on('click', '#cancelUpload', function(){
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
    //create an album
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
                    window.location.replace('/content/photo/viewAlbum?albumID='+album);
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
    $('body').on('click', '.closeMsgErrorAlbum', function() {
        $('.msgCheckAlbum').hide();
        $(".titleAlbum").css('border', '1px solid #799456');
    });
});
//need debugger
/*function addPhotoIDToElement(ClassAttribute, Attribute, nameElement){
    var getPhotoID  = photos[photoIndex].recordID;
    var photoID     = getPhotoID.replace(':','_');
    ClassAttribute.attr(Attribute, nameElement+photoID);
}*/

/*function addPhotoIDToHTML() {
    addPhotoIDToElement($('.commentBtnphoto'), 'id', 'stream-');
    addPhotoIDToElement($('.swCommentBoxphoto'), 'id', 'commentBoxphoto-');
    addPhotoIDToElement($('.swFormCommentphoto'), 'id', 'formCommentphoto-');
    addPhotoIDToElement($('.photoID'), 'value', '');
    addPhotoIDToElement($('.swBoxCommmentphoto'), 'id', 'commentTextphoto-');
    addPhotoIDToElement($('.swSubmitCommentphoto'), 'id', 'submitCommentphoto-');
    addPhotoIDToElement($('.descriptionID'), 'value', '');
}*/


$(function() {
    $('#images-container').mouseover(function(){
        $('.nextPrevious ').show();
    });
    $('#images-container').mouseout(function(){
        $('.nextPrevious').hide();
    });
    $('.nextPrevious').mouseover(function(){
        $(this).show();
    });
    $('.nextPrevious').mouseout(function(){
        $(this).hide();
    });
    $('body').on("click", "#next-photo", function()
    {
        //before click next
        currentPhotoID = photos[photoIndex].recordID.replace(':','_');
        $("." + currentPhotoID).css("display", "none");
        $("#" + currentPhotoID).css("display", "none");
        $(".description-" + currentPhotoID).css("display", "none");
        //after click next
        photoIndex = getNextPhotoIndex(photoIndex, countPhotos);
        photoID = photos[photoIndex].recordID.replace(':','_');
        $("." + photoID).css("display", "block");
        $("#" + photoID).css("display", "block");
        $(".description-" + photoID).css("display", "block");
        //show add box description if exist add description
        $('.description-'+photoID).click(function (){
            $('.BoxDescription-'+photoID).css('display', 'block');
        });
        addDescription(photoID);
        $('.cancelDescription').click(function() {
            $('.BoxDescription-'+photoID).css('display', 'none');
        });

        console.log('currentPhotoID',currentPhotoID);
        console.log('prevPhotoID',photoID);

        $('.viewMoreComments').live('click', function(){
            $(this).css("display", "none");
            $("." + currentPhotoID).css("display", "none");
            $("." + photoID).css("display", "block");
            console.log(photoID);
        });
        //add photoID
        //addPhotoIDToHTML();
        //config photo selected after click next btn
        current = $(".photo-selected");
        next = current.next(".photo-unselected");
        if (next.length == 0)
        {
            next = $("#images-container .photo-unselected").first();
        }
        next.attr("class", "photo-selected");
        current.attr("class", "photo-unselected");
        //config view content photo after click next btn
        currentContentPhoto = $(".visiblePhotoWrap");
        nextContentPhoto = currentContentPhoto.next(".invisiblePhotoWrap");
        if (nextContentPhoto.length == 0)
        {
            nextContentPhoto = $("#containerViewPhoto .invisiblePhotoWrap").first();
        }
        nextContentPhoto.attr("class", "visiblePhotoWrap");
        currentContentPhoto.attr("class", "invisiblePhotoWrap");
    });

    // prev
    $('body').on("click", "#previous-photo", function()
    {
        //before click prev
        currentPhotoID = photos[photoIndex].recordID.replace(':','_');
        $("." + currentPhotoID).css("display", "none");
        $("#" + currentPhotoID).css("display", "none");
        $(".description-" + currentPhotoID).css("display", "none");
        //after click prev
        photoIndex = getPreviousPhotoIndex(photoIndex, countPhotos);
        photoID = photos[photoIndex].recordID.replace(':','_');
        $("." + photoID).css("display", "block");
        $("#" + photoID).css("display", "block");
        $(".description-" + photoID).css("display", "block");
        //show add box description if exist add descriptions
        $('.description-'+photoID).click(function (){
            $('.BoxDescription-'+photoID).css('display', 'block');
        });
        addDescription(photoID);
        $('.cancelDescription').click(function() {
            $('.BoxDescription-'+photoID).css('display', 'none');
        });

        console.log('currentPhotoID',currentPhotoID);
        console.log('prevPhotoID',photoID);

        $('.viewMoreComments').click(function(){
            $(this).css("display", "none");
            $("." + currentPhotoID).css("display", "none");
            $("." + photoID).css("display", "block");
            console.log(photoID);
        });
        //add photoID
        //addPhotoIDToHTML();
        //config photo selected after click previous btn
        current = $(".photo-selected");
        previous = current.prev(".photo-unselected");
        if (previous.length == 0)
        {
            previous = $("#images-container .photo-unselected").last();
        }
        previous.attr("class", "photo-selected");
        current.attr("class", "photo-unselected");
        //config view content photo after click previous btn
        currentContentPhoto = $(".visiblePhotoWrap");
        previousContentPhoto = currentContentPhoto.prev(".invisiblePhotoWrap");
        if (previousContentPhoto.length == 0)
        {
            previousContentPhoto = $("#containerViewPhoto .invisiblePhotoWrap").last();
        }
        previousContentPhoto.attr("class", "visiblePhotoWrap");
        currentContentPhoto.attr("class", "invisiblePhotoWrap");
        //$(".dtDescription").html(photos[photoIndex].description);
    });

});

(function($) {
    $.fn.preload = function(images,photoIndex) {

        for (var i = 0; i < images.length; i++)
        {
            // DOM for faster creating img tag
            var image       = document.createElement('img');
            image.className = "photo-unselected";
            image.id        = photoIndex[i].recordID.replace(':','_');
            image.src       = images[i];

            //$(image).css("display", "none");
            this.append(image);
        }
    }
})( jQuery );


function getNextPhotoIndex(currentIndex, countPhotos)
{
    return ((currentIndex + 1) % countPhotos);
}

function getPreviousPhotoIndex(currentIndex, countPhotos)
{
    return ((currentIndex - 1 + countPhotos) % countPhotos);
}

function addDescription(photoID)
{
    $('.saveDescription-'+photoID).click(function() {
        var textDes = $('.textDes'+photoID).val();
        $.ajax({
            type: 'POST',
            url: '/content/photo/addDescription',
            data: {description: textDes, photoID: photoID},
            cache: false,
            success: function(){
                $('.BoxDescription-'+photoID).css('display', 'none');
                $('.description-'+photoID).detach();
                $('.descriptionVP').append("<span class='description-"+photoID+"'>"+textDes+"</span>");
            }
        });
    });
}

function SharePhoto(photoID)
{
    $('#sharePhoto').dialog();
    $.ajax({
        async: true,
        type: 'POST',
        url: '/content/photo/sharePhoto',
        data: {photoID :photoID},
        complete: function(request) {
            $('#sharePhoto').html(request.responseText);
        }
    });
}

// post a comment
$(function() {
    $(".swSubmitCommentPhoto").each(function() {
        var getId = $(this).attr('id').replace('submitCommentPhoto-','');
        $(this).live("click", function(e)
        {
            e.preventDefault();

            var comment = $("#commentTextPhoto-"+getId).val();
            if(comment=='')
            {
                return false;
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "/content/photo/postComment",
                    data: $('#formCommentPhoto-'+getId).serialize(),
                    cache: false,
                    success: function(html){
                        $("#showComment-"+getId).append(html);
                        $("#commentTextPhoto-"+getId).val('');
                    }
                });
            }
            return false;
        });
    });

    //show comment box when click to comment link
    $(".commentBtnPhoto").each(function(){
        var getId = $(this).attr('id').replace('stream-','');
        //var Id = getId.replace(':','_');
        $(this).live("click",function(e){
                e.preventDefault();
                console.log('ddd', getId);

                $('#commentBoxPhoto-'+getId).fadeIn("slow");
                $('#commentTextPhoto-'+getId).focus();
            }
        );
    });
    //view more comment photos
    $("body").on("click", ".view-more-commentPhoto", function(e){
        e.preventDefault();

        // get first comment published
        published   = $(e.target.parentElement).children(".swCommentPostedPhoto:first").find(".swTimeComment").attr("title");
        statusID    = e.target.id;
        $.ajax({
            type: "POST",
            url: "/content/photo/morePhotoComment",
            data: { published:published, statusID:statusID},
            cache: false,
            success: function(html){
                //console.log(e.target.parentElement);
                $('.view-more-commentPhoto').css('display', 'none');
                //e.target.parentElement.prepend(html);
                $(e.target).after(html);
            }
        });
    });
});

