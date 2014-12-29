<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($data))
    $group = $data;
else
    $group = $this->f3->get('group');

$uni = uniqid();
if (!empty($group))
{
    ?>
    <div class="groupItem" id="groupBrowse_<?php echo str_replace(":", "_", $group->recordID) ?>">
        <div class="column-group">
            <div class=" large-95">
                <div class="groupName">
                    <a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><i class="fa fa-bookmark fa-14"></i> <?php echo $group->data->name ?></a>
                </div>
            </div>
            <div class="large-5 _fr" style=" position: relative">
                <a data-dropdown="#dropdown_<?php echo str_replace(":", "_", $group->recordID) ?>_<?php echo $uni ?>" class="button settings"><i class="fa fa-cog fa-14 fa-b"></i></a>
                <div id="dropdown_<?php echo str_replace(":", "_", $group->recordID) ?>_<?php echo $uni ?>" class="dropdown dropdown-tip dropdown-anchor-right dropdown-right">
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