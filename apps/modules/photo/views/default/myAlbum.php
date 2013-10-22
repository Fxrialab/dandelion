<?php
foreach(glob(MODULES.'photo/webroot/js/jshome.php') as $jshome){
    if(file_exists($jshome)){
        require_once ($jshome);
    }
}
$entries    = F3::get('album');
$firstPhoto = F3::get('firstPhoto');
?>
<div class="photoContainer">
    <div class="wrapperTitlePhoto">
        <div class="BoxUpload">
            <div class="photosTitle">
                <p class="iconPhoto"></p>
                <a>Photos</a>
            </div>
            <div class="uploadPhoto">
                <input id="album_id" type="hidden" value="">
            </div>
            <div class="uploadAlbum">
            </div>
        </div>
        <?php
        AppController::elementModules('menu','photo');
        ?>
    </div>
    <div id="lightBox" class="white_content">
        <div class="create-album-container">
            <div class="headerLightBox">CREATE ALBUM</div>
            <form id="albumInfo" method="post">
                <div class="contentLightBox">
                    <div class="containerTitleAlbum">
                        <input class="titleAlbum" type="text" name="titleAlbum" placeholder="Untitled Album" />
                    </div>
                    <div class="msgCheckAlbum" style="display: none;">
                        <span class="msgErrorAlbum">Please enter information for title album.</span>
                        <a class="closeMsgErrorAlbum">x</a>
                    </div>
                    <div class="containerDescriptionAlbum">
                        <textarea class="descriptionAlbum" name="descriptionAlbum" placeholder="Description Album"></textarea>
                    </div>
                </div>
                <div class="footerLightBox">
                    <input class="createAlbumButton" type="submit" value="Create" />
                    <a id="closeLightBox" title="Close">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <div id="fade" class="black_overlay"></div>
    <div id="lightUpload">
        <div class="containerPhotoPopUp">
            <div class="actionUpload">
                <input name="album_id" id="albumID" value="none" type="hidden">
                <div id="mulitplefileuploader">Select Files</div>
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
    <div id="fadeUpload"></div>
    <div class="photo-wrapper">
        <?php
        if($entries) {
            for ($i = 0; $i < count($entries); $i++) {
                ?>
                <div class="photos_albums" id="<?php echo str_replace(':','_',$entries[$i]->recordID);?>">
                    <?php
                    if(isset($entries[$i]->data->cover) && ($entries[$i]->data->count) == 0) {//album
                        ?>
                        <div class="pt-album-wrapper">
                            <a href="/content/photo/viewAlbum?albumID=<?php echo str_replace(':', '_', $entries[$i]->recordID);?>">
                                <img max-width="150" max-height="150" class="pt" src="<?php echo $entries[$i]->data->cover; ?>"/>
                            </a>
                        </div>
                        <?php
                    } elseif(isset($entries[$i]->data->count) != 0) {
                        ?>
                        <div class="pt-album-wrapper">
                            <input id="idAlbum" type="hidden" value="<?php echo str_replace(':','_',$entries[$i]->recordID); ?>" />
                            <a href="/content/photo/viewAlbum?albumID=<?php echo str_replace(':','_',$entries[$i]->recordID);?>">
                                <img class="pt" src="
                            <?php foreach ($firstPhoto[($entries[$i]->recordID)] as $Photo) {
                                    echo $Photo->data->url;
                                } ?>
                            "/>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="photo-title">
                        <?php
                        if (isset($entries[$i]->data->name))
                        {
                            ?>
                            <span><?php echo $entries[$i]->data->name; ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="desAlbum">
                        <?php
                        if (isset($entries[$i]->data->description))
                        {
                            ?>
                            <span><?php echo $entries[$i]->data->description; ?></span>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="photo-description">
                        <?php
                        if (isset($entries[$i]->data->count))
                        {
                            ?>
                            <span class="photo-quanitiy"><?php echo $entries[$i]->data->count; ?> photo(s)</span>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }// end for
        ?>
    </div>
</div>