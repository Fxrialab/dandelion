$(function() {
        //add friend place profile area
        var AddFriend       = "Add Friend";
        var FriendRequest   = "Friend Request";
        var getStatus       = $('#status_fr').attr('value');
        if(getStatus == 'request') {
            $('.addFriend').html(FriendRequest);
        }else {
            $('.addFriend').html(AddFriend);
            $('.addFriend').live("click", function(){
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
    //add friend place people you may known area
    var addfriend       = 'add friend';
    var requestfriend   = 'request friend';
    var getID           = $('.addMoreFriend').attr('id');
    /*If add code graphic relationship
    var getStatusFr     = $('.statusFriendship').attr('value');
    if(getStatusFr == 'null' || getStatusFr == 'friend') {
            $('#'+getID).hide();
    }else {*/
        $('.addMoreFriend').html(addfriend);
        $('.addMoreFriend').live("click", function() {
           $('.addMoreFriend').html(requestfriend);
            $.ajax({
                type:   'POST',
                url :   '/sentFriendRequest',
                data:   $('#friendID-'+getID).serialize(),
                cache: false
            });
            return false;
        });
    //}
    //accept friendship
    $('#acceptFriend').live('click', function(){
        alert('clicked friend');
        var getPeopleID = $('#PeopleID').attr('value');
        //alert(getPeopleID);
        $.ajax({
            type:   'POST',
            url :   '/acceptFriendship',
            data:   $('#RequestOfID-'+getPeopleID).serialize(),
            cache:  false
        });
        $('#people-'+getPeopleID).hide('slow');
    });
    //unaccept friendship
    $('#cancelFriend').live('click', function(){
        var getPeopleID = $('#PeopleID').attr('value');
        //alert(getPeopleID);
        $.ajax({
            type:   'POST',
            url :   '/unAcceptFriendship',
            data:   $('#RequestOfID-'+getPeopleID).serialize(),
            cache:  false
        });
        $('#people-'+getPeopleID).hide('slow');
    });
});
