/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 10:59 AM
 * Project: joinShare Network - Version: 1.0
 */
$(function(){
    $(".moreActivity").click(function(e)
    {
        e.preventDefault();
        var published = $(".swTimeStatus:last").attr("title");
        $.ajax({
            type: "POST",
            url: "/morePostHome",
            data: "published=" + published,
            cache: false,
            success: function(html){
                $("#swStreamStories").append(html);
                loadStatusFollowBtn();
                /*var theNewScript = document.createElement("script");
                theNewScript.type = "text/javascript";
                theNewScript.src = "http://userwired.local/apps/webroot/js/joinShare/follow.js";
                document.getElementsByTagName("head")[0].appendChild(theNewScript);
// jQuery MAY OR MAY NOT be loaded at this stage
                var waitForLoad = function () {
                    if (typeof jQuery != "undefined") {
                        //$.get("myfile.php");
                    } else {
                        window.setTimeout(waitForLoad, 1000);
                    }
                };
                window.setTimeout(waitForLoad, 1000);*/
            }
        });
    });
});

function loadStatusFollowBtn()
{
    var Follow      = 'Follow';
    var UnFollow    = 'UnFollow';
    var flag        = false;

    $('.follow-button').each(function()
    {
        console.log($(this).attr('name'));
        var getStatusFollow = $(this).attr('name').replace('getStatus-', '');
        $(this).data("state", {pressed: false});
        if (getStatusFollow == 'following')
        {
            $(this).html(UnFollow);
            $(this).data("state", {pressed: true});
        }
        if (getStatusFollow == 'null')
        {
            $(this).html(Follow);
            $(this).data("state", {pressed: false});
        }

        $(this).live('click', function()
        {
            var getID = $(this).attr('id').replace('followID-', '');
            if ($(this).data("state").pressed)
            {
                $(this).html(Follow);
                $.ajax({
                    type: 'POST',
                    url: '/unFollow',
                    data: $('#FollowID-'+getID).serialize(),
                    cache: false
                });
                $(this).data("state", {pressed: false});
                //return false;
            }else {
                $(this).html(UnFollow);
                $.ajax({
                    type: 'POST',
                    url: '/sentFollowing',
                    data: $('#FollowID-'+getID).serialize(),
                    cache: false
                });
                $(this).data("state", {pressed: true});
            }
        });
    })
}