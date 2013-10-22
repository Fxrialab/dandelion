<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 10/4/13 - 10:21 AM
 * Project: userwired Network - Version: 1.0
 */
foreach(glob(MODULES.'photo/webroot/js/jshome.php') as $jshome)
{
    if(file_exists($jshome)){
        require_once ($jshome);
    }
}
$photos     = F3::get('photos');
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
        if($photos)
        {
            for ($i = 0; $i < count($photos); $i++)
            {
                ?>
                <div class="photo-entry" id="<?php echo str_replace(':','_',$photos[$i]->recordID);?>">
                    <div class="pt-photo-wrapper">
                        <a class="bac" href="/content/photo/viewPhoto?photoID=<?php echo substr($photos[$i]->recordID, strpos($photos[$i]->recordID, ':') + 1);?>">
                            <img max-width="150" max-height="150" class="ab" src="<?php echo $photos[$i]->data->url;?>"/>
                        </a>
                        <div class="wrapperHoverDelete">
                            <a class="Del" title="Delete" name="<?php echo $photos[$i]->recordID;?>">
                                <img class="deleteImg" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/images/icon-delete.jpg"/>
                            </a>
                        </div>
                        <div class="wrapperHoverLike">
                            <div class="descriptionImg">
                                <p>Timeline Photos</p>
                            </div>
                            <div class="count">
                                <img src="<?php echo F3::get('STATIC_MOD');?>photo/webroot/images/icon-like.png" />
                                <img src="<?php echo F3::get('STATIC_MOD');?>photo/webroot/images/icon-comment.png" />
                                <p class="countComment"><?php echo $photos[$i]->data->numberComment;?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>
</div>