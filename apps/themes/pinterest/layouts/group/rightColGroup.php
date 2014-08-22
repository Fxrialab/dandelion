<div class="large-50"><h2>ABOUT US</h2></div>
<div class="large-50"><?php echo $countMember ?> Members</div>
<div class="large-100">
    <nav class="ink-navigation">
        <ul class="vertical menu menuGroup">
            <li><?php echo $group->data->privacy ?> Group <p>What should people post in this group?</p></li>
            <li id="groupDescription">
                <?php
                if (!empty($group->data->description))
                    echo $group->data->description;
                if (!empty($group->data->admin))
                {
                    if ($group->data->admin = 'admin')
                    {
                        ?>
                        <a href="#" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" id="groupDescriptionLink">
                            <?php
                            if (!empty($group->data->description))
                                echo 'Edit';
                            else
                                echo 'Add a Description'
                            ?>

                        </a>
                    <?php
                    }
                }
                ?>
            </li>
        </ul>
    </nav>
</div>