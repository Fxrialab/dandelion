<?php
$rand = rand(100, 100000);
?>

<div class="ink-tabs top"> <!-- Creates a tabbed view with top nav -->
    <ul class="tabs-nav">
        <li><a href="#item1"><img src="<?php echo IMAGES; ?>status.png"> Status</a></li> <!-- Points to item 1 below -->
        <li><a href="#item2"><img src="<?php echo IMAGES; ?>photo.png"> Photo</a></li> <!-- Points to item 2 below -->
    </ul>
    <div id="item1" class="tabs-content"> <!-- Item 1 -->
        <div class="uiPostArea column-group">
            <div class="uiPostStatusArea">
                <form class="ink-form">
                    <div id="tagElements"></div>
                    <fieldset>
                        <div class="control-group">
                            <div class="uiBox-PopUp topLeftArrow control" id="displayPhotos">
                                <div id="typeActivity" style="display: none"></div>
                                <div id="typeActivityID" style="display: none"></div>
                                <textarea style="display: none" id="imgID" name="imgID"></textarea>
                                <textarea class="taPostStatus" id="status" name="status" spellcheck="false" placeholder="What's on your mind?"></textarea>
                            </div>
                            <div id="tagElements" class="notag">
                                <!-- tag Image, Video, Link here -->
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

</script>