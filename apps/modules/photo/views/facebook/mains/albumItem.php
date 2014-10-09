<div class="large-33">
    <div class="albumItems">
        <div class="photoInside large-100">
            <a href="/content/photo?user=<?php echo $user->data->username; ?>&album=<?php echo $albumID; ?>">
                <img src="<?php echo UPLOAD_URL.'images/'.$lastPhoto; ?>" height="200">
            </a>
        </div>
        <div class="albumInfo large-100">
            <div class="albumTitle">
                <span><?php echo $albumTitle; ?></span>
            </div>
            <div class="numberPhoto">
                <span><?php echo $numberPhoto; ?> photos</span>
            </div>
        </div>
    </div>
</div>