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
                    //new IsActionsForSuggest();
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
//hide search result if click anywhere
$(document).click(function() {
    var existedSearch = $('#resultsHolder').length;
    if (existedSearch) {
        $('#resultsHolder').hide();
    }
});

$(document).ready(function() {
    $('.taPostStatus').autosize();
    $('#resultsHolder').click(function(e) {
        e.stopPropagation();
    });
    $('body').on('click', '.uiLike', function() {
        var data = $(this).attr('data-like');
        var url = $(this).attr('data-rel');
        $(this).like(data, url);
    });

    $('body').on('click', '.shareStatus', function() {
        var objectID = $(this).attr('id');
        $(this).share(objectID);
    });
    $('body').on('click', '.deleteAction', function() {
        var objectID = $(this).attr('id');
        $(this).deleteEntry(objectID);
    });
    $('body').on('click', '.viewAllComments', function() {
        var objectID = $(this).attr('id');
        $(this).moreComment(objectID);
    });
    $('body').on('click', '.addFriend', function() {
        var objectID = $(this).attr('id');
        $(this).addFriend(objectID);
    });
    $('body').on('click', '.cancelRequestFriend', function() {
        var objectID = $(this).attr('id');
        $(this).unAccept(objectID);
    });
    $('body').on('click', '.confirmFriend', function() {
        var objectID = $(this).attr('id');
        $(this).acceptFriend(objectID);
    });
    jQuery.fn.center = function() {
        this.css("position", "absolute");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
        return this;
    };
});

(function($) {
    $.fn.like = function(data, url)
    {
        $.ajax({
            type: "POST",
            url: "/" + url,
            data: {data: data},
            cache: false,
            success: function(result) {
                var obj = jQuery.parseJSON(result);
                if (obj) {
                    $('a.like_' + obj.id).attr('data-rel', function() {
                        return obj.liked;
                    });
                    $('a.like_' + obj.id).html(obj.title);

                    if (obj.type == 'status') {
                        $('.l1_' + obj.id).html(obj.count);
                        if (obj.count == 1) {
                            $(".tempLike-" + obj.id).prepend("<div class='whoLikeThisPost verGapBox likeSentenceView' id='likeSentence-" + obj.id + "'>" +
                                    "<span><i class='statusCounterIcon-like'></i>You like this</span>" +
                                    "</div>");

                        } else if ((obj.count > 1)) {
                            $("<span>You and </span>").prependTo("#likeSentence-" + obj.id);
                        } else {
                            $("#likeSentence-" + obj.id).remove()
                        }
                    } else {
                        $('.l2_' + obj.id).html(obj.count);
                    }

                }
            }
        });
    };

    $.fn.share = function(objectID)
    {
        $('#fade').show();
        $('.uiShare').show();
        $('.uiShare').enter();
        $('.notificationShare').center();
        $.ajax({
            async: true,
            type: 'POST',
            beforeSend: function() {
                $('.uiShare').addClass('loading');
            },
            complete: function(request, json) {
                $('.uiShare').removeClass('loading');
                $('.uiShare').html(request.responseText);
            },
            url: '/content/post/shareStatus',
            data: {statusID: objectID}
        });
    };
    $.fn.deleteEntry = function(objectID)
    {
        $.ajax({
            type: 'POST',
            url: '/content/post/delete',
            data: {objectID: objectID},
            success: function() {
                $('.postItem-' + objectID).fadeOut('slow');
            }
        });
    }
})(jQuery);

(function($) {
    $.fn.addFriend = function(to)
    {
        $.ajax({
            type: 'POST',
            url: '/sentFriendRequest',
            data: {toUser: to},
            cache: false,
            success: function(html) {
                $('.uiActionUser').html(html);
            }
        });
    };
    $.fn.acceptFriend = function(to)
    {
        $.ajax({
            type: 'POST',
            url: '/acceptFriendship',
            data: {toUser: to},
            cache: false,
            success: function(html) {
                $('.uiActionUser').html(html);
            }
        });
    };
    $.fn.unAccept = function(to)
    {
        $.ajax({
            type: 'POST',
            url: '/unAcceptFriendship',
            data: {toUser: to},
            cache: false,
            success: function(html) {
                $('.uiActionUser').html(html);
            }
        });
    };
})(jQuery);

