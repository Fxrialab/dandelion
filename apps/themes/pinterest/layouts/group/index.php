<?php
$category = F3::get('category');
$data = F3::get('data');
?>
<div style ="padding:5px; border: 1px solid #ccc; margin-bottom: 10px">
    <div class="column-group">
        <div class="large-85">
            <nav class="ink-navigation">
                <ul class="horizontal menu">
                    <li><a href="#">Suggested Groups</a></li>
                    <li><a href="#">Friends Groups</a></li>
                    <li><a href="/content/group?category=nearby">Nearby Groups</a></li>
                    <li><a href="/content/group?category=membership">Your Groups</a></li>
                    <li><a href="/content/group?category=admin">Groups You Admin</a></li>
                </ul>
            </nav>
        </div>
        <div class="large-15 tiptip">
            <a class="button" rel="Greate New Group" title="Greate Group" id="createGroup" href="/content/group/create">Create Group</a>
        </div>

    </div>
</div>

<div class="uiMainColProfile groupWrapper large-100">
    <input type="hidden" id="roleGroup" value="">
    <div style="padding: 10px 15px; background-color: #ddd;">
        <h5> 
            <?php
            if ($category == 'admin')
                echo 'ADMIN GROUPS';
            else
                echo 'MEMBERSHIP GROUPS';
            ?>
        </h5>
    </div>
    <div id="viewGroup">
        <?php
        if (!empty($data))
        {
            foreach ($data as $key => $value)
            {

                $recordGroup = GroupController::findMemeberGroup($value->recordID);
                $group = GroupController::findGroup($recordGroup->data->groupID);
                ?>
                <div class="groupItem" id="groupBrowse_<?php echo str_replace(":", "_", $group->recordID) ?>">
                    <div class="column-group">
                        <div class=" large-95">
                            <div class="groupName">
                                <a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a>
                            </div>
                        </div>
                        <div class="large-5">
                            <a data-dropdown="#dropdown-<?php echo str_replace(":", "_", $group->recordID) ?>" class="button icon settings"></a>
                            <div id="dropdown-<?php echo str_replace(":", "_", $group->recordID) ?>" class="dropdown dropdown-tip dropdown-anchor-right">
                                <ul class="dropdown-menu">
                                    <li><a href="#">Edit Notification Settings</a></li>
                                    <li><a class="leaveGroup" href="/content/group/leave?id=<?php echo str_replace(":", "_", $group->recordID) ?>" title="<?php echo $group->data->name ?>">Leave Group</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <script>

//        $(document).ready(function() {
//            $('#viewGroup').scrollPaginationGroup({
//                nop: 20,
//                offset: 0,
//                error: '',
//                delay: 500,
//                scroll: true
//            });
//        });

    </script>
