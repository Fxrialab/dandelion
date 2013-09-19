// show/close light box for creating new album
//http://jquerypopupwindow.com/#download
//http://demo.tutorialzine.com/2010/12/better-confirm-box-jquery-css3/
$(function(){
    $('.pt-photo-wrapper').hover(function(){
        $(this).children('.wrapperHoverDelete').show();
        $(this).children('.wrapperHoverLike').show();
    }) ;
    $('.pt-photo-wrapper').mouseleave(function(){
        $(this).children('.wrapperHoverDelete').hide();
        $(this).children('.wrapperHoverLike').hide();
    });
    $('.Del').click(function(){
        $('#container').css('opacity','0.2');
        if(confirm("Do you want to delete?"))
        {
            this.click;
            alert("Ok");
            $('#container').css('opacity','1');
        }
        else
        {
            $('#container').css('opacity','1');
            return false;
        }
        var id_photo = $(this).attr('name');
        var getId   =   id_photo.replace(':','_');
        $.ajax({
            url   :   '/content/photo/deletePhoto',
            type  :   'POST',
            data  :   {id_photo : getId},
            cache :    false
        });
        $('#' +getId).fadeOut(1000);
    });
    /*$('.bac').click(function(){
       $('.showImage').show();
        $('#fade').show();
        var id= $(this).attr('id');

    });
    $('.close').click(function(){
        $('.showImage').hide();
        $('#fade').hide();
    });*/
});
$(function() {
    $(".uploadAlbum").click(function() {
        $('#lightBox').show();
        $('#fade').show();
    });
    $("#closeLightBox").click(function() {
        $('#lightBox').hide();
        $('#fade').hide();
    })
    $(".uploadPhoto").click(function() {
        $('#lightUpload').show();
        $('#fade').show();
    });
    $("#icon-menu").click(function(){
        $('#lightUpload').hide();
        $('#fade').hide();
    }) ;
});
/*$(function(){
   $('#photos_albums').live('click',function(){
       alert('click');
       $.ajax({
           type:"POST",
           url:"/photo/myAlbum",
           cache:false

       }) ;
   });
});*/


$(function() {
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
    /*$('.pt-album-wrapper').click(function(){

        var idAlbum = $(this).children('#idAlbum').val();
        $.ajax({
           type:'POST',
           url:'/photo/viewAlbum',
           data:{id:idAlbum},
           cache:false,
           success: function(html){
               $(".album-wrapper").prepend(html);
               $(".photos_albums").hide();
               $(".uploadPhoto").show();
               $(".album-wrapper").show();
               $(".photo-entry").slideDown(4000);//chinh hieu ugn cho dep

           }

        });
    }) ;*/

    $('.closeMsgErrorAlbum').live('click', function() {
        $('.msgCheckAlbum').hide();
        $(".titleAlbum").css('border', '1px solid #799456');
    });

});

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
// handle next and previous click

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
        //$(".dtDescription").html(photos[photoIndex].description);

    });

    // prev
    $("#previous-photo").live("click", function(){
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
        current = $(".photo-selected");

        previous = current.prev(".photo-unselected");

        if (previous.length == 0)
        {
            previous = $("#images-container .photo-unselected").last();
        }

        previous.attr("class", "photo-selected");
        current.attr("class", "photo-unselected");

        //$(".dtDescription").html(photos[photoIndex].description);
    });


});

// simple jQuery plugin for preload image
(function($) {
    $.fn.preload = function(images) {

        for (var i = 0; i < images.length; i++)
        {
            // DOM for faster creating img tag
            var image = document.createElement('img');
            image.className = "photo-unselected";
            image.src = images[i];

            //$(image).css("display", "none");
            this.append(image);
        }
    }
})( jQuery );

/*

(function($) {
    $("photo-comment-button").live("click", function() {
        console.log("click");
    })
})(jQuery);
*/



$(function () {
    $('.viewMoreComments').click(function(){
        //@todo: set show more comment same fb to later
        //ex: 120 cm, show 4 cm, hide 116. click vo show 20cm hide 100cm, click lan 2 show 70 hide 50, click lan 3 show all
    });
});

function getNextPhotoIndex(currentIndex, countPhotos)
{
    return ((currentIndex + 1) % countPhotos);
}

function getPreviousPhotoIndex(currentIndex, countPhotos)
{
    return ((currentIndex - 1 + countPhotos) % countPhotos);
}

$(function () {
    $('.saveDescription').live('click', function() {
        var containerDiv    = $('.descriptionVP');
        var getDescription  = $('.contentDescription').val();
        var getPhotoID      = $('#getPhotoID').val();
        $.ajax({
            type: 'POST',
            url:  '/content/photo/addDescription',
            data: $('#descriptionPhoto').serialize(),
            cache: false
        });
        $('.BoxDescription').fadeOut();
        $('.dtDescription').css('display', 'none');
        $('<span id="checkAppendTo" class="'+getPhotoID+'">'+getDescription+'</span>').appendTo(containerDiv);
        return false;
    });
});

$(function () {
    /*album_id = $("#album_id").val();
    $('#fileuploadphoto').fileupload({
        dataType: 'json',
        formData: {album_id: album_id}*/
        /*progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        },
        add: function (e, data) {
            data.context = $('<p/>').text('Uploading...').appendTo(document.body);
            data.submit();
        },
        done: function (e, data) {
            data.context.text('Upload finished.');
        }*/
        /*add: function (e, data) {
            data.context = $('<button/>').text('Upload')
                .appendTo(document.body)
                .click(function () {
                    data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                    data.submit();
                });
        },
        done: function (e, data) {
            data.context.text('Upload finished.');
        }*/
    /*});//@todo refest lai moi hien thi duoc hinh*/
});

$(document).ready(function() {
    $('.album').hover(function(){
    });
    //add photoID to html
    addPhotoIDToHTML();
    $('.BoxDescription').hide();
    currentPhotoID      = photos[photoIndex].recordID.replace(':','_');
    $("." + currentPhotoID).css("display", "block");

    var getNumberComments = $("." + currentPhotoID).size();
    if(getNumberComments) {
        var numCommentHide = getNumberComments - 4;
        $("." + currentPhotoID+":lt("+numCommentHide+")").hide();
    }

    $(".description-" + currentPhotoID).css("display", "block");
    nextPhotoIDIndex    = getNextPhotoIndex(photoIndex, countPhotos);
    nextPhotoID         = photos[nextPhotoIDIndex].recordID.replace(':','_');
    //$("." + nextPhotoID).css("display", "none");
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
        urls.shift();
        $("#images-container").preload(urls);
    }
});