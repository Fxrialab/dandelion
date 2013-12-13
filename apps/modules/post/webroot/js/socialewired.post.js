/*
 * jQuery for profile post page
 * Include: post status js
 */

/*function ShareStatus(status_id){
    $('#shareStatus').dialog();
    $.ajax({
        async: true,
        type: 'post',
        complete: function(request, json) {
            $('#shareStatus').html(request.responseText);
        },
        url: '/content/post/shareStatus',
        data: {status_id: status_id}
    });
}*/
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
                }
            });
        }
        return false;
    });

    $("body").on("click", "a.commentBtn",function(e){
            e.preventDefault();
            var getId = $(this).attr('id').replace('stream-','');
            var Id = getId.replace(':','_');
            $('.postActionWrapper').fadeIn("slow");
            $('#commentBox-'+Id).fadeIn("slow");
            $('#commentText-'+Id).focus();

        }
    );


});
// post a comment
$(function() {
    $("body").on("click", ".swSubmitComment", function(e)
    {
        e.preventDefault();
        var getId = $(this).attr('id').replace('submitComment-','');
        var Id = getId.replace(":","_");
        var comment = $("#commentText-"+Id).val();
        if(comment=='')
        {
            return false;
        }
        else
        {
            var url, urlString, urlSpace, urlHttp, urlFirst,fullURL;
            var text = $('#commentText-'+getId).val();
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
            $('#formComment-'+getId).append("<input id='fullURL' name='fullURL' style='display: none' value="+ fullURL+ ">") ;

            $.ajax({
                type: "POST",
                url: "/content/post/postComment",
                data: $('#formComment-'+Id).serialize(),
                cache: false,
                success: function(html){
                    $("#commentBox-"+Id).before(html);
                    $("#commentText-"+Id).val('');
                }
            });
        }
        return false;
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
    $(".morePost").click(function(e) 
    {
        e.preventDefault();
        var published = $(".swTimeStatus:last").attr("name");
        $.ajax({
            type: "POST",
            url: "/content/post/morePostStatus",
            data: "published=" + published,
            cache: false,
            success: function(html){
                $("#contentContainer").append(html);
                new LikeByElement('.likeMorePostStatus');
                new FollowByElement('.followMorePostStatus');
            }
        });
    });

    $("body").on("click", ".view-more-comments", function(e){
    	e.preventDefault();

    	// get first comment published
    	published   = $(e.target.parentElement).children(".swCommentPosted:first").find(".swTimeComment").attr("title");
    	statusID    = e.target.id;
        nameClass   = $('#'+statusID).attr('class');
        numberComment = $('.hiddenSpan').html();
        numberCommentElement = ('#showComment-'+statusID+" swCommentPosted").size;
        console.log("numberComment: ", numberComment);
        console.log("numberCommentElement: ", numberCommentElement);
    	$.ajax({
            type: "POST",
            url: "/content/post/morePostComment",
            data: { published:published, statusID:statusID, nameClass:nameClass},
            cache: false,
            success: function(html){
            	//console.log(e.target.parentElement);
                $('.view-more-comments').css('display', 'none');
               //e.target.parentElement.prepend(html);
               $(e.target).after(html);
            }
        });
    });
    //view more comments for photo

});
