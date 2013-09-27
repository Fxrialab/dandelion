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
                            console.log(this);
                        }
                    });
                    $(this).data("state", {pressed: true});
                }
            });
        })
    });
}