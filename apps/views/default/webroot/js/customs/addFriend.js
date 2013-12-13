$(function() {
    //add friend place profile area
    var AddFriend       = "Add Friend";
    var FriendRequest   = "Friend Request Sent";
    var getStatus       = $('#status_fr').attr('value');
    if(getStatus == 'request') {
        $('.addFriend').html(FriendRequest);
    }else {
        $('.addFriend').html(AddFriend);
        $('body').on("click", '.addFriend', function(){
            $('.addFriend').html(FriendRequest);
            $.ajax({
                type    : 'POST',
                url     : '/sentFriendRequest',
                data    : $('#friendID').serialize(),
                cache   : false
                /*success : function(){
                 alert('Request friend was sent!');
                 }*/
            });
            return false;
        });
    }

    //accept friendship
    $('body').on('click', '#acceptFriend', function(){
        //alert('clicked friend');
        var getPeopleID = $('#PeopleID').attr('value');
        $.ajax({
            type:   'POST',
            url :   '/acceptFriendship',
            data:   $('#RequestOfID-'+getPeopleID).serialize(),
            cache:  false,
            success: function(){
                $('#people-'+getPeopleID).hide('slow');
            }
        });

    });
    //unaccept friendship
    $('body').on('click', '#cancelFriend', function(){
        var getPeopleID = $('#PeopleID').attr('value');
        //alert(getPeopleID);
        $.ajax({
            type:   'POST',
            url :   '/unAcceptFriendship',
            data:   $('#RequestOfID-'+getPeopleID).serialize(),
            cache:  false,
            success: function(){
                $('#people-'+getPeopleID).hide('slow');
            }
        });
    });
});

function IsActionsForSuggest()
{
    $(document).ready(function(){
        var friendRequest = 'Friend request sent';
        //for add friend of people you may know
        $('.addFriendSmallUI').each(function()
        {
            $(this).live('click', function()
            {
                var yourFriendID = $(this).attr('id');
                console.log(yourFriendID);
                $(this).html(friendRequest);
                $.ajax({
                    type    : 'POST',
                    url     : '/sentFriendRequest',
                    data    : {id: yourFriendID},
                    cache   : false,
                    success : function(){
                        $('#unit'+yourFriendID).fadeOut(1000);
                        var length = $(".peopleYouMayKnow .moduleContent > div").length;
                        console.log(length);
                        if (length == 0)
                        {
                            $('.peopleYouMayKnow').hide();
                        }
                    }
                });
            })
        });
        //for confirm friend of friend requests
        $('.confirmFriend').each(function()
        {
            $(this).live('click', function()
            {
                var friendRequestID = $(this).attr('id');
                $.ajax({
                    type:   'POST',
                    url :   '/acceptFriendship',
                    data:   {id: friendRequestID},
                    cache:  false,
                    success: function(){
                        $('#unit'+friendRequestID).fadeOut(1000);
                    }
                });
            })
        })
    });
}