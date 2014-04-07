/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(".autoloadModuleElement").ready(function()
{
    $.ajax({
        type: "GET",
        url: "/pull",
        cache: false,
        success: function(html) {
            $(".autoloadModuleElement").html(html);
            var lengthChild = $('.autoloadModuleElement > div').length;
            var actionArrays = [];
            var action;
            for (var i = 1; i <= lengthChild; i++)
            {
                action = $('.autoloadModuleElement > div:nth-child(' + i + ')').attr('class');
                actionArrays.push(action);
            }
            //console.log(actionArrays);
            $.ajax({
                type: "POST",
                url: "/loadSuggest",
                data: {actionsName: actionArrays},
                cache: false,
                success: function(html) {
                    $(".autoloadModuleElement").html(html);
                    new IsActionsForSuggest();
                    var existFriendRequests = $('.uiBoxFriendRequests .rowItemBox').length;
                    if (existFriendRequests < 1)
                        $('.uiBoxFriendRequests').hide();
                    var existPeopleYMK = $('.uiBoxPeopleYouMayKnow .rowItemBox').length;
                    if (existPeopleYMK < 1)
                        $('.uiBoxPeopleYouMayKnow').hide();

                }
            })
        }
    })
});


$(document).ready(function() {
    $('.taPostStatus').autosize();
    $('.taPostComment').autosize();
    //target show popUp
//            new showPopUpOver('a.postOption', '.uiPostOptionPopUpOver');
    new showPopUpOver('a.settingOption', '.uiSettingOptionPopUpOver');
    new showPopUpOver('a.quickPostStatusNav', '.uiQuickPostStatusPopUpOver');
    new showPopUpOver('a.showRequestFriends', '.uiFriendRequestsPopUpOver');
    new showPopUpOver('a.showMessages', '.uiMessagesPopUpOver');
    new showPopUpOver('a.showNotifications', '.uiNotificationsPopUpOver');
    $(document).click(function() {
        $('.uiPostOptionPopUpOver').hide();
        $('.uiSettingOptionPopUpOver').hide();
        $('.uiFriendRequestsPopUpOver').hide();
        $('.uiMessagesPopUpOver').hide();
        $('.uiNotificationsPopUpOver').hide();
        var existSearchPopUp = $('#resultsList li').length;
        if (existSearchPopUp > 0)
        {
            $('#resultsList').css('display', 'none');
        } else {
            $('#resultsList').css('display', 'block');
        }
    });
    $('.cancelPostStatusNavBtn').click(function() {
        $('.uiQuickPostStatusPopUpOver').hide();
        return false;
    });

    $('#resultsHolder').click(function(e) {
        e.stopPropagation();
    });
    /*$('.uiBoxPostContainer').each(function(){
     var invisible = $('.postActionWrapper > div').length;
     console.log('count: ',invisible);
     if (invisible > 0)
     {
     $('.uiStreamCommentBox').hide();
     }
     });*/

});

//layout photo like pinterest
$(window).load(function() {
    $('.uiPhotoPinCol').BlocksIt({
        numOfCol: 3,
        offsetX: -5,
        offsetY: 5
    });
});

function showPopUpOver($click, $popUpOver) {
    $($click).click(function() {
        $($popUpOver).show();
        return false;
    });
}

function FollowByElement($element)
{
    $(document).ready(function() {
        var Follow = 'Follow';
        var UnFollow = 'Unfollow';

        $($element).each(function()
        {
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

            $(this).click(function()
            {
                var getID = $(this).attr('id').replace('followID-', '');
                if ($(this).data("state").pressed)
                {
                    $(this).html(Follow);
                    $.ajax({
                        type: 'POST',
                        url: '/unFollow',
                        data: $('#fmFollow-' + getID).serialize(),
                        cache: false,
                        success: function() {

                        }
                    });
                    $(this).data("state", {pressed: false});
                } else {
                    $(this).html(UnFollow);
                    $.ajax({
                        type: 'POST',
                        url: '/follow',
                        data: $('#fmFollow-' + getID).serialize(),
                        cache: false,
                        success: function() {
                            console.log(this);
                        }
                    });
                    $(this).data("state", {pressed: true});
                }
            });
        })
    });
}
$(function() {
    //add friend place profile area
    var AddFriend = "Add Friend";
    var FriendRequest = "Friend Request Sent";
    var getStatus = $('#status_fr').attr('value');
    if (getStatus == 'request') {
        $('.addFriend').html(FriendRequest);
    } else {
        $('.addFriend').html(AddFriend);
        $('body').on("click", '.addFriend', function() {
            $('.addFriend').html(FriendRequest);
            $.ajax({
                type: 'POST',
                url: '/sentFriendRequest',
                data: $('#friendID').serialize(),
                cache: false
                        /*success : function(){
                         alert('Request friend was sent!');
                         }*/
            });
            return false;
        });
    }

    //accept friendship
    $('body').on('click', '#acceptFriend', function() {
        //alert('clicked friend');
        var getPeopleID = $('#PeopleID').attr('value');
        $.ajax({
            type: 'POST',
            url: '/acceptFriendship',
            data: $('#RequestOfID-' + getPeopleID).serialize(),
            cache: false,
            success: function() {
                $('#people-' + getPeopleID).hide('slow');
            }
        });

    });
    //unaccept friendship
    $('body').on('click', '#cancelFriend', function() {
        var getPeopleID = $('#PeopleID').attr('value');
        //alert(getPeopleID);
        $.ajax({
            type: 'POST',
            url: '/unAcceptFriendship',
            data: $('#RequestOfID-' + getPeopleID).serialize(),
            cache: false,
            success: function() {
                $('#people-' + getPeopleID).hide('slow');
            }
        });
    });
});

