
<?php
$data = $this->f3->get('data');
if (!empty($data))
{
    foreach ($data as $value)
    {
        ?>
        <li>
            <div class="control-group">
                <div class="large-15">
                    <img src="<?php echo $this->getAvatar($value['user']->data->profilePic) ?>" width="50" height="50">
                </div>
                <div class="large-45">
                    <div class="fullName">
                        <a href="#" style="font-weight: bold"><?php echo $value['user']->data->fullName; ?></a>
                        <p><?php echo $value['countFriend'] ?> mutual friends</p>
                    </div>
                </div>
                <div class="large-40">
                    <div class="option">
                        <a href="#" class="button button35 active">Comfirm</a>
                        <a href="#" class="button button35">Not now</a>
                    </div>
                </div>
            </div>
        </li>
        <?php
    }
} else
{
    ?>
    <li>
        <div class="control-group content-center">
            <span>Nothing to display</span>
        </div>
    </li>
    <?php
}
?>