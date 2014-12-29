<?php
$currentProfile = $this->f3->get('SESSION.loggedUser');
?>
<input type="hidden" id="location-href" value="">
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>infinitescroll.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.uploadfile.min.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/init.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/upload.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/pretty.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink.min.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/autoload.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.autosize.min.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/blocksit.min.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.oembed.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.tokeninput.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.dropdown.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>mq.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>swfobject.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('WEBROOT'); ?>libs/pgwmodal/pgwmodal.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.tmpl.min.js"></script>
<script id="imgTemplate" type="text/x-jQuery-tmpl">
    <div class="imgContainer ${id}">
    <input type="hidden" name="imgName[]" value="${photoName}">
    <img class="loadingImage" src="${url}">
    <a href="javascript:void(0)" style="position: absolute; top:1px; right:5px" rel="${id}_${photoName}" class="deletePhoto"><span class="icon icon56">X</span></a>
    </div>
</script>
<script id="imgTemplate2" type="text/x-jQuery-tmpl">
    <div class="large-20 itemImg" id="${imgID}" style="position: relative">
    <div style="margin-right:10px;">
    <input type="hidden" name="imgID[]" value="${name},${width},${height}">
    <img src="${url}" style="width:100%">
    <a href="javascript:void(0)" style="position: absolute; top:5px; right:25px" rel="${name}" relID="${imgID}" class="deleteImage"><span class="icon icon56">X</span></a>
    </div>
    </div>
</script>

<script id="photoCoverUserTemplate" type="text/x-jQuery-tmpl">
    <div class="imgCover">
    <div style="width:${width}px; height:${height}px;  position: relative; left: ${left}px; top: ${top}px">
    <img src="<?php echo UPLOAD_URL . 'cover/750px/'; ?>${src}" style="width:100%;">
    </div>
    </div>
</script>
<script id="comfirmTemplate" type="text/x-jQuery-tmpl">
    <div class="control-group">
    <div class="control">
    <div class="statusDialog">Are you sure you want to remove </div>
    </div>
    <input type="hidden" id="role" name="role" value="${role}">
    <div class="footerDialog" >
    <button type="submit" class="ink-button green-button comfirmDialog">Comfirm</button>
    <button class=" closeDialog ink-button ">Cancel</a>
    </div>
    </div>
</script>

<script id="navInfoUserTemplate" type="text/x-jQuery-tmpl">
    <div>
    <nav class="ink-navigation uiTimeLineHeadLine">
    <ul class="menu horizontal">
    <li><a href="/user/${username}">TimeLine</a></li>
    <li><a href="/about?user=${username}">About</a></li>
    <li><a href="/friends?user=${username}">Friends</a></li>
    <li><a href="/content/post?user=${username}">Post</a></li>
    <li><a href="/content/photo?user=${username}">Photos</a></li>
    <li><a href="#">More</a></li>
    </ul>
    </nav>
    </div>
</script>
<script id="navCoverUserTemplate" type="text/x-jQuery-tmpl">
    <div class="cancelCover">
    <nav class="ink-navigation uiTimeLineHeadLine">
    <ul class="menu horizontal uiTimeLineHeadLine float-right">
    <li><button type="button" class="ink-button cancel" id="coverPhoto">Cancel</button></li>
    <li><button type="submit" class="ink-button green-button">Save Changes</button></li>
    </ul>
    </nav>
    </div>
</script>