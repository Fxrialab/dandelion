<?php
    $entries    =   F3::get('album');
    $firstPhoto = f3::get('firstPhoto');

?>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/socialewired.photo.js"></script>
<div class="wrapperTitlePhoto">
    <div class="BoxUpload">
        <div class="photosTitle">
            <p class="iconPhoto"></p>
            <a>Photos</a>
        </div>
        <div class="uploadPhoto" style="display: none;">
            <input id="album_id" type="hidden" value="">
        </div>
        <div class="uploadAlbum">
        </div>
    </div>
    <div class="menuPhoto">
        <li class="linkPhoto" id="navPhotoOfYour">
            <a class="photos_of" href="#">Photo of Your</a>
        </li>
        <li class="linkPhoto" id="navPhotos">
            <a href="/content/myPhoto" id="photos_all">Your Photos</a>
        </li>
        <li class="linkPhoto" id="navAlbums">
            <a href="/content/photo/myAlbum" id="photos_albums" style="color:white;">Albums</a>
        </li>
    </div>
</div>
<div id="lightBox" class="white_content">
    <div class="create-album-container">
        <div class="headerLightBox">CREATE ALBUM</div>
        <form id="albumInfo">
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
                        <a href="/content/photo/viewAlbum?id=<?php echo str_replace(':', '_', $entries[$i]->recordID);?>">
                            <img max-width="150" max-height="150" class="pt" src="<?php echo $entries[$i]->data->cover; ?>"/>
                        </a>
                    </div>
                    <?php
                } elseif(isset($entries[$i]->data->count) != 0) {
                    ?>
                    <div class="pt-album-wrapper">
                        <input id="idAlbum" type="hidden" value="<?php echo str_replace(':','_',$entries[$i]->recordID); ?>" />
                        <a href="/content/photo/viewAlbum?id=<?php echo str_replace(':','_',$entries[$i]->recordID);?>">
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