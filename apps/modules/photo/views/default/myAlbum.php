<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>photo/webroot/js/photo.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>photo/webroot/js/jquery.uploadfile.min.js"></script>
<?php
$entries    = $this->f3->get('album');
$firstPhoto = $this->f3->get('firstPhoto');
?>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <div class="uiBoxTitle large-100 column-group">
            <div class="uiLeftPhotoBreadcrumbs large-50">
                <nav class="ink-navigation">
                    <ul class="breadcrumbs">
                        <li><a href="/content/myPhoto">Photo</a></li>
                        <li class="active"><a href="/content/photo/myAlbum">Album</a></li>
                    </ul>
                </nav>
            </div>
            <div class="uiRightPhotoTab large-50">
                <nav class="ink-navigation">
                    <ul class="menu horizontal push-right">
                        <li><a href="/content/myPhoto" class="uiMediumButton white">Your Photos</a></li>
                        <li><a href="/content/photo/myAlbum" class="uiMediumButton white">Albums</a></li>
                        <li><a href="#" class="uiMediumButton white">Not Tagged</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="uiPhotoContainer uiBox-PopUp albumBoxArrow">
            <div class="uiPhotoActionsBox column-group">
                <div class="large-20 uiUploadPhotoButton"><a class="uploadPhoto uiMediumButton orange">Upload Photo</a></div>
                <div class="large-20 uiCreateAlbumButton"><a class="createAlbum uiMediumButton orange">Create Album</a></div>
            </div>
            <div class="uiPinLayoutPhotoWrapper">
                <div class="uiPhotoPinCol">
                    <?php
                    if($entries)
                    {
                        for ($i = 0; $i < count($entries); $i++)
                        {
                            $albumID = str_replace(':', '_', $entries[$i]->recordID);
                            $coverImg= $entries[$i]->data->cover;
                            $albumName  = $entries[$i]->data->name;
                            $totalPhotos= $entries[$i]->data->count;
                        ?>
                            <div class="pinItems">
                                <?php
                                if(isset($entries[$i]->data->cover) && ($entries[$i]->data->count) == 0)
                                {
                                ?>
                                    <div class="albumItems">
                                        <a href="/content/photo/viewAlbum?albumID=<?php echo $albumID; ?>">
                                            <img class="firstPhoto" src="<?php echo $coverImg; ?>">
                                        </a>
                                    </div>
                                <?php
                                }elseif(isset($entries[$i]->data->count) != 0){
                                ?>
                                    <div class="albumItems">
                                        <input id="idAlbum" type="hidden" value="<?php echo $albumID; ?>" />
                                        <a href="/content/photo/viewAlbum?albumID=<?php echo $albumID; ?>">
                                            <?php
                                            foreach ($firstPhoto[($entries[$i]->recordID)] as $photo)
                                            {
                                            ?>
                                                <img class="firstPhoto" src="<?php echo $photo->data->url; ?>">
                                            <?php
                                            }
                                            ?>
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="albumDescription column-group">
                                    <a href="/content/photo/viewAlbum?albumID=<?php echo $albumID; ?>"><?php echo $albumName; ?></a>
                                </div>
                                <div class="albumCounter column-group">
                                    <div class="large-90 numberPhotoIn"><?php echo $totalPhotos; ?> photos</div>
                                    <div class="large-10 albumOptions"><a href=""><img src="<?php echo $this->f3->get('IMG');?>options.png"></a></div>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="fade" class="black_overlay"></div>
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