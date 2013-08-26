<?php
$rand = rand(100,100000);
$currentProfileID = F3::get('currentProfileID');

//$currentProfileID   = $currentProfile->recordID;
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
                        url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand ?>">$2</a></div>');
                        url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand ?> ">$2</a></div>');
                    }
                } else {
                    if(isValidURL(urlString)){
                        fullURL = url = urlString;
                        url = url.replace(/(\s|>|^)(https?:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand ?>">$2</a></div>');
                        url = url.replace(/(\s|>|^)(mailto:[^\s<]*)/igm,'$1<div><a href="$2" class="oembed<?php echo $rand ?>">$2</a></div>');
                    }
                }
            }
            $('#tagElements').css('display', 'block');
            $('#tagElements').empty().html(url);
            $(".oembed<?php echo $rand ?>").oembed(null,
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
<div id="pagelet_composer" class="clearfix">
    <div class="swTitle">Sociale Live</div>
    <form id="swComposerMsgBox" name="postStatusForm" method="post" action="">
        <input name="profileID" id="profileID" type="hidden" value="<?php echo $currentProfileID;?>">
        <div class="swComposerMsgBox">
            <div class="top">
                <a href="" class="swTagClear">x</a>
            </div>
            <div class="content">
                <table border="none" cellpadding="0" cellspacing="0">
                    <td>
                        <div class="inputContainer">
                            <div class="wrap">
                                <div class="innerWrap">
                                    <textarea name="status" id="status" cols="30" rows="10" class="textInput" title="Your status?"></textarea>

                                </div>
                            </div>
                        </div>
                    </td>
                </table>
            </div>
            <div class="bottom">
                <ul>
                    <li>
                        <span href="" class="swTagPhoto"></span>
                    </li>
                    <!--<li>
                        <span href="" class="swTagVideo"></span>
                    </li>
                    <li>
                        <span href="" class="swTagLink"></span>
                    </li>-->
                </ul>
            </div>
            <div id="tagElements" class="notag">
                <!-- tag Image, Video, Link here -->
            </div>
            <div class="getValue">

            </div>
        </div>
        <div class="clear"></div>
        <div class="swComposerTagControl">
            <div class="left">
            <span class="peopleTags">
                <span class="tag">Social Club <a href="" class="btnClear">x</a></span>
                <span class="tag">O Friends <a href="" class="btnClear">x</a></span>
                
            </span>
            </div>
            <div class="right">
                <span class="moreTag">Category</span>
                <input type="submit" id="submitStatus" name="submitStatus" class="swShareButton" value="Share">
            </div>
        </div>
    </form>
</div>