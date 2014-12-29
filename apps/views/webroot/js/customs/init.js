$(document).ready(function () {
    $('textarea').autosize();
    $('#statusPhoto').autosize();
    $(".viewUpload").hide();
    $(".postPhoto").hide();
    $("#statusPhoto").hide();
});

function tab(id) {
    if (id == 'status') {
        $('.media').hide();
        $('.status').show();
    } else {
        $('.status').hide();
        $('.media').show();
    }

}

function isValidURL(url) {
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if (RegExp.test(url))
    {
        return true;
    } else {
        return false;
    }
}
$(document).ready(function () {

    $('#status').mouseleave(function () {
        var embedPhotos = $('.embedElements #embedPhotos > div').length;
        var rand = $('#rand').attr('value');
        if (embedPhotos > 0)
        {
            $('#embedVideo').css('display', 'none');
        }
        var url, urlString, urlSpace, urlHttp, urlFirst, fullURL;
        var text = $('#status').val();
        text = $('<span>' + text + '</span>').text(); //strip html
        urlHttp = text.indexOf('http');

        if (urlHttp >= 0)
        {
            urlString = text.substr(urlHttp);
            urlSpace = urlString.indexOf(" ");
            if (urlSpace >= 0) {
                urlFirst = text.substr(urlHttp, urlSpace);
                if (isValidURL(urlFirst)) {
                    fullURL = url = urlFirst;
                    url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed' + rand + '">$2</a></div>');
                    url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed' + rand + '">$2</a></div>');
                }
            } else {
                if (isValidURL(urlString)) {
                    fullURL = url = urlString;
                    url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed' + rand + '">$2</a></div>');
                    url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed' + rand + '">$2</a></div>');
                }
            }
        }
        //$('#tagElements').css('display', 'block');
        $('#embedVideo').empty().html(url);
        $(".oembed" + rand).oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 400,
                    vimeo: {autoplay: false, maxWidth: 200, maxHeight: 200}
                });
        $('#embedVideo').append("<input type='hidden' name='videoURL' value='" + fullURL + "'>");

    });

});

$('body').on('click', '.friendRequests', function () {
    if ($('#dropdown-friend').css('display') == 'none')
    {
        $.ajax({
            type: "GET",
            url: "/loadFriendRequests",
            data: {},
            cache: false,
            beforeSend: function () {
                $('.friendRqContainers').html('<li><div class="loading-bar"><div></div></div></li>');
            },
            success: function (html) {
                $("span.countFriendRequest").css('display', 'none');
                $('.friendRqContainers li').detach();
                $('.friendRqContainers').append(html);
                updateTime();
            }
        });
    }
});


