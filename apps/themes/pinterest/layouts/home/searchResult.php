<nav class="ink-navigation">
    <ul class="menu horizontal menuSearch">
        <li>
            <a href="#">All Result</a>
        </li>
        <li>
            <a href="#">People</a>
        </li>
        <li>
            <a href="#">Page</a>
        </li>
        <li>
            <a href="#">Group</a>
        </li>
    </ul>
</nav>
<?php
if ($resultSearch)
{
    foreach ($resultSearch as $people)
    {
        if ($infoOfSearchFound[$people][0]->profilePic != 'none')
            $avatar = $infoOfSearchFound[$people][0]->profilePic;
        else
            $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
        $fullName = ucfirst($infoOfSearchFound[$people][0]->firstName) . " " . ucfirst($infoOfSearchFound[$people][0]->lastName);
        $linkProfile = $infoOfSearchFound[$people][0]->username;
        ?>
        <div class="control-group">
            <div class="resultItem" style="">
                <div class="large-25">
                    <a class="linkProfile" href="">
                        <img src="<?php echo $avatar; ?>">
                    </a>
                </div>
                <div class="large-75">
                    <div class="info">
                        <a href="/content/myPost?username=<?php echo $linkProfile; ?>" class="title"><?php echo $fullName; ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
