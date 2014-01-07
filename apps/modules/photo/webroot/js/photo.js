$(function() {
    $(".createAlbum").click(function() {
        $('.uiCreateAlbum').show();
        $('.uiCreateAlbum').center();
        $('.taDescriptionAlbum').autosize();
        $('#fade').show();
    });
    $(".closeLightBox").click(function() {
        $('.uiCreateAlbum').hide();
        $('#fade').hide();
    });
    $(".uploadPhoto").click(function() {
        //console.log('clicked upload btn');
        $('.uiLightUpload').show();
        $('.uiLightUpload').center();
        $('#fade').show();
    });
});

$(document).ready(function()
{
    var settingSingleFile = {
        url: "/content/photo/loadingPhoto",
        method: "POST",
        allowedTypes:"jpg,png,gif",
        fileName: "myfile",
        multiple: false,
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
                    "<textarea rows='4' id='someThingAboutPhoto-"+ this.photoID +"' spellcheck='false' placeholder='Write something about this photo'></textarea>" +
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
    var settingMultiFiles = {
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
                    "<textarea rows='4' id='someThingAboutPhoto-"+ this.photoID +"' spellcheck='false' placeholder='Write something about this photo'></textarea>" +
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
    $("#singleFile").uploadFile(settingSingleFile);
    $("#multiFiles").uploadFile(settingMultiFiles);
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
            $('.uiLightUpload').hide();
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
        //
        var existedMsgAlbum = $('#msgValidateAlbum').length;
        if (existedMsgAlbum > 0)
            $('#msgValidateAlbum').detach();

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
            $('#uiCreateAlbum').hide();
            $('#fade').hide();
            return false;
        }else {
            $('.uiAlbumAlerts').append("<div class='ink-alert basic info' id='msgValidateAlbum'>" +
                "<button class='ink-dismiss'>&times;</button>" +
                "<p>You must fill name for album</p></div>");
            return false;
        }
    });
    $('body').on('click', '.closeMsgErrorAlbum', function() {
        $('.msgCheckAlbum').hide();
        $(".titleAlbum").css('border', '1px solid #799456');
    });
});

