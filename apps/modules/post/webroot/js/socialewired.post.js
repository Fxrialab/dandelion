/*
 * jQuery for profile post page
 * Include: post status js
 */
function ShareStatus(statusID) {
    $('#fade').show();
    $('.uiShare').show();
    $('.uiShare').center();
    $('.notificationShare').center();
    $.ajax({
        async: true,
        type: 'POST',
        beforeSend: function() {
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
        var status = $("#status").val();
        var profileID = $("#profileID").val();
        var fullURL = $("#fullURL").html();
        var taggedType = $("#taggedType").val();
        var URL = (fullURL == 'undefined') ? 'none' : fullURL;
            var imgID = $("#imgID").val();
        if (status == '')
        {
            return false;
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "/content/post/postStatus",
                data: {status: status, profileID: profileID, fullURL: URL, taggedType: taggedType, img:imgID},
                cache: false,
                success: function(html) {
                    $('#tagElements').css('display', 'none');
                    $("#contentContainer").prepend(html);
                    $('.photoItem').remove();
                    $('#imgID').val();
                    $('#status').val('');
                    new LikePostByElement('.likePostStatus');
                    new FollowByElement('.followSegments');
                    updateTime();
                }
            });
        }
        return false;
    });

    $("body").on("click", "a.commentBtn", function(e) {
        e.preventDefault();
        var getId = $(this).attr('id').replace('stream-', '');
        $('.postItem-' + getId).fadeIn("slow");
        $('#commentBox-' + getId).fadeIn("slow");
        $('#textComment-' + getId).focus();
    }
    );


});
// post a comment


// more status, comment
//$(function() {
//    $("body").on("click", ".whoCommentThisPost", function(e) {
//        e.preventDefault();
//        var postID = $(this).attr('id');
//        // get first comment published
//        published = $('.postItem-' + postID + ' .commentContentWrapper .eachCommentItem:first .uiCommentContent span .swTimeComment').attr("name");
//        console.log('status:', published);
//        $.ajax({
//            type: "POST",
//            url: "/content/post/morePostComment",
//            data: {published: published, statusID: postID},
//            cache: false,
//            success: function(html) {
//                $('#'+postID).css('display', 'none');
//                $('.postItem-' + postID + ' .commentContentWrapper').prepend(html);
//              
//            }
//         
//        });
//    });
//    //view more comments for photo
//
//});
