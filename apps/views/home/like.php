<?php
if (!empty($liked))
{
    ?>
    <a class="uiLike" data-like="<?php echo $type ?>;<?php echo $this->f3->get('SESSION.userID') . ';' . $objID ?>" data-rel="unlike">UnLike</a>
    <?php
}
else
{
    ?>
    <a class="uiLike" data-like="comment;<?php echo $this->f3->get('SESSION.userID') . ';' . $objID ?>" data-rel="like">Like</a>
<?php } ?>