$(function() {
    $('body').on("click", ".nextBtn", function(e)
    {
        e.preventDefault();
        //before click next
        currentPhotoID = photos[photoIndex].recordID.replace(':','_');
        $("." + currentPhotoID).css("display", "none");
        $("#" + currentPhotoID).css("display", "none");
        //after click next
        photoIndex = getNextPhotoIndex(photoIndex, countPhotos);
        photoID = photos[photoIndex].recordID.replace(':','_');
        $("." + photoID).css("display", "block");
        $("#" + photoID).css("display", "block");

        console.log('currentPhotoID',currentPhotoID);
        console.log('prevPhotoID',photoID);

        //add photoID
        //addPhotoIDToHTML();
        //config photo selected after click next btn
        current = $(".photo-selected");
        next = current.next(".photo-unselected");
        if (next.length == 0)
        {
            next = $(".containerPhoto .photo-unselected").first();
        }
        next.attr("class", "photo-selected");
        current.attr("class", "photo-unselected");
        //config view content photo after click next btn
        currentContentPhoto = $(".visiblePhotoWrap");
        nextContentPhoto = currentContentPhoto.next(".invisiblePhotoWrap");
        if (nextContentPhoto.length == 0)
        {
            nextContentPhoto = $(".rightColPopUp .invisiblePhotoWrap").first();
        }
        nextContentPhoto.attr("class", "visiblePhotoWrap");
        currentContentPhoto.attr("class", "invisiblePhotoWrap");
        $('#uiPhotoView').center();
    });

    // prev
    $('body').on("click", ".previousBtn", function(e)
    {
        e.preventDefault();
        //before click prev
        currentPhotoID = photos[photoIndex].recordID.replace(':','_');
        $("." + currentPhotoID).css("display", "none");
        $("#" + currentPhotoID).css("display", "none");
        //after click prev
        photoIndex = getPreviousPhotoIndex(photoIndex, countPhotos);
        photoID = photos[photoIndex].recordID.replace(':','_');
        $("." + photoID).css("display", "block");
        $("#" + photoID).css("display", "block");
        console.log('currentPhotoID',currentPhotoID);
        console.log('prevPhotoID',photoID);
        //add photoID
        //addPhotoIDToHTML();
        //config photo selected after click previous btn
        current = $(".photo-selected");
        previous = current.prev(".photo-unselected");
        if (previous.length == 0)
        {
            previous = $(".containerPhoto .photo-unselected").last();
        }
        previous.attr("class", "photo-selected");
        current.attr("class", "photo-unselected");
        //config view content photo after click previous btn
        currentContentPhoto = $(".visiblePhotoWrap");
        previousContentPhoto = currentContentPhoto.prev(".invisiblePhotoWrap");
        if (previousContentPhoto.length == 0)
        {
            previousContentPhoto = $(".rightColPopUp .invisiblePhotoWrap").last();
        }
        previousContentPhoto.attr("class", "visiblePhotoWrap");
        currentContentPhoto.attr("class", "invisiblePhotoWrap");
        $('#uiPhotoView').center();
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

// post a comment for photo
$(function() {
    $(".postComment").bind('keypress',function(e){
        var code = e.keyCode || e.which;
        if(code == 13)
        {
            var photoID = $(this).attr('id').replace('photoComment-','');
            var comment = $("#photoComment-"+photoID).val();
            if (comment == '')
            {
                return false;
            }else {
                $.ajax({
                    type: "POST",
                    url: "/content/photo/postComment",
                    data: $('#fmPhotoComment-'+photoID).serialize(),
                    cache: false,
                    success: function(html){
                        $("#commentBox-"+photoID).before(html);
                        $("#photoComment-"+photoID).val('');
                        updateTime();
                    }
                });
            }
        }
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
    $("body").on("click", ".whoCommentThisPhoto", function(e){
        e.preventDefault();
        var photoID = $(this).attr('id');
        // get first comment published
        published   = $('.photoItem-'+photoID+' .commentContentWrapper .eachCommentItem:first .uiCommentContent span .swTimeComment').attr("name");
        console.log('status:', published);
        $.ajax({
            type: "POST",
            url: "/content/photo/morePhotoComment",
            data: { published:published, photoID:photoID},
            cache: false,
            success: function(html){
                $('.whoCommentThisPhoto').css('display', 'none');
                $('.photoItem-'+photoID+' .commentContentWrapper').prepend(html);
                updateTime();
            }
        });
    });
    new LikePhotoByElement('.likePhotoSegments');
    //Click to image for view
    $('.viewThisPhoto').each(function(){
        $(this).click(function(e)
        {
            e.preventDefault();
            $('#fadePhoto').show();
            $('#uiPhotoView').show();

            var getID = $(this).attr('id');
            console.log('view photoID: ', getID);
            $.ajax({
                async: true,
                type: 'POST',
                url: '/content/photo/viewPhoto',
                data: {photoID:getID},
                beforeSend: function(){
                    $('#uiPhotoView').addClass('loading');
                },
                complete: function(request){
                    $('#uiPhotoView').removeClass('loading');
                    $('#uiPhotoView').html(request.responseText);
                    new LikePhotoByElement('.likePhotoSegments');
                    updateTime();
                    //$('.photo-selected').centerImg('.leftColPopUp');
                    $('#uiPhotoView').center();
                }
            });
        });
    });
    $('body').on('click', '.uiClosePhotoPopUp', function(){
        $('#fadePhoto').hide();
        $('#uiPhotoView').hide();
    });

    $(document).keyup(function(e){
        var code = e.keyCode || e.which;
        if(code == 27)
        {
            $('#fadePhoto').hide();
            $('#uiPhotoView').hide();
        }
    });

    jQuery.fn.centerImg = function ($parent) {
        this.css("margin-top", Math.max(0, (($($parent).height() - $(this).outerHeight()) / 2)) + "px");
        this.css("margin-left", Math.max(0, (($($parent).width() - $(this).outerWidth()) / 2)) + "px");
        return this;
    }
});

