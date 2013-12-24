/*
 * jQuery for profile post page
 * Include: post status js
 */
function ShareStatus(statusID){
    $('#fade').show();
    $('.uiShare').show();
    $('.uiShare').center();
    $('.notificationShare').center();
    $.ajax({
        async: true,
        type: 'POST',
        beforeSend: function(){
            $('.uiShare').addClass('loading');
        },
        complete: function(request, json) {
            $('.uiShare').removeClass('loading');
            $('.uiShare').html(request.responseText);
        },
        url: '/content/post/shareStatus',
        data: {statusID: statusID}
    });
}


// post status
$(function() {
    $("#submitStatus").click(function(e) 
    {
        e.preventDefault();
        var status      = $("#status").val();
        var profileID   = $("#profileID").val();
        var fullURL     = $("#fullURL").html();
        var taggedType  = $("#taggedType").val();
        var URL         = (fullURL == 'undefined') ? 'none' : fullURL;
        if(status=='')
        {
            return false;
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "/content/post/postStatus",
                data: {status:status, profileID:profileID, fullURL:URL, taggedType:taggedType},
                cache: false,
                success: function(html){
                    $('#tagElements').css('display', 'none');
                    $("#contentContainer").prepend(html);
                    $('#status').val('');
                    new LikeByElement('.likePostStatus');
                    new FollowByElement('.followSegments');
                    updateTime();
                }
            });
        }
        return false;
    });

    $("body").on("click", "a.commentBtn",function(e){
            e.preventDefault();
            var getId = $(this).attr('id').replace('stream-','');
            $('.postItem-'+getId).fadeIn("slow");
            $('#commentBox-'+getId).fadeIn("slow");
            $('#textComment-'+getId).focus();
        }
    );


});
// post a comment
$(function() {
    $(".submitComment").bind('keypress',function(e){
        var code = e.keyCode || e.which;
        if(code == 13)
        {
            var statusID= $(this).attr('id').replace('textComment-','');
            var comment = $("#textComment-"+statusID).val();
            console.log('cm: ',comment);
            if (comment == '')
            {
                return false;
            }else {
                var url, urlString, urlSpace, urlHttp, urlFirst,fullURL;
                var text = $('#textComment-'+statusID).val();
                text = $('<span>'+text+'</span>').text(); //strip html
                urlHttp = text.indexOf('http');
                if(urlHttp >=0)
                {
                    urlString = text.substr(urlHttp);
                    urlSpace = urlString.indexOf(" ");
                    if(urlSpace >=0)
                    {
                        urlFirst = text.substr(urlHttp,urlSpace);
                        if(isValidURL(urlFirst))
                        {
                            fullURL = url = urlFirst;
                        }
                    } else {
                        if(isValidURL(urlString))
                        {
                            fullURL = url = urlString;
                        }
                    }
                }
                $('#fmComment-'+statusID).append("<input id='fullURL' name='fullURL' type='hidden' value="+ fullURL+ ">") ;
                $.ajax({
                    type: "POST",
                    url: "/content/post/postComment",
                    data: $('#fmComment-'+statusID).serialize(),
                    cache: false,
                    success: function(html){
                        $("#commentBox-"+statusID).before(html);
                        $("#textComment-"+statusID).val('');
                    }
                });
            }
        }
        //return false;
    });
});

// include video for status
$(function() {
    $(".swTagVideo").click(function(e) 
    {
        e.preventDefault();
        $('.videoLinkContain').fadeIn("slow");
    });
});

$(function() {
    $("#submitVideoLink").click(function(e) 
    {
        e.preventDefault();
        var link =  $('#videoLink').val();
        
        $.ajax({
            type: "POST",
            url: "/post/oembed",
            data: {url: link},
            cache: false,
            success: function(html){                
                $(".oembed").append(html);
            }
        });     
        
        $('.videoLinkContain').css('opacity','0');
        $('#tagElements').removeClass('notag');
        $('#tagElements').addClass('tagged');
        $('#tagElements').append('<input type="hidden" id="taggedElement" name="taggedElement" value='+link+' /><input type="hidden" id="taggedType" name="taggedType" value="video"/><div class="oembed"></div>');
    });
});
// more status, comment
$(function() {
    $("body").on("click", ".whoCommentThisPost", function(e){
    	e.preventDefault();
        var postID = $(this).attr('id');
    	// get first comment published
    	published   = $('.postItem-'+postID+' .commentContentWrapper .eachCommentItem:first .uiCommentContent span .swTimeComment').attr("name");
        console.log('status:', published);
    	$.ajax({
            type: "POST",
            url: "/content/post/morePostComment",
            data: { published:published, statusID:postID},
            cache: false,
            success: function(html){
                $('.whoCommentThisPost').css('display', 'none');
                $('.postItem-'+postID+' .commentContentWrapper').prepend(html);
            }
        });
    });
    //view more comments for photo

});
