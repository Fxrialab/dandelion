<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = F3::get('group');
if (!empty($group))
    $groupID = $group->recordID;
?>
<div class="tiptip" style=" position: absolute; top: 10; right: 10px">
    <div class="dropdown">
        <button title="Edit cover"><span class="icon icon148"></span><span class="label">Edit cover</span></button>
        <div class="dropdown-slider w175">
            <a href="#" class="myPhotoGroup ddm"  rel="<?php echo $groupID ?>" title="My Photos"><span class="icon icon147"></span><span class="label">Choose from Photos...</span></a>
            <a href="#" class="ddm"><div id="uploadPhotoGroup"><span class="icon icon189"></span><span class="label">Upload photo</span></div></a>
        </div> <!-- /.dropdown-slider -->
    </div> <!-- /.dropdown -->
</div>