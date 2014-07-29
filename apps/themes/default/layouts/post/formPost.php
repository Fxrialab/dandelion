<?php
$rand = rand(100, 100000);
?>
<script>
    function isValidURL(url) {
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if (RegExp.test(url))
    {
    return true;
    } else {
    return false;
    }
    }
    $(document).ready(function() {

    $('#status').mouseleave(function() {
    var embedPhotos = $('.embedElements #embedPhotos > div').length;
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
    url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
    url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
    }
    } else {
    if (isValidURL(urlString)) {
    fullURL = url = urlString;
    url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
    url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm, '$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
    }
    }
    }
    //$('#tagElements').css('display', 'block');
    $('#embedVideo').empty().html(url);
    $(".oembed<?php echo $rand; ?>").oembed(null,
    {
    embedMethod: "append",
    maxWidth: 1024,
    maxHeight: 400,
    vimeo: {autoplay: false, maxWidth: 200, maxHeight: 200}
    });
    $('#embedVideo').append("<input type='hidden' name='videoURL' value='" + fullURL + "'>");

    });

    });

</script>

<div class="ink-tabs top" style="position: relative"> <!-- Creates a tabbed view with top nav -->
    <ul class="tabs-nav">
        <li><a href="#item1"><img src="<?php echo IMAGES; ?>status.png"> Status</a></li> <!-- Points to item 1 below -->
        <li><a href="#item2"><img src="<?php echo IMAGES; ?>photo.png"> Photo</a></li> <!-- Points to item 2 below -->
    </ul>

    <div class="msg" style="position: absolute; top: 0; right: 20px"></div>
    <div id="item1" class="tabs-content"> <!-- Item 1 -->
        <div class="uiPostArea column-group">
            <div class="uiPostStatusArea">
                <form class="ink-form" id="submitFormStatus">
                    <div class="control-group">
                        <div class="uiBox-PopUp topLeftArrow control">
                            <div id="typeActivity"></div>
                            <div id="typeActivityID" style="display: none"></div>
                            <textarea id="status" name="status" spellcheck="false" placeholder="What's on your mind?">

                            </textarea>

                            <div class="embedElements">
                                <!-- tag Image, Video, Link here -->
                                <input type="hidden" id="embedType" name="embedType" value="">
                                <div id="embedPhotos" class="control-group"></div>
                                <div id="embedVideo"></div>
                            </div>
                            <div id="tagUsers" class="notag">

                            </div>
                        </div>
                    </div>
                    <div class="uiPostOption control-group">
                        <nav class="ink-navigation">
                            <ul class="menu horizontal">
                                <li>
                                    <input name="album_id" id="albumID" value="none" type="hidden">
                                    <div id="multiFiles"><i class="icon30-upload"></i></div>
                                </li>
                                <li class="lineGapPostOption">|</li>
                                <li><a href="#" title="Paste a video link"><img src="<?php echo IMAGES; ?>uploadVideoIcon.png"></a></li>
                                <li class="fixRightFloat"><button class="button active">Post</button></li>
                            </ul>
                        </nav>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="item2" class="tabs-content"> <!-- Item 2 -->
        <form id="submitFormPhoto">
            <div class="uiPostArea column-group">
                <div class="uiPostPhotoArea">
                    <div class="content-center uiBox-PopUp photoBoxArrow">
                        <div class="large-50 borderLineRight">
                            <input name="album_id" id="albumID" value="none" type="hidden">
                            <div style="padding: 30px 0;">
                                <div id="multiFiles2">Upload Photo</div>
                            </div>
                        </div>
                        <div class="large-50 uiCreateAlbumBox createAlbum">
                            <div class="dialogAlbum">Create Album</div>
                        </div>
                    </div>
                    <textarea id="statusPhoto" name="status" spellcheck="false" placeholder="Say something about this photo?">

                    </textarea>
                    <!-- tag Image, Video, Link here -->
                    <input type="hidden" name="embedType" value="photo">
                    <input type="hidden" name="type" value="post">
                    <div class="control-group viewUpload">
                        <div class="large-20">
                            <div style="border: 1px solid #ccc; text-align: center; width: 95px; padding: 25px 0; margin-right: 5px;">
                                <div id="multiFiles3">Upload</div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group  postPhoto">
                        <div class="large-90"></div>
                        <div class="large-10">
                            <button class="button">Post</button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</div>
<!--Other part-->
<script>
    $(document).ready(function() {
    $('textarea').autosize();
    $('#statusPhoto').autosize();
    $(".viewUpload").hide();
    $(".postPhoto").hide();
    $("#statusPhoto").hide();
    });
    $("#submitFormStatus").submit(function() {
    var embedPhotos = $('.embedElements #embedPhotos > div').length;
    var embedVideo = $('.embedElements #embedVideo > div').length;
    var status = $("#status").val();
    $(".msg").html("<div class='loadingUpload'></div>");
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
    success: function(html)
    {
    $('#tagElements').css('display', 'none');
    $("#contentContainer").prepend(html);
    $('.photoWrap').remove();
    $('#imgID').val();
    $('#embedPhotos').html('');
    $('#status').val('');
    $(".msg").html("");
    updateTime();
    }
    });
    }
    return false; // avoid to execute the actual submit of the form.
    });
    $("#submitFormPhoto").submit(function() {
    var status = $("#statusPhoto").val();
    $(".msg").html("<div class='loadingUpload'></div>");
    $.ajax({
    type: "POST",
    url: "/content/post/postStatus",
    data: $("#submitFormPhoto").serialize(), // serializes the form's elements.
    success: function(html)
    {
    $("#contentContainer").prepend(html);
    $(".photoBoxArrow").show();
    $(".viewUpload").hide();
    $(".itemImg").remove();
    $(".postPhoto").hide();
    $('#statusPhoto').hide();
    $(".msg").html("");
    updateTime();
    }
    });
    return false; // avoid to execute the actual submit of the form.
    });


</script>
<script id="imgTemplate" type="text/x-jQuery-tmpl">
    <div class="large-50" id="${imgID}" style="position: relative">
    <div style="margin-right:20px;">
    <input type="hidden" name="imgID[]" value="${name},${width},${height}">
    <img src="${url}" style="width:100%">
    <a href="javascript:void(0)" style="position: absolute; top:5px; right:35px" rel="${name}" relID="${imgID}" class="deleteImage"><span class="icon icon56">X</span></a>
    </div>
    </div>
</script>
<script id="imgTemplate2" type="text/x-jQuery-tmpl">
    <div class="large-20 itemImg" id="${imgID}" style="position: relative">
    <div style="margin-right:10px;">
    <input type="hidden" name="imgID[]" value="${name},${width},${height}">
    <img src="${url}" style="width:100%">
    <a href="javascript:void(0)" style="position: absolute; top:5px; right:25px" rel="${name}" relID="${imgID}" class="deleteImage"><span class="icon icon56">X</span></a>
    </div>
    </div>
</script>
<script id="imgTemplate3" type="text/x-jQuery-tmpl">
    <div class="control-group">

    </div>
</script>