$(".autoloadModuleElement").ready(function ()
{
    $.ajax({
        type: "GET",
        url: "/pull",
        cache: false,
        success: function (html) {
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
                success: function (html) {
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

$('body').on('click', '#status', function () {
    $('.uiPostOption').show();
});
//hide search result if click anywhere
$(document).click(function () {
    var existedSearch = $('#resultsHolder').length;
    if (existedSearch) {
        $('#resultsHolder').hide();
    }
});

$(document).ready(function () {
    $('.taPostStatus').autosize();
    $('#resultsHolder').click(function (e) {
        e.stopPropagation();
    });
    $('body').on('click', '.uiLike', function () {
        var data = $(this).attr('data-like');
        var url = $(this).attr('data-rel');
        $(this).like(data, url);
    });

    $('body').on('click', '.shareStatus', function () {
        var objectID = $(this).attr('id');
        $(this).share(objectID);
    });
    $('body').on('click', '.deleteAction', function () {
        var objectID = $(this).attr('id');
        $(this).deleteEntry(objectID);
    });
    $('body').on('click', '.pagerLink', function () {
        var objectID = $(this).attr('id');
        $(this).moreComment(objectID);
    });
    $('body').on('click', '.addFriend', function () {
        var objectID = $(this).attr('id');
        $(this).addFriend(objectID);
    });
    $('body').on('click', '.cancelRequestFriend', function () {
        var objectID = $(this).attr('id');
        $(this).unAccept(objectID);
    });
    $('body').on('click', '.confirmFriend', function () {
        var objectID = $(this).attr('id');
        $(this).acceptFriend(objectID);
    });
    jQuery.fn.center = function () {
        this.css("position", "absolute");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
        return this;
    };
});

(function ($) {
    $.fn.like = function (data, url)
    {
        $.ajax({
            type: "POST",
            url: "/" + url,
            data: {data: data},
            cache: false,
            success: function (result) {
                var obj = jQuery.parseJSON(result);
                if (obj) {
                    $('a.like_' + obj.id).attr('data-rel', function () {
                        return obj.liked;
                    });
                    $('a.like_' + obj.id).html(obj.title);

                    if (obj.type == 'status' || obj.type == 'photo') {
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
                        if (obj.liked == 'unlike') {
                            var i = '<i class="fa fa-hand-o-right fa-14"></i> ';
                        } else
                        {
                            var i = '';
                        }
                        $('.l2_' + obj.id).html(i + obj.count);
                    }

                }
            }
        });
    };

    $.fn.share = function (objectID)
    {
        $('#fade').show();
        $('.uiShare').show();
        $('.uiShare').enter();
        $('.notificationShare').center();
        $.ajax({
            async: true,
            type: 'POST',
            beforeSend: function () {
                $('.uiShare').addClass('loading');
            },
            complete: function (request, json) {
                $('.uiShare').removeClass('loading');
                $('.uiShare').html(request.responseText);
            },
            url: '/content/post/shareStatus',
            data: {statusID: objectID}
        });
    };
    $.fn.deleteEntry = function (objectID)
    {
        $.ajax({
            type: 'POST',
            url: '/content/post/delete',
            data: {objectID: objectID},
            success: function () {
                $('.postItem-' + objectID).fadeOut('slow');
            }
        });
    }
})(jQuery);

(function ($) {
    $.fn.addFriend = function (to)
    {
        $.ajax({
            type: 'POST',
            url: '/sentFriendRequest',
            data: {toUser: to},
            cache: false,
            success: function (html) {
                $('.uiActionUser').html(html);
            }
        });
    };
    $.fn.acceptFriend = function (to)
    {
        $.ajax({
            type: 'POST',
            url: '/acceptFriendship',
            data: {toUser: to},
            cache: false,
            success: function (html) {
                $('.uiActionUser').html(html);
            }
        });
    };
    $.fn.unAccept = function (to)
    {
        $.ajax({
            type: 'POST',
            url: '/unAcceptFriendship',
            data: {toUser: to},
            cache: false,
            success: function (html) {
                $('.uiActionUser').html(html);
            }
        });
    };
})(jQuery);

$(document).ready(function ()
{
    $('#search').keyup(function ()
    {
        var searchText = $(this).val();
        if (searchText != '')
        {
            $.ajax({
                type: "POST",
                url: "/search",
                data: {data: searchText},
                beforeSend: function () {
                    $('#resultsHolder').css('display', 'block');
                    //Lets add a loading image
                    $('#resultsHolder').addClass('loading');
                },
                success: function (data) {
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
                            $.each(data.results, function ()
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

(function ($) {
    $.fn.moreComment = function (objectID)
    {
        $.ajax({
            type: "POST",
            url: "/moreComment",
            data: {statusID: objectID},
            cache: false,
            beforeSend: function () {
                $("#viewComments-" + objectID + ' a.pagerLink').append(' <i class="fa fa-circle-o-notch fa-spin"></i>');
            },
            success: function (html) {
                $('#viewComments-' + objectID).remove();
                $('.moreComment_' + objectID).html(html);
                updateTime();
            }
        })
    };
})(jQuery);





$("body").on('click', '.photoBrowse', function (e) {
    var title = $(this).attr('title');
    var role = $(this).attr('role');
    $.ajax({
        type: "POST",
        data: {role: role},
        url: "/photoBrowser",
        success: function (data) {
            $('body').css('overflow', 'hidden');
            $(".dialog").dialog({
                width: "700",
                height: "400",
                position: ['top', 100],
                title: title,
                resizable: false,
                modal: true,
                open: function (event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $(".dialog").html(data);
                }
            });

        }
    });
});


$("body").on('click', '.changePhoto_cover', function (e) {
    e.preventDefault();
    var data = $(this).attr('data-rel');
    $.ajax({
        type: "POST",
        url: "/changePhoto",
        data: {data: data},
        success: function (data) {
            $('.arrow_timeLineMenuNav').hide();
            $('.profilePic img').css('display', 'none');
            $('.dropdown').css('display', 'none');
            $('.profilePic .profileInfo').css('display', 'none ');
            $('.name').css('display', 'none');
            $('.actionCover').css('display', 'none');
            $('.timeLineMenuNav div').remove();
            $("#navCoverUserTemplate").tmpl(data).appendTo(".timeLineMenuNav");
            $('.displayPhoto').html(data);

        }
    });
    $.pgwModal('close');
});
$("body").on('click', '.changePhoto_avatar', function (e) {
    e.preventDefault();
    var data = $(this).attr('data-rel');
    $.ajax({
        type: "POST",
        url: "/changePhoto",
        data: {data: data},
        success: function (rs) {
            $('.profilePic').html(rs);
            $('#imgAvatar .profileInfo').css('display', 'none');
        }
    });
});


$("body").on('click', '.cancel', function (e) {
    e.preventDefault();
    var target = $(this).attr('id');
    $.ajax({
        type: "POST",
        url: "/cancel",
        data: {target: target},
        success: function (data) {
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


$(document).ready(function () {
    $("body").on('click', '.deletePhoto', function (e) {
        e.preventDefault();
        var rel = $(this).attr('rel');
        var r = confirm("Are you sure you want to delete this image?")
        if (r == true)
        {
            $.ajax({
                type: "POST",
                url: "/content/photo/deletePhoto",
                data: {data: rel},
                success: function (data) {
                    $("." + data).remove();
                }
            });
        }
    });
});
/*Comment Function*/
$(document).on('keypress', '.submitComment', function (event) {
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
                success: function (html) {
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
$(document).on('keypress', '.commentPhoto', function (event) {
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
                success: function (data) {
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

$(document).on('click', '.shareBtn', function (e)
{
    e.preventDefault();
    var statusID = $(this).attr('id').replace('shareStatus-', '');
    //var txt = $('#contentShare-'+statusID).val();
    $.ajax({
        type: "POST",
        url: "/content/post/insertStatus",
        data: $('#fmShareStatus-' + statusID).serialize(),
        cache: false,
        success: function () {
            $('.uiShare').hide();
            $('.notificationShare').show();
            setTimeout(function () {
                $('.notificationShare').hide();
                $('#fade').hide();
            }, 3000);
        }
    });
});


$(document).on('submit', '#submitFormStatus', function (event) {
    var embedPhotos = $('.embedElements #embedPhotos > div').length;
    var embedVideo = $('.embedElements #embedVideo > div').length;
    var status = $("#status").val();
    $(".uiPostOption nav ul").append("<li style='float:right; padding-top: 7px; padding-right: 10px' class='loadStatus'><i class='fa fa-spinner fa-spin fa-18'></i></li>");
    if (status || embedPhotos)
    {
        if (embedPhotos > 0)
        {
            $('#embedType').attr('value', 'photo');
        } else {
            if (embedVideo > 0)
                $('#embedType').attr('value', 'video');
            else
                $('#embedType').attr('value', 'none');
        }
        $.ajax({
            type: "POST",
            url: "/content/post/postStatus",
            data: $("#submitFormStatus").serialize(), // serializes the form's elements.
            success: function (html)
            {
                $('#tagElements').css('display', 'none');
                $("#contentContainer").prepend(html);
                $('.photoWrap').remove();
                $('#imgID').val();
                $('#embedPhotos').html('');
                $('#status').val('');
                $(".uiPostOption nav ul li.loadStatus").remove();
                updateTime();
            }
        });
    }
    return false; // avoid to execute the actual submit of the form.
});

$("body").on('submit', '#submitAvatar', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/savePhoto",
        data: $("#submitAvatar").serialize(), // serializes the form's elements.
        success: function (data)
        {
            if (data) {
                var obj = jQuery.parseJSON(data);
                $('.infoUser').html(' <img src="' + obj.avatar + '">');
                $('.green-button').remove();
                $('.actionAvatar').remove();
                $('#imgAvatar .profileInfo').css('display', 'block');
            } else {
                $('.infoUser').html('Error...');
            }

        }
    });

    return false; // avoid to execute the actual submit of the form.
});

$("body").on('submit', '#submitCover', function (e) {

    $.ajax({
        type: "POST",
        url: "/savePhoto",
        data: $("#submitCover").serialize(), // serializes the form's elements.
        success: function (data)
        {
            var obj = jQuery.parseJSON(data);
            var user = [
                {username: obj.username}
            ];
            $("#navInfoUserTemplate").tmpl(user).appendTo(".timeLineMenuNav");
            $('.arrow_timeLineMenuNav').show();
            $('.profilePic a img').css('display', 'block');
            $('.profilePic .profileInfo').css('display', 'block ');
            $('.dropdown').css('display', '');
            $('.name').css('display', 'block');
            $('.actionCover').css('display', 'block');
            $('.cancelCover').remove();
            $('.dragCover').css('cursor', 'pointer');
        }
    });

    return false; // avoid to execute the actual submit of the form.
});

$("body").on('click', '.deletePhotoStatus', function (e) {
    var title = $(this).attr('title');
    $(".dialog").dialog({
        width: "500",
        height: "160",
        position: ['top', 100],
        title: title,
        resizable: true,
        modal: true,
        open: function (event, ui) {
            $(".ui-dialog-titlebar-close").hide();
            $("#alertTemplate").tmpl().appendTo(".dialog");
        }
    });
});

$("body").on('click', '.popup', function (e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: $(this).attr('title'),
        minWidth: 400,
        maxWidth: 450
    });
});
$("body").on('click', '.popupMax', function (e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: $(this).attr('title'),
        minWidth: 900,
        maxWidth: 1024
    });
});
$("body").on('click', '.popupPhoto', function (e) {
    e.preventDefault();
    var location = window.location.href;
    $('#location-href').attr('value', function () {
        return location;
    });
    if (history.pushState)
        history.pushState('', "", $(this).attr('href') + '&type=1');
    $.pgwModal({
        url: $(this).attr('href'),
        titleBar: false,
        minWidth: 880,
        maxWidth: 1024,
        minHeight: 500,
        ajaxOptions: {
            success: function (data) {
                if (data) {
                    $.pgwModal({pushContent: data});
                } else {
                    $.pgwModal({pushContent: 'An error has occured'});
                }
            }
        }
    });
});

$("body").on('click', '.popupMyPhoto', function (e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: $(this).attr('title'),
        minWidth: 800,
        maxWidth: 900
    });
});

$("body").on('click', '.carousel', function (e) {
    e.preventDefault();
    if (history.pushState)
        history.pushState('', "", $(this).attr('href') + '&type=1');
    $.ajax({
        type: "GET",
        url: $(this).attr('href'),
        success: function (data)
        {
            $('.pm-content').html(data);
        }
    });
});

$("body").on('click', '.share_action_link', function (e) {
    e.preventDefault();
    $.pgwModal({
        url: $(this).attr('href'),
        title: $(this).attr('title'),
        minWidth: 450,
        maxWidth: 450
    });
});

$("body").on('click', '.pgwclose', function (e) {
    e.preventDefault();
    var url = $('#location-href').attr('value');
    if (history.pushState)
        history.pushState('', "", url);
    $.pgwModal('close');
});