function IsActionsForSuggest()
{
    $(document).ready(function() {
        var friendRequest = 'Friend request sent';
        //for add friend of people you may know
        $('.uiAddFriend').each(function()
        {
            $('body').on('click', '.uiAddFriend', function(e)
            {
                e.preventDefault();
                var yourFriendID = $('.uiAddFriend').attr('id');
                console.log(yourFriendID);
                $(this).html(friendRequest);
                $.ajax({
                    type: 'POST',
                    url: '/sentFriendRequest',
                    data: {id: yourFriendID},
                    cache: false,
                    success: function() {
                        $('#unit' + yourFriendID).fadeOut(1000);
                        var existPeopleYMK = $('.uiBoxPeopleYouMayKnow .rowItemBox').length;
                        if (existPeopleYMK < 1)
                            $('.uiBoxPeopleYouMayKnow').hide();
                    }
                });
            })
        });
        //for confirm friend of friend requests
        $('.confirmFriend').each(function()
        {
            $('body').on('click', '.confirmFriend', function(e)
            {
                e.preventDefault();
                var friendRequestID = $('.confirmFriend').attr('id');
                $.ajax({
                    type: 'POST',
                    url: '/acceptFriendship',
                    data: {id: friendRequestID},
                    cache: false,
                    success: function() {
                        $('#unit' + friendRequestID).fadeOut(1000);
                        var existFriendRequests = $('.uiBoxFriendRequests .rowItemBox').length;
                        if (existFriendRequests < 1)
                            $('.uiBoxFriendRequests').hide();
                    }
                });
            })
        })
    });
}

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
                            //console.log('likeSentence: ', likeSentence);
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

$(document).ready(function()
{
    $('#search').keyup(function()
    {
        var searchText = $(this).val();
        //console.log('searchText:',searchText);
        if (searchText != '')
        {
            $.ajax({
                type: "POST",
                url: "/search",
                data: {data: searchText},
                beforeSend: function() {
                    //Lets add a loading image
                    $('#resultsHolder').addClass('loading');
                },
                success: function(data) {
                    $('#resultsHolder').removeClass('loading');
                    //Clear the results list
                    $('#resultsList').empty();
                    if (data.success)
                    {
                        console.log(data);
                        //Display the results
                        if (data.results.length > 0)
                        {
                            //check if return to result is larger, just display 8 results
                            if (data.results.length > 9)
                            {
                                for (var i = 0; i < data.results.length - 9; i++)
                                {
                                    data.results.pop();
                                }
                            }
                            //Loop through each result and add it to the list
                            $.each(data.results, function()
                            {
                                $('#resultsList').append("<li rel='" + this.recordID + "'>" +
                                        "<a href='/content/myPost?username=" + this.username + "'>" +
                                        "<span>" +
                                        "<img class='imgFindPeople' src='" + this.profilePic + "' width='30' height='30'/>" +
                                        "<span class='infoPeople'>" + this.firstName + " " + this.lastName + "</span>" +
                                        "</span>" +
                                        "</a>" +
                                        "</li>");
                            });
                            $('#resultsList').append("<li class='moreSearch'><a href='/moreSearch?search=" + searchText + "'><span class='moreSearchText'>See more results for '" + searchText + "'</span></a></li>");
                        } else {
                            $('#resultsList').append("<li class='no-results'>" + data.error + "</li>");
                        }
                    } else {
                        //Display the error message
                        $('#resultsList').append("<li class='no-results'>" + data.error + "</li>");
                    }
                    $('#resultsList').fadeIn();
                }
            })
        } else {
            $('#resultsList').empty();
        }
    });
});
function moreComment(id) {
    $.ajax({
        type: "POST",
        url: "/content/post/moreComment",
        data: {statusID: id},
        cache: false,
        success: function(html) {
            $('#' + id).css('display', 'none');
            $('.moreComment-' + id).html(html);

        }
    })
}
/**
 * l
 */
function like(statusID, actor) {
    $.ajax({
        type: "POST",
        url: "/like",
        data: {statusID: statusID, actor: actor},
        cache: false,
        success: function(html) {
//            var obj = jQuery.parseJSON(data);
            $('.like-' + statusID).html(html);
//            $('#numLike-' + statusID).html(obj);
        }
    })
}
function unlike(statusID, actor) {
    $.ajax({
        type: "POST",
        url: "/unlike",
        data: {statusID: statusID, actor: actor},
        cache: false,
        success: function(data) {
             var obj = jQuery.parseJSON(data);
            $('.like-' + statusID).html('<a href="javascript:void(0)" onclick="like(' + statusID + ', ' + actor + ')">Like</a>');
            $('#numLike-' + statusID).html(obj);

        }
    })
}
//$(document).ready(function() {
//    $(".oembed5").oembed(null,
//            {
//                embedMethod: "append",
//                maxWidth: 1024,
//                maxHeight: 768,
//                autoplay: false
//            });
//    $(window).scroll(function() {
//        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
//            $('.uiMoreView').show();
//            var published = $(".uiBoxPostItem:last .uiBoxPostContainer .uiPostContent .articleSelectOption").find('.swTimeStatus').attr("name");
//            var existNoMoreActivity = $('.noMoreActivity').length;
//            if (existNoMoreActivity < 1)
//            {
//                $.ajax({
//                    type: "POST",
//                    url: "/morePostHome",
//                    data: {published: published},
//                    cache: false,
//                    success: function(html) {
//                        $("#contentContainer").append(html);
//                        $('.uiMoreView').hide();
//                    }
//                });
//            } else {
//                $('.uiMoreView').hide();
//            }
//        }
//    });
//});

