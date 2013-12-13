<?php
$rand = rand(100,100000);
?>
<script>
    function isValidURL(url){
        var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

        if(RegExp.test(url)){
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
<div class="uiBoxPostAction">
    <div class="uiPostTopNav column-group">
        <nav class="ink-navigation">
            <ul class="menu horizontal">
                <li><a href="#"><img src="<?php echo IMAGES; ?>status.png"> Status</a></li>
                <li class="lineGap">|</li>
                <li><a href="#"><img src="<?php echo IMAGES; ?>photo.png"> Photo</a></li>
            </ul>
        </nav>
    </div>
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
        <div class="uiPostPhotoArea"></div>
    </div>
</div>