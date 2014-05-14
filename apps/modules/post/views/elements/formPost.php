<?php
$rand = rand(100, 100000);
?>
<script>
    function isValidURL(url){
        var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

        if(RegExp.test(url))
        {
            return true;
        }else{
            return false;
        }
    }
    $(document).ready(function () {

        $('#status').mouseleave(function(){
            var embedPhotos = $('.embedElements #embedPhotos > div').length;
            if (embedPhotos > 0)
            {
                $('#embedVideo').css('display', 'none');
            }
            var url, urlString, urlSpace, urlHttp, urlFirst,fullURL;
            var text = $('#status').val();
            text = $('<span>'+text+'</span>').text(); //strip html
            urlHttp = text.indexOf('http');

            if(urlHttp >=0)
            {
                urlString = text.substr(urlHttp);
                urlSpace = urlString.indexOf(" ");
                if(urlSpace >=0){
                    urlFirst = text.substr(urlHttp,urlSpace);
                    if(isValidURL(urlFirst)){
                        fullURL = url = urlFirst;
                        url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
                        url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
                    }
                } else {
                    if(isValidURL(urlString)){
                        fullURL = url = urlString;
                        url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
                        url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand; ?>">$2</a></div>');
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
                    vimeo: { autoplay: false, maxWidth: 200, maxHeight: 200}
                });
            $('#embedVideo').append("<input type='hidden' name='videoURL' value='"+fullURL+"'>") ;

        });

    });

</script>
<div class="ink-tabs top"> <!-- Creates a tabbed view with top nav -->
    <ul class="tabs-nav">
        <li><a href="#item1"><img src="<?php echo IMAGES; ?>status.png"> Status</a></li> <!-- Points to item 1 below -->
        <li><a href="#item2"><img src="<?php echo IMAGES; ?>photo.png"> Photo</a></li> <!-- Points to item 2 below -->
    </ul>
    <div id="item1" class="tabs-content"> <!-- Item 1 -->
        <div class="uiPostArea column-group">
            <div class="uiPostStatusArea">
                <form class="ink-form" id="submitFormStatus">
                    <fieldset>
                        <div class="control-group">
                            <div class="uiBox-PopUp topLeftArrow control">
                                <div id="typeActivity"></div>
                                <div id="typeActivityID" style="display: none"></div>
                                <textarea class="taPostStatus" id="status" name="status" spellcheck="false" placeholder="What's on your mind?"></textarea>
                            </div>
                            <div class="embedElements">
                                <!-- tag Image, Video, Link here -->
                                <input type="hidden" id="embedType" name="embedType" value="">
                                <div id="embedPhotos"></div>
                                <div id="embedVideo"></div>
                            </div>
                            <div id="tagUsers" class="notag">

                            </div>
                        </div>
                        <div class="uiPostOption control-group">
                            <nav class="ink-navigation">
                                <ul class="menu horizontal">
                                    <li>
                                        <input name="album_id" id="albumID" value="none" type="hidden">
                                        <div id="multiFiles">Upload Images</div>
                                    </li>
                                    <li class="lineGapPostOption">|</li>
                                    <li><a href="#" title="Paste a video link"><img src="<?php echo IMAGES; ?>uploadVideoIcon.png"></a></li>
                                    <li class="fixRightFloat"><button class="uiMediumButton ink-button green-button">Post</button></li>
                                </ul>
                            </nav>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div id="item2" class="tabs-content"> <!-- Item 2 -->
        <div class="uiPostArea column-group">
            <div class="uiPostPhotoArea">
                <form class="ink-form">
                    <fieldset>

                        <div class="uiPhotoActionsBox content-center uiBox-PopUp photoBoxArrow">

                            <div class="large-50 borderLineRight">
                                <input name="album_id" id="albumID" value="none" type="hidden">
                                <div id="multiFiles2">Upload Photo</div>
                            </div>
                            <div class="large-50 uiCreateAlbumBox createAlbum">Create Album</div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Other part-->
<script>
$("#submitFormStatus").submit(function() {
    var embedPhotos = $('.embedElements #embedPhotos > div').length;
    var embedVideo  = $('.embedElements #embedVideo > div').length;
    var status      = $("#status").val();
    if (status || embedPhotos)
    {
        if (embedPhotos > 0)
        {
            $('#embedType').attr('value', 'photo');
        }else {
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
                $('#status').val('');
                updateTime();
            }
        });
    }
    return false; // avoid to execute the actual submit of the form.
});
</script>