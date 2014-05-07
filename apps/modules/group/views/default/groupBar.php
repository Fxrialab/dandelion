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
                        <li><a href="/content/group/groupDetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a></li>
                        <li><a href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>">Members</a></li>
                        <li><a href="#">Event</a></li>
                        <li><a href="#">Photo</a></li>
               <a style="float: right" rel="leanModal" class="ink-button" name="modalGroup" href="#modalGroup">Create Group</a>
                    </ul>
                </nav>
         
<!--       <a href="#" style="float: right" data-dropdown="#dropdown-2"></a>
                <input type="button" value="Upload Images" class="ink-button" data-dropdown="#dropdown-2" />
                <div id="dropdown-2" class="dropdown dropdown-tip">
                    <ul class="dropdown-menu">
                        <li><a href="#1">Choose from Group Photos</a></li>
                        <li><a href="#2">Choose from My Photos</a></li>
                        <li><a href="#3">Upload Photo</a></li>
                    </ul>
                </div>-->
 
         

        </div>

    </div>
</div>