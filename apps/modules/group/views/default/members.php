<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = $this->f3->get('group');
$groupName = $group->data->name;
$f3 = require('groupBar.php');
$members = $this->f3->get('members');
$admin = $this->f3->get('admin');
$countMember = $this->f3->get('countMember');
$countAdmin = $this->f3->get('countAdmin');
?>

<div class="column-group">
    <div class="large-70" style="padding-right: 20px">
        <div class="large-100">
            <div class="column-group">
                <div style ="padding:10px 0 40px; margin-bottom: 10px">
                    <div class="large-25">
                        <?php
                        if (($admin) == 'admin')
                            $act = 'Admins (' . $countAdmin . ')';
                        else
                            $act = 'All members (' . $countMember . ')';
                        ?>
                        <a href="#" class="ink-button" data-dropdown="#dropdown-select"><?php echo $act ?></a>
                        <div id="dropdown-select" class="dropdown dropdown-notip">
                            <ul class="dropdown-menu">
                                <li class="<?php if ($admin == 'membership') echo 'active'; ?>"><a href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>">All members (<?php echo $countMember ?>)</a></li>
                                <li class="<?php if ($admin == 'admin') echo 'active'; ?>"><a href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=admin">Admins (<?php echo $countAdmin ?>)</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="large-75">
                        <div style ="padding-left: 20px;">
                            <nav class="ink-navigation">
                                <ul class="horizontal menu">
                                    <li>
                                        <form class="ink-form" action="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=<?php echo $admin ?>" method="post">
                                            <div class="control-group">
                                                <input type="text" id="search" name="search" style="height: 25px">
                                            </div>
                                            <input type="hidden">
                                        </form>
                                    </li>
                                    <a rel="<?php echo str_replace(":", "_", $group->recordID) ?>" class="ink-button float-right add" title="Add People to Group" id="addMember" href="/content/group/ajax/addFriend">Add people</a>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
        if (!empty($members))
        {
            foreach ($members as $key => $value)
            {
                $user = GroupController::findUser($value->data->member);
                ?>
                <div class="large-30" id="user_<?php echo str_replace(":", "_", $user->recordID) ?>">
                    <div class="large-35">
                        <a href="/content/myPost?username=<?php echo $user->data->username ?>"><img src="<?php echo $user->data->profilePic ?>"></a>
                    </div>
                    <div class="large-65">
                        <div class="userItem">
                            <a class="fullName" href="/content/myPost?username=<?php echo $user->data->username ?>"><?php echo $user->data->fullName; ?></a><br>
                            <a href="#" data-dropdown="#dropdown-<?php echo str_replace(":", "_", $user->recordID) ?>" class=" topNavIcon2-settingGroup"></a>
                            <div id="dropdown-<?php echo str_replace(":", "_", $user->recordID) ?>" class="dropdown dropdown-tip">
                                <ul class="dropdown-menu">
                                    <?php
                                    if ($value->data->action == 0)
                                    {
                                        ?>
                                        <li><a rel="<?php echo $user->recordID ?>" title="Remove as admin" class="removeGroup" href="/content/group/ajax/removeAdmin"> Remove as admin</a></li>
                                        <li><a id="leaveGroup" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" href="/content/group/leave" title="<?php echo $groupName ?>">Leave Group</a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        if ($value->data->role == 'admin')
                                        {
                                            ?>
                                            <li><a class="roleGroup" rel="<?php echo $user->recordID ?>" title="Remove as admin" href="/content/group/ajax/rolegroup">Remove as admin</a></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li><a class="roleGroup" rel="<?php echo $user->recordID ?>" title="Add Group Admin" href="/content/group/ajax/rolegroup">Make Admin</a></li>
                                        <?php } ?>
                                        <li><a rel="<?php echo $user->recordID ?>" title="Remove" role="remove" class="removeGroup" href="/content/group/ajax/removeGroup"> Remove as group</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
            }
        }
        ?>
        <input type="hidden" id="group_id" value="<?php echo $group->recordID ?>">
    </div>
    <div class="large-30" style="padding:10px 5px;">
        <div class="large-50"><h2>ABOUT US</h2></div>
        <div class="large-50"><?php echo $countMember ?> Members</div>
        <div class="large-100">
            <nav class="ink-navigation">
                <ul class="vertical menu menuGroup">
                    <li><?php echo $group->data->privacy ?> Group <p>What should people post in this group?</p></li>
                    <li id="groupDescription">
                        <?php
                        if (!empty($group->data->description))
                            echo $group->data->description;
                        if (!empty($group->data->admin))
                        {
                            if ($group->data->admin = 'admin')
                            {
                                ?>
                                <a href="#" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" id="groupDescriptionLink">
                                    <?php
                                    if (!empty($group->data->description))
                                        echo 'Edit';
                                    else
                                        echo 'Add a Description'
                                        ?>

                                </a>
                                <?php
                            }
                        }
                        ?>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>

//                            $('#callbacks').selectric();
    $(document).ready(function() {
        $("input[type='hidden']").keypress(function(e) {
            if (e.which == 13) {
                alert("User pressed 'Enter' in a text input.");
                // do your custom processing here
            }
        })
    });
    $(function() {
        $("#groupDescriptionLink").bind("click", function() {
            $.ajax({
                type: "POST",
                data: {id: $(this).attr("rel")},
                url: "/content/group/editDescription",
                success: function(html) {
                    $('#groupDescription').html(html);
                    // Whatever you want to do after the PHP Script returns.
                }
            });
        });
    });

</script>
