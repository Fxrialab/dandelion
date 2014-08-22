<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$groupMember = F3::get('groupMember');
foreach ($groupMember as $value)
{
    $group = Controller::getID('group', $value->data->groupID);
    ?>
    <li><a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a></li>
    <?php
}
?>