$(document).ready(function()
{
    $('#search').keyup(function()
    {
        var searchText = $(this).val();
        if (searchText != '')
        {
            $.ajax({
                type: "POST",
                url: "/search",
                data: {data: searchText},
                beforeSend: function() {
                    $('#resultsHolder').css('display', 'block');
                    //Lets add a loading image
                    $('#resultsHolder').addClass('loading');
                },
                success: function(data) {
                    $('#resultsHolder').removeClass('loading');
                    //Clear the results list
                    $('#resultsList').empty();
                    if (data.success)
                    {
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
                                        "<a href='/user/" + this.username + "'>" +
                                        "<span>" +
                                        "<img class='imgFindPeople' src='" + this.profilePic + "' width='40' height='40'/>" +
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

(function($) {
    $.fn.moreComment = function(objectID)
    {
        $.ajax({
            type: "POST",
            url: "/content/post/moreComment",
            data: {statusID: objectID},
            cache: false,
            beforeSend: function() {
                $(".loading_" + objectID).html("<div class='loading2'></div>");
            },
            success: function(html) {
                $('#viewComments-' + objectID).remove();
                $('.moreComment-' + objectID).html(html);
                updateTime();
            }
        })
    };
})(jQuery);




$("body").on('click', '#addMember', function(e) {
    e.preventDefault();
    var title = $(this).attr('title');
    var href = $(this).attr('href');
    var groupID = $(this).attr('rel');
    $.ajax({
        type: "POST",
        url: href,
        data: {groupID: groupID},
        success: function(data) {
            $(".dialog").dialog({
                width: "500",
                height: "160",
                position: ['top', 120],
                title: title,
                resizable: false,
                modal: true,
                open: function(event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $(".dialog").html(data);
                }
            });


        }
    });
});

$("body").on('click', '.removeGroup', function(e) {
    e.preventDefault();
    var title = $(this).attr('title');
    var href = $(this).attr('href');
    var userID = $(this).attr('rel');
    var groupID = $("#group_id").val();

    $.ajax({
        type: "POST",
        url: href,
        data: {groupID: groupID, userID: userID},
        success: function(data) {
            $(".dialog").dialog({
                width: "500",
                height: "160",
                position: ['top', 120],
                title: title,
                resizable: false,
                modal: true,
                open: function(event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $('.dialog').html('<div><img src="<?php echo IMAGES ?>/loadingIcon.gif"</div>');
                }
            });
            $(".dialog").html(data);

        }
    });
});
$("body").on('click', '.roleGroup', function(e) {
    e.preventDefault();
    var title = $(this).attr('title');
    var href = $(this).attr('href');
    var userID = $(this).attr('rel');
    var groupID = $("#group_id").val();
    $.ajax({
        type: "POST",
        url: href,
        data: {groupID: groupID, userID: userID},
        success: function(data) {
            $(".dialog").dialog({
                width: "500",
                height: "160",
                position: ['top', 120],
                title: title,
                resizable: false,
                modal: true,
                open: function(event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $('.dialog').html('<div><img src="<?php echo IMAGES ?>/loadingIcon.gif"</div>');
                }
            });
            $(".dialog").html(data);

        }
    });
});

$("body").on('click', '.removeImgUser', function(e) {
    var title = $(this).attr('title');
    var data = [
        {role: $(this).attr('role')},
    ];
    $(".dialog").dialog({
        width: "500",
        height: "160",
        position: ['top', 100],
        title: title,
        resizable: false,
        modal: true,
        open: function(event, ui) {
            $(".ui-dialog-titlebar-close").hide();
            $('body').css('overflow', 'hidden'); //this line does the actual hiding
//            $(".dialog").html(data);
            $("#comfirmTemplate").tmpl(data).appendTo(".dialog");
        }
    });
});


$("body").on('click', '.photoBrowse', function(e) {
    var title = $(this).attr('title');
    var role = $(this).attr('role');
    $.ajax({
        type: "POST",
        data: {role: role},
        url: "/photoBrowser",
        success: function(data) {
            $('body').css('overflow', 'hidden');
            $(".dialog").dialog({
                width: "700",
                height: "400",
                position: ['top', 100],
                title: title,
                resizable: false,
                modal: true,
                open: function(event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $(".dialog").html(data);
                }
            });

        }
    });
});
$("body").on('click', '.closeDialog', function(e) {
    e.preventDefault();
    $(".dialog form").remove();
    $(".dialog").dialog("close");
    $('body').css('overflow', 'scroll'); //this line does the actual hiding
});

$("body").on('click', '.comfirmDialogGroup', function(e) {
    e.preventDefault();
    var groupID = $("#groupID").val();
    $.ajax({
        type: "POST",
        url: "/content/group/remove",
        data: {groupID: groupID},
        success: function() {
            $('.imgCoverGroup').remove();
            $('.rCoverGroup').remove();
            $('.removeImgGroup').remove();
            $(".dialog").dialog("close");
        }
    });
});

$("body").on('click', '.changePhoto_cover', function(e) {
    e.preventDefault();
    var data = $(this).attr('data-rel');
    $.ajax({
        type: "POST",
        url: "/changePhoto",
        data: {data: data},
        success: function(data) {
            $('.displayPhoto').html(data);
            $('.profilePic img').css('display', 'none');
            $('.dropdown').css('display', 'none');
            $('.profilePic .profileInfo').css('display', 'none ');
            $('.name').css('display', 'none');
            $('.actionCover').css('display', 'none');
            $('.timeLineMenuNav div').remove();
            $("#navCoverUserTemplate").tmpl(data).appendTo(".timeLineMenuNav");

        }
    });
    $.pgwModal('close');
});
$("body").on('click', '.changePhoto_avatar', function(e) {
    e.preventDefault();
    var data = $(this).attr('data-rel');
    $.ajax({
        type: "POST",
        url: "/choosePhoto",
        data: {data: data},
        success: function(rs) {
            $('.infoUser').html(rs);
            $('.profileInfo .dropdown').css('display', 'none');
            $('.profilePic .profileInfo').css('display', 'none');
            $(".dialog").dialog("close");
        }
    });
});

$("body").on('click', '.rCoverUser', function(e) {
    e.preventDefault();
    var id = $(this).attr('rel');
    $.ajax({
        type: "POST",
        url: "/reposition",
        data: {id: id},
        success: function(data) {
            $('.imgCover').html(data);
            $('.profilePic img').css('display', 'none');
            $('.profilePic .profileInfo').css('display', 'none');
            $('.name').css('display', 'none');
            $('.actionCover').css('display', 'none');
            $('.timeLineMenuNav div').css('display', 'none');
            $("#navCoverUserTemplate").tmpl(data).appendTo(".timeLineMenuNav");
        }
    });
});
//Remove ajax
$("body").on('click', '.comfirmDialog', function(e) {
    e.preventDefault();
    var role = $('#role').val();
    $.ajax({
        type: "POST",
        data: {role: role},
        url: "/remove",
        success: function(data) {
            var obj = jQuery.parseJSON(data);
            if (obj.role == 'avatar') {
                $('.infoUser').html('<img src="' + obj.url + 'avatarMenDefault.png">');
                $('#removeAvatar').remove();
            } else {
                $('.imgCover').remove();
                $('#removeCover').remove();
                $('.rCoverUser').remove();
            }
            $(".dialog").dialog("close");
        }
    });
});

$("body").on('click', '.cancel', function(e) {
    e.preventDefault();
    var target = $(this).attr('id');
    $.ajax({
        type: "POST",
        url: "/cancel",
        data: {target: target},
        success: function(data) {
            var obj = jQuery.parseJSON(data);
            if (target == 'coverPhoto')
            {
                var user = [
                    {username: obj.username},
                ];
                if (obj.src)
                {
                    $('.displayPhoto .imgCover').html('<div style="width:' + obj.width + 'px; height:' + obj.height + 'px;  position: relative; left: -' + obj.left + 'px; top: -' + obj.top + 'px" > \n\
                    <img src="' + obj.src + '" style="width:100%;"> \n\
                    </div>');
                } else {
                    $('.displayPhoto .imgCover').remove();
                }
                $('.timeLineMenuNav .cancelCover').remove();
                $('.arrow_timeLineMenuNav').show();
                $('.profilePic img').css('display', 'block');
                $('.profilePic .profileInfo').css('display', 'block ');
                $('.dropdown').css('display', '');
                $('.name').css('display', 'block');
                $('.actionCover').css('display', 'block');
                $("#navInfoUserTemplate").tmpl(user).appendTo(".timeLineMenuNav");
            } else if (target == 'profilePic') {
                $('.profilePic').html('<a class="infoUser" href="/user/' + obj.username + '"><img src="' + obj.src + '"></a>')
            }
            return false;

        }
    });

});

$("body").on('click', '.cancelCoverGroup', function(e) {
    e.preventDefault();
    var target = $(this).attr('id');
    var groupID = $('#groupID').attr('value');
    $.ajax({
        type: "POST",
        url: "/content/group/cancelCover",
        data: {target: target, groupID: groupID},
        success: function(data) {
            var obj = jQuery.parseJSON(data);
            if (target == 'coverGroup')
            {
                if (obj.src)
                {
                    $('.displayPhoto .imgCoverGroup').html('<div style="width:' + obj.width + 'px; height:' + obj.height + 'px;  position: relative; left: -' + obj.left + 'px; top: -' + obj.top + 'px" > \n\
                    <img src="' + obj.src + '" style="width:100%;"> \n\
                    </div>');
                } else {
                    $('.displayPhoto .imgCoverGroup').remove();
                }
                $('.actionCover').css('display', 'block');
                $('.actionCoverGroup').css('display', 'none');
            }
            return false;
        }
    });

});

$("body").on('click', '.changePhoto_group', function(e) {
    e.preventDefault();
    $.pgwModal('close');
    var url = $(this).attr('href');
    $.ajax({
        type: "GET",
        url: url,
        success: function(data) {
            $(".displayPhoto").html(data);

            $('.actionCover').css('display', 'none');

        }
    });
});
$("body").on('click', '.rCoverGroup', function(e) {
    e.preventDefault();
    var id = $(this).attr('rel');
    $.ajax({
        type: "POST",
        url: "/content/group/reposition",
        data: {id: id},
        success: function(data) {
            $('.imgCoverGroup').html(data);
            $('.actionCover').css('display', 'none');
        }
    });
});

$(document).ready(function() {
    $("body").on('click', '.deletePhoto', function(e) {
        e.preventDefault();
        var rel = $(this).attr('rel');
        var relID = $(this).attr('relID');
        var r = confirm("Are you sure you want to delete this image?")
        if (r == true)
        {
            $.ajax({
                type: "POST",
                url: "/content/photo/deletePhoto",
                data: {id: relID, name: rel},
                success: function(data) {
                    $("#" + data).remove();
                }
            });
        }
    });
});
/*Comment Function*/
$(document).on('keypress', '.submitComment', function(event) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == '13' && !event.shiftKey)
    {
        var uni = $(this).attr('id').replace('comment_', '');
        var typeID = $("#" + uni).val();
        var comment = $("#comment_" + uni).val();
        var numComment = parseInt($(".c1_" + typeID).html());
        var data = $('#formcm_' + uni).serialize();
        if (data)
        {
            $.ajax({
                type: "POST",
                url: "/commentStatus",
                data: data,
                cache: false,
                success: function(html) {
                    $(".c1_" + typeID).html(numComment + 1);
                    $(".moreComment_" + typeID).append(html);
                    $("#comment_" + uni).val('');
                    updateTime();
                }
            });
            //exit();
        }
    }
    //return false;
});
$(document).on('keypress', '.commentPhoto', function(event) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == '13' && !event.shiftKey)
    {
        var uni = $(this).attr('id').replace('comment_', '');
        var photoID = $("#" + uni).val();
        var comment = $("#comment_" + uni).val();
        if (comment) {
            $.ajax({
                type: "POST",
                url: "/commentPhoto",
                data: $('#formcm_' + uni).serialize(),
                cache: false,
                success: function(data) {
                    $(".viewComment_" + photoID).append(data);
                    $("#comment_" + uni).val('');
                    updateTime();
                }
            });
            //exit();
        } else
            return false;
    }
    //return false;
});

$("body").on('click', '.removeImgGroup', function(e) {
    var title = $(this).attr('title');
    $(".dialog").dialog({
        width: "500",
        height: "160",
        position: ['top', 100],
        title: title,
        resizable: true,
        modal: true,
        open: function(event, ui) {
            $(".ui-dialog-titlebar-close").hide();
            $("#alertTemplate").tmpl().appendTo(".dialog");
        }
    });
});

$("body").on('click', '.popup', function(e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: $(this).attr('title'),
        minWidth: 400,
        maxWidth: 450
    });
});
$("body").on('click', '.popupMax', function(e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: $(this).attr('title'),
        minWidth: 900,
        maxWidth: 1024
    });
});
$("body").on('click', '.popupPhoto', function(e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: '',
        minWidth: 880,
        maxWidth: 1024,
        minHeight: 500
    });
});

$("body").on('click', '.popupMyPhoto', function(e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: $(this).attr('title'),
        minWidth: 800,
        maxWidth: 900
    });
});