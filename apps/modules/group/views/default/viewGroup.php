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

        <div class=" large-95">
            <a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a>
        </div>
        <div class="large-5">
            <div class="tiptip">
                <div class="dropdown">
                    <a title="Setting" class="button"><span class="icon icon96"></span></a>
                    <div class="dropdown-slider w120">
                        <a href="#1" class="ddm"><span class="label">Edit Notification Settings</span></a>
                        <a class="ddm" id="leaveGroup" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" href="/content/group/leave" title="<?php echo $group->data->name ?>"><span class="label"> Leave Group</span></a>
                    </div> <!-- /.dropdown-slider -->
                </div> <!-- /.dropdown -->
            </div>   

        </div>
    </div>
</div>