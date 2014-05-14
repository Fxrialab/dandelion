<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="large-100">
    <div class="column-group">
        <div class="topBarGroup">
            <nav class="ink-navigation">
                <ul class="horizontal menu">
                    <li><a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a></li>
                    <li><a href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=membership">Members</a></li>
                    <li><a href="#">Event</a></li>
                    <li><a href="#">Photo</a></li>
                    <a title="Create Group" class="ink-button float-right add" id="createGroup" href="/content/group/create">Create Group</a>
                </ul>
            </nav>





        </div>

    </div>
</div>