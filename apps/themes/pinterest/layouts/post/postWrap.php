<?php
$rand = rand(100,100000);
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
            tagdata = [];
            eventdata = [];
            //var scriptruns = [];
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
            $('#tagElements').css('display', 'block');
            $('#tagElements').empty().html(url);
            $(".oembed<?php echo $rand; ?>").oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 400,
                    vimeo: { autoplay: false, maxWidth: 200, maxHeight: 200}
                });
            $('#tagElements').append("<div id='fullURL' style='display: none' >"+ fullURL+ "</div>") ;

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
                <form class="ink-form">
                    <fieldset>
                        <div class="control-group">
                            <div class="uiBox-PopUp topLeftArrow control">
                                <textarea class="taPostStatus" id="status" name="status" spellcheck="false" placeholder="What's on your mind?"></textarea>
                            </div>
                            <div id="tagElements" class="notag">
                                <!-- tag Image, Video, Link here -->
                            </div>
                        </div>
                        <div class="uiPostOption control-group">
                            <nav class="ink-navigation">
                                <ul class="menu horizontal">
                                    <li><a href="#" title="Choose a file to upload"><img src="<?php echo IMAGES; ?>uploadPhotoIcon.png"></a></li>
                                    <li class="lineGapPostOption">|</li>
                                    <li><a href="#" title="Paste a video link"><img src="<?php echo IMAGES; ?>uploadVideoIcon.png"></a></li>
                                    <li class="fixRightFloat"><a id="submitStatus" class="uiMediumButton blue">Post</a></li>
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
                            <div class="large-50 uiUploadPhotoBox uploadPhoto borderLineRight">Upload Photo</div>
                            <div class="large-50 uiCreateAlbumBox createAlbum">Create Album</div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Other part-->
<div id="fade" class="black_overlay"></div>
<div id="fadePhoto" class="black_overlay"></div>
<div class="uiLightUpload uiPopUp">
    <div class="containerPhotoPopUp">
        <div class="actionUpload">
            <input name="album_id" id="albumID" value="none" type="hidden">
            <div id="singleFile">Select Files</div>
            <div class="photoActionBtn">
                <div class="qualityOption">
                    <input type="checkbox" id="cbQualityPhoto" class="uncheck" value="" name="qualityPhoto">
                    <label>High Quality</label>
                </div>
                <div class="actionUploadBtn">
                    <label for="" id="cancelUpload" class="actionFileUpload">Cancel</label>
                </div>
                <div class="actionUploadBtn">
                    <label for="" id="uploadPhoto" class="actionFileUpload">Upload</label>
                </div>
            </div>
        </div>
        <div id="displayPhotos"></div>
        <div id="status"></div>
    </div>
</div>
<div class="uiCreateAlbum uiPopUp">
    <div class="uiContainerPopUp">
        <div class="titlePopUp large-100">
            <span>Create Album</span>
        </div>
        <div class="mainPopUp large-100">
            <div class="uiAlbumContainer large-100">
                <form class="ink-form" id="albumInfo">
                    <fieldset>
                        <div class="control-group">
                            <label for="name">Album Name</label>
                            <div class="control">
                                <input type="text" name="titleAlbum" class="titleAlbum" autocomplete="off" placeholder="Untitled Album...">
                            </div>
                        </div>
                        <div class="uiAlbumAlerts"></div>
                        <div class="control-group">
                            <label for="name">Description</label>
                            <div class="control">
                                <textarea name="descriptionAlbum" class="taDescriptionAlbum" spellcheck="false" placeholder="Write description for this album..."></textarea>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="actionPopUp column-group push-right large-100">
            <a class="uiMediumButton blue createAlbumButton">Create</a>
            <a class="uiMediumButton white closeLightBox">Cancel</a>
        </div>
    </div>
</div>