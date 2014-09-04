<?php
    $album_id   = F3::get("album_id");
    $photos     = F3::get("photos");
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/tmpl.min.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/load-image.min.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/jquery.fileupload-process.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/jquery.fileupload-image.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/jquery.fileupload-validate.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/jquery.fileupload-jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/main.js"></script>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/socialewired.photo.js"></script>

<div class="ContainerUpload">
    <div class="wrapperTitlePhoto">
        <div class="BoxUpload">
            <div class="photosTitle">
                <p class="iconPhoto"></p>
                <a>Photos</a>
            </div>
            <div class="uploadPhoto createAlbum">
                <input id="album_id" type="hidden" value="">
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
                <a href="/content/photo/myAlbum" id="photos_albums" style="color: #ffffff;">Albums</a>
            </li>
        </div>
    </div>
    <div id="lightUpload">
        <form id="fileupload" action="/content/photo/uploadPhoto" method="POST" enctype="multipart/form-data">
            <input name="album_id" value="<?php echo $album_id?>" type="hidden">
            <div class="fileupload-buttonbar">
                <div class="fileupload-buttons">
                    <span class="fileinput-button">
                        <span>Add files...</span>
                        <input class="chooseFile" type="file" name="files[]" multiple>
                    </span>
                    <button type="submit" class="start" id="icon-start">Start upload</button>
                    <button class="cancel" id="icon-menu">Cancel upload</button>
                    <span class="fileupload-loading"></span>
                </div>
                <div class="fileupload-progress fade" style="display:none">
                    <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <div role="presentation"><div class="files"></div></div>
        </form>
        <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
            <div class="template-upload fade" style="display:none">
                <div>
                    <span class="preview"></span>
                    {% if (file.error) { %}
                    <div class="Error"><span class="error">Error:</span> {%=file.error%}</div>
                    {% } %}
                    {% if (!file.error) { %}
                    {%}%}
                    {% if (!o.files.error) { %}
                    <div id="loading" class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>
                    {% } %}

                    {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                    <button class="start" style="display:none;">Start</button>
                    {% } %}
                    {% if (!i) { %}
                    <button class="cancel" id="icon-cancel"></button>
                    {% } %}
                </div>
            </div>
            {% } %}
        </script>
        <script id="template-download" type="text/x-tmpl">
        </script>
    </div>
    <div id="fade" class="black_overlay"></div>
</div>

<div class="album-wrapper">
    <?php
    if($photos)
    {
    for ($i = 0; $i < count($photos); $i++)
        {
        ?>
    <div class="photo-entry" id="<?php echo str_replace(':','_',$photos[$i]->recordID);?>">
        <div class="pt-photo-wrapper">
            <a href="/content/photo/viewPhoto?albumID=<?php echo substr($photos[$i]->recordID, strpos($photos[$i]->recordID, ':') + 1);?>">
                <?php /*echo substr($album_id, strpos($album_id, '_') + 1);*/?>
                <div class="pt-fake-wrapper">
                    <img class="ab" src="<?php echo $photos[$i]->data->url;?>"/>
                </div>
            </a>
            <div class="wrapperHoverDelete">
                <a class="Del" title="Delete" name="<?php echo $photos[$i]->recordID;?>"><img class="deleteImg" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/images/icon-delete.jpg"/></a>
            </div>
            <div class="wrapperHoverLike">
                <div class="descriptionImg"><p>Untitled Album</p></div>
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
    } // end for
    ?>
</div>
