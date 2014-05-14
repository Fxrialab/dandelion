<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = $this->f3->get('group');
if (!empty($group))
    $groupID = $group->recordID;
?>

<a href="#" class="ink-button edit" data-dropdown="#dropdown-editcover">Edit cover</a>
<div id="dropdown-editcover" class="dropdown dropdown-notip dropdown-anchor-right">
    <ul class="dropdown-menu">
        <li><a href="#" class="myPhotoGroup" rel="<?php echo $groupID ?>" title="My Photos">Choose from My Photos</a></li>
        <li><a id="uploadPhotoGroup">Upload Photo</a></li>
    </ul>
</div>