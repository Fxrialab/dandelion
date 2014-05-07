<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($urlCover))
    $url = $urlCover;
else
    $url = $this->f3->get('url');
?>
<div style="width: 745px; height: 300px">
    <img src="<?php echo $url ?>">
</div>