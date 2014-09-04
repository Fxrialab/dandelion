<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
if ($this->f3->get('groupMember') != 'null')
{
    foreach ($this->f3->get('groupMember') as $key => $value)
    {
        $group = GroupController::findGroup(str_replace(":", "_", $value->data->groupID));
        ?>
        <div style ="padding:5px; border-bottom: 1px solid #ccc;" id="groupBrowse_<?php echo str_replace(":", "_", $value->data->groupID) ?>">
            <div class="column-group">

                <div class=" large-90" style=" padding-top: 20px">
                    <a href="/content/group/groupDetail?id=<?php echo str_replace(":", "_", $value->data->groupID) ?>"><?php echo $group->data->name ?></a>
                </div>
                <div class="large-10">
                    <a href="#" class="ink-button" data-dropdown="#dropdown-<?php echo str_replace(":", "_", $value->data->groupID) ?>">Setting</a>
                    <div id="dropdown-<?php echo str_replace(":", "_", $value->data->groupID) ?>" class="dropdown dropdown-tip dropdown-anchor-right">
                        <ul class="dropdown-menu">
                            <li><a href="#1">Edit Notification Settings</a></li>
                            <li><a id="leaveGroup" rel="<?php echo str_replace(":", "_", $value->data->groupID) ?>" href="/content/group/leave" title="<?php echo $group->data->name ?>">Leave Group</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
