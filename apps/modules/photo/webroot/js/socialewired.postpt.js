/*
 * jQuery for profile post page
 * Include: post status js
 */
$(function() {
    $("a.commentBtnphoto").live("click",function(e){
            e.preventDefault();
            var getId = $(this).attr('id').replace('stream-','');
            var Id = getId.replace(':','_');
            $('#commentBoxphoto-'+Id).fadeIn("slow");
            $('#commentTextphoto-'+Id).focus();
        }
    );
});
// post a comment
$(function() {
    $(".swSubmitCommentphoto").live("click", function(e)
    {
        e.preventDefault();
        var getId = $(this).attr('id').replace('submitCommentphoto-','');
        var Id = getId.replace(":","_");
        var comment = $("#commentTextphoto-"+Id).val();
        if(comment=='')
        {
            return false;
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "/content/photo/commentPhoto",
                data: $('#formCommentphoto-'+Id).serialize(),
                cache: false,
                success: function(html){
                    $("#commentBoxphoto-"+Id).before(html);
                    $("#commentTextphoto-"+Id).val('');
                }
            });
        }return false;
    });
});
$(".view-more-comments").live("click", function(e){
    e.preventDefault();
//@todo click view-more-Comment all viewMore display = none
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
        url: "/content/photo/morePhotoComment",
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

// include photo in status
$(function() {
    $("#navMsg").click(function(e)
    {
        e.preventDefault();
        if($('#notifyContainer').hasClass('toggleTargetClosed')){
            $('#notifyContainer').removeClass('toggleTargetClosed');
        }else{
            $('#notifyContainer').addClass('toggleTargetClosed');
            $('#navMsg').removeClass('notifyAction');
            $('#navMsg').addClass('notifyDefault');
        }
        if($('#navMsg').hasClass('notifyDefault')) {
            $('#navMsg').removeClass('notifyDefault');
            $('#navMsg').addClass('notifyAction');
        }
    });
    $("#navRequestFriend").click(function(e){
        e.preventDefault();
        if($('#notifyRequestFriend').hasClass('toggleTargetClosed')) {
            $('#notifyRequestFriend').removeClass('toggleTargetClosed');
        }else {
            $('#notifyRequestFriend').addClass('toggleTargetClosed');
            $('#navRequestFriend').removeClass('requestFriendAction');
            $('#navRequestFriend').addClass('requestFriendDefault');
        }
        if($('#navRequestFriend').hasClass('requestFriendDefault')) {
            $('#navRequestFriend').removeClass('requestFriendDefault');
            $('#navRequestFriend').addClass('requestFriendAction');
        }
    });

});
