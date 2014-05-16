<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($url))
{
    $style = 'height: 250px; width:100%; border:1px;  background: url(' . $url . ');';
    $url = $url;
    $remove = '<li><a href="#" title="Remove">Remove</a></li>';
    $lable = 'Edit a cover';
}
else
{
    $style = '';
    $url = '';
    $remove = '';
    $lable = 'Add a cover';
}
?>

<div class="colum-group">
    <div style="<?php echo $style ?>)">
        <div class="large-85">
            <input type="hidden" name="urlCover" value="<?php echo $url ?>">
        </div>
        <div class="large-15 editdropdown float-right">
            <a href="#" class="ink-button edit" data-dropdown="#dropdown-editcover"><?php echo $lable ?></a>
            <div id="dropdown-editcover" class="dropdown dropdown-notip dropdown-anchor-right">
                <ul class="dropdown-menu">
                    <li><a href="#" class="photoBrowse" rel="" title="My Photos">Choose from My Photos</a></li>
                    <li><a id="uploadPhotoCover">Upload Photo</a></li>
                        <?php echo $remove ?>
                </ul>
            </div>
        </div>
    </div>
</div>
