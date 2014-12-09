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
    $(document).ready(function () {

        $('#status').mouseleave(function () {
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
<div style="border: 1px #dee0e3 solid; background-color: white;  border-radius: 3px;">
    <nav class="ink-navigation">
        <ul class="menu horizontal" style="font-weight: bold">
            <li><a href="javascript:void(0)"  onclick="return tab('status');"><i class="fa fa-pencil-square fa-18"></i> Update Status</a></li>
            <li><a href="javascript:void(0)" onclick="return tab('media');"><i class="fa fa-picture-o fa-18"></i> Add Photos/Video</a></li>
        </ul>
    </nav>
    <div class="status" style=" margin: 0">
        <div class="uiPostArea column-group">
            <div class="uiPostStatusArea">
                <form class="ink-form" id="submitFormStatus">
                    <div class="uiPostContent control-group">
                        <div class="control">
                            <div id="typeActivity"></div>
                            <div id="typeActivityID" style="display: none"></div>
                            <textarea id="status" name="status" spellcheck="false" placeholder="What's on your mind?"></textarea>
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
                    <div class="uiPostOption control-group" style="display: none">
                        <nav class="ink-navigation">
                            <ul class="menu horizontal">
                                <li><span><i class="fa fa-user fa-18"></i></span></li>
                                <li><span><i class="fa fa-map-marker fa-18"></i></span></li>
                                <li><span id="multiFiles"><i class="fa fa-camera fa-18"></i></span> </li>
                                <li><span><i class="fa fa-meh-o fa-18"></i></span></li>
                                <li class="fixRightFloat"><button class="button active">Post</button></li>
                            </ul>
                        </nav>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="media" style="display: none">
        <div class="uiPostArea column-group">
            <div class="uiPostPhotoArea">
                <div class="content-center">
                    <div class="large-50 uiUploadPhotoBox borderLineRight">
                        <input name="album_id" id="albumID" value="none" type="hidden">
                        <div id="multiFiles2">Upload Photos</div>
                    </div>
                    <div class="large-50 uiCreateAlbumBox createAlbum">
                        <div class="dialogAlbum">Create Photo Album</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Other part-->
<script>
    function tab(id) {
        if (id == 'status') {
            $('.media').hide();
            $('.status').show();
        } else {
            $('.status').hide();
            $('.media').show();
        }

    }
    $(document).ready(function () {
        $('textarea').autosize();
        $('#statusPhoto').autosize();
        $(".viewUpload").hide();
        $(".postPhoto").hide();
        $("#statusPhoto").hide();
    });

</script>


