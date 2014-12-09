
<ul class="menu sideNav">
    <li><h6>GROUP</h6></li>
    <?php
    $group = $this->f3->get('group');
    if (!empty($group))
    {
        foreach ($group as $value)
        {
            ?>
    <li><a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $value['group']->recordID) ?>"><i class="fa fa-bookmark fa-14"></i> <?php echo $value['group']->data->name ?></a></li>
                    <?php
                }
            }
            ?>
    <li ><a href="/content/group?category=admin"><i class="fa fa-align-left fa-14"></i> Groups your Admin</a></li>
    <li><a class="popup" title="Greate Group" href="/content/group/create"><i class="fa fa-plus-square fa-14"></i> Greate Group</a></li>
</ul>