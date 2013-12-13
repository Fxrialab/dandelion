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
            var getLikeStatus = $(this).attr('name').replace('likeStatus-', '');
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

            $('body').on('click', $element, function()
            {
                console.log('this', $element);
                var getID = $($element).attr('id').replace('likeLinkID-', '');
                if ($($element).data("state").pressed)
                {
                    $($element).html(Like);
                    console.log('come here');
                    $.ajax({
                        type: 'POST',
                        url: '/unlike',
                        data: $('#likeHiddenID-'+getID).serialize(),
                        cache: false,
                        success: function(){
                            console.log('ok men');
                            var otherLike = $('#likeSentence-'+getID+' a').length;
                            console.log('otherLike: ', otherLike);
                            if (otherLike)
                            {
                                $('#likeSentence-'+getID+' span').remove();
                            }else {
                                $('#likeSentence-'+getID).detach();
                            }
                            $('.postActionWrapper').fadeOut("slow");
                        }
                    });
                    $($element).data("state", {pressed: false});
                }else {
                    $($element).html(UnLike);
                    $.ajax({
                        type: 'POST',
                        url: '/like',
                        data: $('#likeHiddenID-'+getID).serialize(),
                        cache: false,
                        success: function(){
                            $('.postActionWrapper').fadeIn("slow");
                            var likeSentence = $('#likeSentence-'+getID).length;
                            console.log('likeSentence: ', likeSentence);
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
                    $($element).data("state", {pressed: true});
                }
            });
        })
    });
}