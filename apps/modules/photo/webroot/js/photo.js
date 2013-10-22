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
                    window.location.replace('/content/photo/viewAlbum?albumID='+albumID);
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
    $('.closeMsgErrorAlbum').live('click', function() {
        $('.msgCheckAlbum').hide();
        $(".titleAlbum").css('border', '1px solid #799456');
    });
});
//need debugger
function addPhotoIDToElement(ClassAttribute, Attribute, nameElement){
    var getPhotoID  = photos[photoIndex].recordID;
    var photoID     = getPhotoID.replace(':','_');
    ClassAttribute.attr(Attribute, nameElement+photoID);
}

function addPhotoIDToHTML() {
    addPhotoIDToElement($('.commentBtnphoto'), 'id', 'stream-');
    addPhotoIDToElement($('.swCommentBoxphoto'), 'id', 'commentBoxphoto-');
    addPhotoIDToElement($('.swFormCommentphoto'), 'id', 'formCommentphoto-');
    addPhotoIDToElement($('.photoID'), 'value', '');
    addPhotoIDToElement($('.swBoxCommmentphoto'), 'id', 'commentTextphoto-');
    addPhotoIDToElement($('.swSubmitCommentphoto'), 'id', 'submitCommentphoto-');
    addPhotoIDToElement($('.descriptionID'), 'value', '');
}


$(function() {
    /*var getNumberPhotos  = $('#numberPhoto').attr('value');
     if(getNumberPhotos > 2){*/
    /*$('.nextPrevious').hide();*/
    $('#images-container').mouseover(function(){
        $('.nextPrevious ').show();
    });
    $('#images-container').mouseout(function(){
        $('.nextPrevious').hide();
    });
    $('.nextPrevious').mouseover(function(){
        $(this).show();
    });
    // }
    $("#next-photo").live("click", function(){
        console.log('next',photoIndex);
        currentPhotoID = photos[photoIndex].recordID.replace(':','_');
        $("." + currentPhotoID).css("display", "none");
        $("#" + currentPhotoID).css("display", "none");
        $(".description-" + currentPhotoID).css("display", "none");
        photoIndex = getNextPhotoIndex(photoIndex, countPhotos);
        photoID = photos[photoIndex].recordID.replace(':','_');
        $("." + photoID).css("display", "block");
        $("#" + photoID).css("display", "block");


        var getNumberComments = $('.' + photoID).size();
        if(getNumberComments) {
            var numCommentHide = getNumberComments - 4;
            $("." + photoID+":lt("+numCommentHide+")").css("display", "none");
        }

        if($('#checkAppendTo').hasClass(photoID)) {
            $('#checkAppendTo').css("display", "block");
            $(".description-" + photoID).css("display", "none");
        }else {
            $(".description-" + photoID).css("display", "block");
        }

        $('.viewMoreComments').live('click', function(){
            $(this).css("display", "none");
            $("." + currentPhotoID).css("display", "none");
            $("." + photoID).css("display", "block");
            console.log(photoID);
        });
        //add photoID
        addPhotoIDToHTML();
        current = $(".photo-selected");
        next = current.next(".photo-unselected");

        if (next.length == 0)
        {
            next = $("#images-container .photo-unselected").first();
        }
        //console.log(next);

        next.attr("class", "photo-selected");
        current.attr("class", "photo-unselected");

        currentContentPhoto = $(".visiblePhotoWrap");
        nextContentPhoto = currentContentPhoto.next(".invisiblePhotoWrap");

        if (nextContentPhoto.length == 0)
        {
            nextContentPhoto = $("#containerViewPhoto .invisiblePhotoWrap").first();
        }
        //console.log(next);

        nextContentPhoto.attr("class", "visiblePhotoWrap");
        currentContentPhoto.attr("class", "invisiblePhotoWrap");
        //$(".dtDescription").html(photos[photoIndex].description);

    });

    // prev
    $("#previous-photo").live("click", function(){
        console.log('prev',photoIndex);
        var check  = $('#checkAppendTo').val();

        currentPhotoID = photos[photoIndex].recordID.replace(':','_');
        $("." + currentPhotoID).css("display", "none");
        $("#" + currentPhotoID).css("display", "none");
        $(".description-" + currentPhotoID).css("display", "none");
        photoIndex = getPreviousPhotoIndex(photoIndex, countPhotos);
        photoID = photos[photoIndex].recordID.replace(':','_');
        $("." + photoID).css("display", "block");
        $("#" + photoID).css("display", "block");

        var getNumberComments = $('.' + photoID).size();
        if(getNumberComments) {
            var numCommentHide = getNumberComments - 4;
            $("." + photoID+":lt("+numCommentHide+")").css("display", "none");
        }

        if($('#checkAppendTo').hasClass(photoID)) {
            $('#checkAppendTo').css("display", "block");
            $(".description-" + photoID).css("display", "none");
        }else {
            $(".description-" + photoID).css("display", "block");
        }

        $('.viewMoreComments').click(function(){
            $(this).css("display", "none");
            $("." + currentPhotoID).css("display", "none");
            $("." + photoID).css("display", "block");
            console.log(photoID);
        });
        //add photoID
        addPhotoIDToHTML();
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

$(document).ready(function() {
    $('.album').hover(function(){
    });
    //add photoID to html
    addPhotoIDToHTML();
    $('.BoxDescription').hide();
    currentPhotoID      = photos[photoIndex].recordID.replace(':','_');
    console.log('currentPhotoID', photoIndex);
    $("." + currentPhotoID).css("display", "block");

    var getNumberComments = $("." + currentPhotoID).size();
    if(getNumberComments) {
        var numCommentHide = getNumberComments - 4;
        $("." + currentPhotoID+":lt("+numCommentHide+")").hide();
    }
    console.log('curPhotoIndex', photoIndex);
    $(".description-" + currentPhotoID).css("display", "block");
    nextPhotoIDIndex    = getNextPhotoIndex(photoIndex, countPhotos);
    nextPhotoID         = photos[nextPhotoIDIndex].recordID.replace(':','_');
    console.log('nextPhotoIDIndex', nextPhotoIDIndex);
    $("#" + nextPhotoID).css("display", "none");
    $(".description-" + nextPhotoID).css("display", "none");

    prevPhotoIDIndex    = getPreviousPhotoIndex(photoIndex, countPhotos);
    prevPhotoID         = photos[prevPhotoIDIndex].recordID.replace(':','_');
    //$("." + prevPhotoID).css("display", "none");
    $("#" + prevPhotoID).css("display", "none");
    $(".description-" + prevPhotoID).css("display", "none");

    $('.viewMoreComments').click(function(){
        $(this).css("display", "none");
        $("." + currentPhotoID).css("display", "block");
    });
    $('.dtDescription').click(function(){
        $('.BoxDescription').fadeIn();
    });
    $('.cancelDescription').live('click', function(){
        $('.BoxDescription').fadeOut();
    });
    // preload others
    if (typeof(urls) != 'undefined') {
        console.log('urls', urls);
        //urls.shift();
        $("#images-container").preload(urls, photos);
    }
});

