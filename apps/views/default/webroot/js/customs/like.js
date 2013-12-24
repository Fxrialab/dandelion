/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/25/13 - 5:01 PM
 * Project: userwired Network - Version: 1.0
 */
function LikeByElement($element)
{
    $(document).ready(function(){
        var Like      = 'Like';
        var UnLike    = 'Unlike';

        $($element).each(function()
        {
            var getLikeStatus   = $(this).attr('name').replace('likeStatus-', '');
            var getPostID       = $(this).attr('id').replace('likeLinkID-', '');
            var existElement    = $('.postItem-'+getPostID+' .whoLikeThisPost').length;
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
            //console.log('asds ',existElement);
            /*if (existElement)
            {
                $('.postItem-'+getPostID).css('display','block');
                $('#commentBox-'+getPostID).css('display','block');
            }else{
                $('.postItem-'+getPostID).css('display','none');
            }*/

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
                        data: $('#likeHiddenID-'+getID).serialize(),
                        cache: false,
                        success: function(){
                            //console.log('ok men');
                            var otherLike = $('#likeSentence-'+getID+' a').length;
                            //console.log('otherLike: ', otherLike);
                            if (otherLike)
                            {
                                $('#likeSentence-'+getID+' span').remove();
                            }else {
                                $('#likeSentence-'+getID).detach();
                            }
                        }
                    });
                    $(this).data("state", {pressed: false});
                }else {
                    $(this).html(UnLike);
                    $.ajax({
                        type: 'POST',
                        url: '/like',
                        data: $('#likeHiddenID-'+getID).serialize(),
                        cache: false,
                        success: function(){
                            $('.postItem-'+getID).fadeIn("slow");
                            var likeSentence = $('#likeSentence-'+getID).length;
                            //console.log('likeSentence: ', likeSentence);
                            if (likeSentence)
                            {
                                $("<span>You and </span>").prependTo("#likeSentence-"+getID);
                            }else {
                                $(".tempLike-"+getID).prepend("<div class='whoLikeThisPost verGapBox likeSentenceView' id='likeSentence-"+getID+"'>"+
                                    "<span><i class='statusCounterIcon-like'></i>You like this</span>"+
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