(function($) {
    //set body width for IE8
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
        var ieversion = new Number(RegExp.$1)
        if (ieversion == 8) {
            $('body').css('max-width', $(window).width());
        }
    }

    var $masonry = $('#masonry');
    $('#navigation').css({'visibility': 'hidden', 'height': '1px'});
    $masonry.masonry({
        itemSelector: '.post',
        isFitWidth: true
    }).css('visibility', 'visible');

    $('#ajax-loader-masonry').hide();
})(jQuery);

jQuery(document).ready(function($) {
    var $masonry = $('#masonry');

    $masonry.infinitescroll({
        navSelector: '#navigation',
        nextSelector: '#navigation #navigation-next a',
        itemSelector: '.post',
        loading: {
            msgText: '',
            finishedMsg: 'All items loaded',
            img: '',
            finished: function() {
            },
        },
    }, function(newElements) {
        var $newElems = $(newElements).css({opacity: 0});

        if ($(document).width() <= 480) {
            $newElems.imagesLoaded(function() {
                $('#infscr-loading').fadeOut('normal');
                $newElems.animate({opacity: 1});
                $masonry.masonry('appended', $newElems, true);
            });
        } else {
            $('#infscr-loading').fadeOut('normal');
            $newElems.animate({opacity: 1});
            $masonry.masonry('appended', $newElems, true);
        }
    });
});

jQuery(document).ready(function($) {
    var $scrolltotop = $("#scrolltotop");
    $scrolltotop.css('display', 'none');

    $(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $scrolltotop.slideDown('fast');
            } else {
                $scrolltotop.slideUp('fast');
            }
        });

        $scrolltotop.click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 'fast');
            return false;
        });
    });
});
$("body").on('click', '.postModal', function(e) {
    e.preventDefault();
    $.pgwModal({
        url: 'modalUpload',
        title: 'Upload',
        maxWidth: 600
    });
});
$("body").on('click', '.postImage', function(e) {
    var typeID = $(this).attr('rel');
    e.preventDefault();
    $.pgwModal({
        url: 'content/post/postModal?id=' + typeID,
        maxWidth: 1000,
        close: false,
    });
});
$("body").on('click', '.pin', function(e) {
    var id = $(this).attr('relPin');
    e.preventDefault();
    $.pgwModal({
        url: 'content/post/pin?id=' + id,
        title: 'Pin',
        maxWidth: 600,
        close: false,
    });
});
$("body").on('click', '.changePassword', function(e) {
    e.preventDefault();
    $.pgwModal({
        url: 'changePassword',
        title: 'Change Password'
    });
});
$("body").on('click', '.forgotPassword', function(e) {
    e.preventDefault();
    $.pgwModal({
        url: 'forgot',
        title: 'Forgot Password'
    });
});
$("body").on('click', '.deletePost', function(e) {
    e.preventDefault();
    var objectID = $(this).attr('rel');
    $.ajax({
        type: 'POST',
        url: '/content/post/delete',
        data: {objectID: objectID},
        success: function(data) {
            $('post_' + objectID).remove();
            $('#masonry').masonry({
                itemSelector: '.post',
                isFitWidth: true
            }).css('visibility', 'visible');
        }
    });
});

$("body").on('keypress', '.submitComment', function(event) {
    var code = (event.keyCode ? event.keyCode : event.which);
    if (code == '13' && !event.shiftKey)
    {
        var statusID = $(this).attr('id').replace('textComment-', '');
        var comment = $("#textComment-" + statusID).val();
//                    var numComment = parseInt($("#numCommentValue-" + statusID).val());
        if (comment == '')
        {
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "/content/post/postComment",
                data: $('#fmComment-' + statusID).serialize(),
                cache: false,
                success: function(html) {
                    $(".post-comment_" + statusID).append(html);
                    $("#textComment-" + statusID).val('');
                    $('#masonry').masonry({
                        itemSelector: '.post',
                        isFitWidth: true
                    }).css('visibility', 'visible');
                    $('#ajax-loader-masonry').hide();
                    updateTime();
                }
            });
            //exit();
        }
    }
    //return false;
});


$(document).ready(function() {
    $('body').on('click', '.likeAction', function() {
        var objectID = $(this).attr('id');
        var type = $(this).attr('rel');
        $(this).like(type, objectID);
    });
    $('body').on('click', '.unlikeAction', function() {
        var objectID = $(this).attr('id');
        var type = $(this).attr('rel');
        $(this).unlike(type, objectID);
    });
});

(function($) {
    $.fn.like = function(type, objectID)
    {
        if (type == 'photoDialog' || type == 'photo') {
            var recordID = 'photo';
        } else {
            var recordID = 'status';
        }

        $.ajax({
            type: "POST",
            url: "/like",
            data: {type: recordID, objectID: objectID},
            cache: false,
            success: function(html) {
                if (type == 'status' || type == 'photoDialog') {
                    var getNumLike = parseInt($("#numLike-" + objectID).html());
                    $('.like-' + objectID).html(html);
                    $('.postItem-' + objectID).fadeIn("slow");
                    var likeSentence = $('#likeSentence-' + objectID).length;
                    $('#numLike-' + objectID).html(getNumLike + 1);
                    if (likeSentence)
                    {
                        $("<span>You and </span>").prependTo("#likeSentence-" + objectID);
                    } else {
                        $(".tempLike-" + objectID).prepend("<div class='whoLikeThisPost verGapBox likeSentenceView' id='likeSentence-" + objectID + "'>" +
                                "<span><i class='statusCounterIcon-like'></i>You like this</span>" +
                                "</div>");
                    }
                } else {
                    var getNumLike = parseInt($(".numLike-" + objectID).html());
                    $('.like_' + objectID).html(html);
                    $('.numLike-' + objectID).html(getNumLike + 1);
                }

            }
        });
    };
    $.fn.unlike = function(type, objectID)
    {
        if ((type == 'photoDialog') || (type == 'photo')) {
            var recordID = 'photo';
        } else {
            var recordID = 'status';
        }
        $.ajax({
            type: "POST",
            url: "/unlike",
            data: {type: recordID, objectID: objectID},
            cache: false,
            success: function(html) {
                if (type == 'status' || type == 'photoDialog') {
                    var getNumLike = parseInt($("#numLike-" + objectID).html());
                    $('.like-' + objectID).html(html);
                    $('#numLike-' + objectID).html(getNumLike - 1);
                    $('.postItem-' + objectID).fadeIn("slow");
                    var otherLike = $('#likeSentence-' + objectID + ' a').length;
                    if (otherLike)
                    {
                        $('#likeSentence-' + objectID + ' span').remove();
                    } else {
                        $('#likeSentence-' + objectID).detach();
                    }
                }
                else {
                    var getNumLike = parseInt($(".numLike-" + objectID).html());
                    $('.like_' + objectID).html(html);
                    $('.numLike-' + objectID).html(getNumLike - 1);
                }
            }
        });
    };

})(jQuery);

$("body").on('click', '#createGroup', function(e) {
    var href = $(this).attr('href');
    e.preventDefault();
    $.pgwModal({
        url: href,
        title: 'Create Board'
    });
});
