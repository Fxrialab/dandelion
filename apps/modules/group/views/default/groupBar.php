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
            <div class="large-15 tiptip">
                <a title="Create Group" class="button" id="createGroup" href="/content/group/create"><span class="icon icon3"></span><span class="label">Create Group</span></a>
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
</div>