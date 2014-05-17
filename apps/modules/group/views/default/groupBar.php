<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="large-100">

    <div class="topBarGroup">
        <div class="column-group">
            <div class="large-80">
                <nav class="ink-navigation">
                    <ul class="horizontal menu">
                        <li><a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a></li>
                        <li><a href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=membership">Members</a></li>
                        <li><a href="#">Event</a></li>
                        <li><a href="#">Photo</a></li>

                    </ul>
                </nav>
            </div>
            <div class="large-20 tiptip">
                <a title="Create Group" class="button" id="createGroup" href="/content/group/create"><span class="icon icon3"></span><span class="label">Create Group</span></a>
            </div>
        </div>

    </div>
</div>