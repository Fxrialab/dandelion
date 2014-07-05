<div class="large-100">
    <div class="topBarGroup">
        <div class="column-group">
            <div class="large-65">
                <nav class="ink-navigation">
                    <ul class="horizontal menu">
                        <li><a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a></li>
                        <li><a href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=membership">Members</a></li>
                        <li><a href="#">Event</a></li>
                        <li><a href="#">Photo</a></li>
                    </ul>
                </nav>
            </div>
            <div class="large-15">
                <div class="float-right" style="position: relative">
                    <a data-dropdown="#dropdown-action-notify" class="button icon approve"><span class="label">Notifications</lable></a>
                    <div id="dropdown-action-notify" class="dropdown dropdown-tip">
                        <ul class="dropdown-menu">
                            <li><a href="#">All Posts</a></li>
                            <li><a href="#">Friend's Post</a></li>
                            <li><a href="#">Off</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="large-15 tiptip">
                <a title="Create Group" class="button icon add" id="createGroup" href="/content/group/create"><span class="label">Create Group</span></a>
            </div>
            <div class="large-5">
                <a data-dropdown="#dropdown-setting-notify" class="button icon settings"></a>
                <div id="dropdown-setting-notify" class="dropdown dropdown-tip dropdown-anchor-right">
                    <ul class="dropdown-menu">
                        <li><a href="#">Edit Notification Settings</a></li>
                        <li><a id="leaveGroup" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" href="/content/group/leave" title="<?php echo $group->data->name ?>">Leave Group</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>