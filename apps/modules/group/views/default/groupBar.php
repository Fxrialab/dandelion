<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="large-100">
    <div class="column-group">

        <div style ="padding:5px; border: 1px solid #ccc; overflow: hidden; margin-bottom: 10px">
            <nav class="ink-navigation">
                <ul class="horizontal menu">
                    <li><a href="/content/group/groupDetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a></li>
                    <li><a href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>">Members</a></li>
                    <li><a href="#">Event</a></li>
                    <li><a href="#">Photo</a></li>
                    <a style="float: right" rel="leanModal" class="ink-button" name="modalGroup" href="#modalGroup">Create Group</a>
                </ul>
            </nav>

        </div>

    </div>
</div>