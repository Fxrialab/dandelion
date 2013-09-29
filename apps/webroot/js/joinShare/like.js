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

            $(this).live('click', function()
            {
                var getID = $(this).attr('id').replace('likeLinkID-', '');
                if ($(this).data("state").pressed)
                {
                    $(this).html(Like);
                    $.ajax({
                        type: 'POST',
                        url: '/unlike',
                        data: $('#likeHiddenID-'+getID).serialize(),
                        cache: false,
                        success: function(){
                            var otherLike = $('#likeSentence-'+getID+' a').length;
                            console.log('otherLike: ', otherLike);
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
                            var likeSentence = $('#likeSentence-'+getID).length;
                            console.log('likeSentence: ', likeSentence);
                            if (likeSentence)
                            {
                                $("<span>You and </span>").prependTo("#likeSentence-"+getID);
                            }else {
                                $("#showComment-"+getID).append("<div class='likeSentenceView' id='likeSentence-"+getID+"'>You like this</div>");
                            }
                        }
                    });
                    $(this).data("state", {pressed: true});
                }
            });
        })
    });
}