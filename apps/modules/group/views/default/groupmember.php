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
        <div class="column-group">
            <div style ="padding:10px 5px; border-bottom: 1px solid #ccc;">
                <a href="/content/group/groupDetail?id=<?php echo str_replace(":", "_", $value->data->groupID) ?>"><?php echo $group->data->name ?></a>
            
            </div>
        </div>
        <?php
    }
}
?>