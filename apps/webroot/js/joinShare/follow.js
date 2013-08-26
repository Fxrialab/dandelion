$(document).ready(function()
{
    var getURL = $('#getURL').attr('value');
    var Plus = '<img src = "'+getURL+'post/webroot/images/swbtnFollow.png" />'; // Twitter bird image
    var Follow = "Follow";         // Text for the the three button states
    var Following = "Following";
    var Unfollow = "Unfollow";

    var Default = Plus + ' ' + Follow; // Default text combines the bird image and the text "Follow"

    // Disable text selection over follow buttons (using jquery-ui... this command is NOT a part of the plain jquery lib.)
    //$('.follow-button').disableSelection();

    // The jQuery's .text() method allows us to enter text into the tag confines. E.g.: <a class = "follow-button">HERE</a>
    // The jQuery's .html() method is the same as .text(), but it also allows embedding the HTML code inside a tag.
    // Take all follow buttons and embed the default value "Follow" into them using jQuery.

    $(".follow-button").html(Default);

    $(".follow-button").each(function()
    {

        $(this).data("state", {pressed: false});
        var getStatusFollow = $(this).attr('name').replace('getStatus-', '');
        // In the case of a 2-state button,
        // actual button commands are executed on mouse up (not mouse down, which will not be used at all)
        if (getStatusFollow == 'following') {
            $(this).data("state", {pressed: true});
            $(this).addClass("Pressed");
            $(this).html(Plus + ' ' + Following);
        }

        $(this).live('click', function()
        {
            // Toggle the button state
            //alert(getStatusFollow);
            if ($(this).data("state").pressed)
            {
                var getIDUnfollow = $(this).attr('id').replace('followID-', '');
                $(this).data("state", {pressed: false});
                $(this).removeClass("Pressed");
                $(this).removeClass("Unfollow"); // remove red background, we are no longer pressed
                $(this).html(Default); // reset back to default text
                $.ajax({
                    url     : "/unFollow",
                    type    : "POST",
                    data    : $('#FollowID-'+getIDUnfollow).serialize(),
                    cache   : false
                });
                return false;
            }
            else
            {
                var getIDFollowing = $(this).attr('id').replace('followID-', '');
                $(this).data("state", {pressed: true});
                $(this).addClass("Pressed");
                $(this).html(Plus + ' ' + Following);
                $.ajax({
                    url    : "/sentFollowing",
                    type   : "POST",
                    data   : $('#FollowID-'+getIDFollowing).serialize(),
                    cache  : false
                });
                return false;

            }
        });

        $(this).mouseover(function()
        {
            // Hovering when the button is pressed will briefly display "Unfollow" over the button
            if ($(this).data("state").pressed)
            {
                $(this).addClass("Hover").addClass("Unfollow");
                $(this).html(Plus + ' ' + Unfollow);
            }
            else
            {
                // But hovering on an unpressed button creates a subtle "hover" effect, but doesn't change the button's text
                $(this).addClass("Hover");
            }
        });

        $(this).mouseout(function()
        {
            $(this).removeClass("Hover");
            // When the mouse leaves the pressed button
            if ($(this).data("state").pressed)
            {
                $(this).removeClass("Unfollow"); // remove red background
                $(this).html(Plus + ' ' + Following); // replace "Unfollow" message with "Following"
            }
        });


    });


});

