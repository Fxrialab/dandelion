<?php
if ($groupMember != 'null')
{
    foreach ($groupMember as $key => $value)
    {

        $recordGroup = GroupController::findMemeberGroup($value->recordID);
        $group = GroupController::findGroup($recordGroup->data->groupID);
        ?>
        <div class="groupItem" id="groupBrowse_<?php echo str_replace(":", "_", $group->recordID) ?>">
            <div class="column-group">
                <div class=" large-95">
                    <div class="groupName">
                        <a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a>
                    </div>
                </div>
                <div class="large-5">
                    <a data-dropdown="#dropdown-<?php echo str_replace(":", "_", $group->recordID) ?>" class="button icon settings"></a>
                    <div id="dropdown-<?php echo str_replace(":", "_", $group->recordID) ?>" class="dropdown dropdown-tip dropdown-anchor-right">
                        <ul class="dropdown-menu">
                            <li><a href="#1">Edit Notification Settings</a></li>
                            <li><a id="leaveGroup" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" href="/content/group/leave" title="<?php echo $group->data->name ?>">Leave Group</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
}
?>