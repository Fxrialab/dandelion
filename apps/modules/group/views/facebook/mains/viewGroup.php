<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$getGroup = $this->f3->get('group');
if (!empty($getGroup))
    $group = $this->f3->get('group');
else
    $group = HelperController::findGroup(str_replace("_", ":", $value->data->groupID));
if (!empty($group))
{
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
                        <li><a href="/content/group/leave?id=<?php echo str_replace(":", "_", $group->recordID) ?>" title="Leave Group" class="popup">Leave Group</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <?php
}?>