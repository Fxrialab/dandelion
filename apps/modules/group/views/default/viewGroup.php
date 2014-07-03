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
                <div class="menuClick">
                    <a id="linkSetting<?php echo $key ?>" class="button icon settings"></a>
                    <div id="divSetting<?php echo $key ?>" class="divmenu">
                        <nav class="ink-navigation">
                            <ul class="menu vertical ">
                                <li><a href="#1">Edit Notification Settings</a></li>
                                <li><a id="leaveGroup" rel="<?php echo str_replace(":", "_", $value->data->groupID) ?>" href="/content/group/leave" title="<?php echo $group->data->name ?>">Leave Group</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}?>