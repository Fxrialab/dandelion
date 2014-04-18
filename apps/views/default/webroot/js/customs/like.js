function LikePostByElement($element)
{
    $(document).ready(function() {
        var Like = 'Like';
        var UnLike = 'Unlike';

        $($element).each(function()
        {

            var getLikeStatus = $(this).attr('name').replace('likeStatus-', '');
            var getPostID = $(this).attr('id').replace('likeLinkID-', '');
            var getNumLike = parseInt($("#numLikeValue-" + getPostID).val());
            $(this).data("state", {pressed: false});
            if (getLikeStatus == 'like')
            {
                $(this).html(UnLike);
                $(this).data("state", {pressed: true});
            }
            if (getLikeStatus == 'null')
            {
                $(this).html(Like);
                $(this).data("state", {pressed: false});
            }

            $(this).click(function()
            {
                var getID = $(this).attr('id').replace('likeLinkID-', '');
                console.log('ID: ', getID);
                if ($(this).data("state").pressed)
                {
                    $(this).html(Like);
                    console.log('come here');
                    $.ajax({
                        type: 'POST',
                        url: '/unlike',
                        data: $('#likeHiddenID-' + getID).serialize(),
                        cache: false,
                        success: function() {
                            //console.log('ok men');
                            var otherLike = $('#likeSentence-' + getID + ' a').length;
                            if (getNumLike == 0)
                                $('#numLike-' + getPostID).html(0);
                            else
                                $('#numLike-' + getPostID).html(getNumLike - 1);
                            //console.log('otherLike: ', otherLike);
                            if (otherLike)
                            {
                                $('#likeSentence-' + getID + ' span').remove();
                            } else {
                                $('#likeSentence-' + getID).detach();
                            }
                        }
                    });
                    $(this).data("state", {pressed: false});
                } else {
                    $(this).html(UnLike);
                    $.ajax({
                        type: 'POST',
                        url: '/like',
                        data: $('#likeHiddenID-' + getID).serialize(),
                        cache: false,
                        success: function() {
                            $('.postItem-' + getID).fadeIn("slow");
                            var likeSentence = $('#likeSentence-' + getID).length;
                            $('#numLike-' + getPostID).html(getNumLike + 1);
                            if (likeSentence)
                            {
                                $("<span>You and </span>").prependTo("#likeSentence-" + getID);
                            } else {
                                $(".tempLike-" + getID).prepend("<div class='whoLikeThisPost verGapBox likeSentenceView' id='likeSentence-" + getID + "'>" +
                                        "<span><i class='statusCounterIcon-like'></i>You like this</span>" +
                                        "</div>");
                            }
                        }
                    });
                    $(this).data("state", {pressed: true});
                }
            });
        })
    });
}

function LikePhotoByElement($element)
{
    $($element).each(function() {
        var getLikeStatus = $(this).attr('title');
        $(this).data("state", {pressed: false});
        if (getLikeStatus == 'Like')
        {
            $(this).addClass('photoNavIcon-like');
            $(this).data("state", {pressed: false});
        } else {
            $(this).addClass('photoNavIcon-unlike');
            $(this).data("state", {pressed: true});
        }
        $(this).click(function(e)
        {
            e.preventDefault();
            var getID = $(this).attr('id').replace('likePhoto-', '');

            if ($(this).data("state").pressed)
            {
                $.ajax({
                    type: 'POST',
                    url: '/unlike',
                    data: $('#likeHiddenID-' + getID).serialize(),
                    cache: false,
                    success: function() {
                        var otherLike = $('#likeSentence-' + getID + ' a').length;
                        if (otherLike)
                        {
                            $('#likeSentence-' + getID + ' span').remove();
                        } else {
                            $('#likeSentence-' + getID).detach();
                        }
                    }
                });
                $(this).removeClass('photoNavIcon-unlike');
                $(this).addClass('photoNavIcon-like');
                $(this).data("state", {pressed: false});
            } else {
                $.ajax({
                    type: 'POST',
                    url: '/like',
                    data: $('#likeHiddenID-' + getID).serialize(),
                    cache: false,
                    success: function() {
                        $('.photoItem-' + getID).fadeIn("slow");
                        var likeSentence = $('#likeSentence-' + getID).length;
                        if (likeSentence)
                        {

                            $("<span>You and </span>").prependTo("#likeSentence-" + getID);
                        } else {
                            $(".tempLike-" + getID).prepend("<div class='whoLikeThisPost verGapBox likeSentenceView' id='likeSentence-" + getID + "'>" +
                                    "<span><i class='statusCounterIcon-like'></i>You like this</span>" +
                                    "</div>");
                        }
                    }
                });
                $(this).removeClass('photoNavIcon-like');
                $(this).addClass('photoNavIcon-unlike');
                $(this).data("state", {pressed: true});
            }
        });
    });
}

/*
 // post a comment for photo
 function PostCommentOnPhoto($element)
 {
 $($element).bind('keypress',function(e){
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
 }*/
