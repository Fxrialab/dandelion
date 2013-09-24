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
                new FollowByElement('.followMoreStatus');
            }
        });
    });
});