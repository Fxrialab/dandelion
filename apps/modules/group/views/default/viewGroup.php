<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$getGroup = $this->f3->get('group');
if (!empty($getGroup))
    $group = $this->f3->get('group');
else
    $group = GroupController::findGroup(str_replace(":", "_", $value->data->groupID));
?>
<div class="groupItem" id="groupBrowse_<?php echo str_replace(":", "_", $group->recordID) ?>">
    <div class="column-group">

        <div class=" large-90">
            <a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a>
        </div>
        <div class="large-10">
            <a href="#" class="ink-button" data-dropdown="#dropdown-<?php echo str_replace(":", "_", $group->recordID) ?>">Setting</a>
            <div id="dropdown-<?php echo str_replace(":", "_", $group->recordID) ?>" class="dropdown dropdown-tip dropdown-anchor-right">
                <ul class="dropdown-menu">
                    <li><a href="#1">Edit Notification Settings</a></li>
                    <li><a id="leaveGroup" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" href="/content/group/leave" title="<?php echo $group->data->name ?>">Leave Group</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>