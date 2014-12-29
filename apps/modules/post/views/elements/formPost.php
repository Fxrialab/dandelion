
<input type="hidden" name="rand" id="rand" value="<?php echo rand(100, 100000); ?>">
<div class="formStatus">
    <nav class="ink-navigation">
        <ul class="menu horizontal tab-status">
            <li><a href="javascript:void(0)"  onclick="return tab('status');"><i class="fa fa-pencil-square fa-18"></i> Update Status</a></li>
            <li><a href="javascript:void(0)" onclick="return tab('media');"><i class="fa fa-picture-o fa-18"></i> Add Photos/Video</a></li>

        </ul>
    </nav>
    <div class="status" style=" margin: 0">
        <div class="uiPostArea column-group">
            <div class="uiPostStatusArea">
                <form class="ink-form" id="submitFormStatus">
                    <div class="uiPostContent control-group">
                        <div class="control">
                            <div id="typeActivity"></div>
                            <div id="typeActivityID"></div>
                            <textarea id="status" name="status" spellcheck="false" placeholder="What's on your mind?"></textarea>
                            <div class="embedElements">
                                <!-- tag Image, Video, Link here -->
                                <input type="hidden" id="embedType" name="embedType" value="">
                                <div id="embedPhotos" class="control-group"></div>
                                <div id="embedVideo"></div>
                            </div>
                            <div id="tagUsers" class="notag">

                            </div>
                        </div>
                    </div>
                    <div class="uiPostOption control-group" style="display: none">
                        <nav class="ink-navigation">
                            <ul class="menu horizontal">
                                <li><span><i class="fa fa-user fa-18"></i></span></li>
                                <li><span><i class="fa fa-map-marker fa-18"></i></span></li>
                                <li><span id="multiFiles"><i class="fa fa-camera fa-18"></i></span> </li>
                                <li><span><i class="fa fa-meh-o fa-18"></i></span></li>
                                <li class="fixRightFloat"><button class="button active">Post</button></li>
                            </ul>
                        </nav>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="media" style="display: none">
        <div class="uiPostArea column-group">
            <div class="uiPostPhotoArea">
                <div class="content-center">
                    <div class="large-50 uiUploadPhotoBox borderLineRight">
                        <input name="album_id" id="albumID" value="none" type="hidden">
                        <div id="multiFiles2">Upload Photos</div>
                    </div>
                    <div class="large-50 uiCreateAlbumBox createAlbum">
                        <div class="dialogAlbum">Create Photo Album</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


