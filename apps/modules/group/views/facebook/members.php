<?php
$group = $this->f3->get('group');
$groupName = $group->data->name;
$members = $this->f3->get('members');
$admin = $this->f3->get('admin');
$countMember = $this->f3->get('countMember');
$countAdmin = $this->f3->get('countAdmin');
?>
<?php $f3 = require('coverPhotoGroup.php'); ?>
<?php $f3 = require('groupBar.php'); ?>
<div class="uiMainColProfile uiMainContainer">
    <div class="column-group">
        <div class="large-70" style="padding-right: 20px">
            <div class="large-100">
                <div class="column-group">
                    <div style ="padding:10px 0 40px; margin-bottom: 10px">
                        <div class="large-25 tiptip">
                            <?php
                            if (($admin) == 'admin')
                                $act = 'Admins (' . $countAdmin . ')';
                            else
                                $act = 'All members (' . $countMember . ')';
                            ?>
                            <div class="dropdown">
                                <a title="<?php echo $act ?>" class="button"><span class="label"><?php echo $act ?></span></a>
                                <div class="dropdown-slider left w150">
                                    <a class="ddm" href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=membership"><span class="icon <?php
                                        if ($admin == 'membership')
                                            echo ' icon43';
                                        else
                                            echo 'icon0';
                                        ?> "></span><span class="label">All members (<?php echo $countMember ?>)</span></a>
                                    <a class="ddm" href="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=admin"><span class="icon <?php
                                        if ($admin == 'admin')
                                            echo ' icon43';
                                        else
                                            echo 'icon0';
                                        ?>"></span><span class="label">Admins (<?php echo $countAdmin ?>)</span></a>
                                </div> <!-- /.dropdown-slider -->
                            </div> <!-- /.dropdown -->

                        </div>
                        <div class="large-75">
                            <div style ="padding-left: 20px;">
                                <nav class="ink-navigation">
                                    <ul class="horizontal">
                                        <li class="large-60">
                                            <form class="ink-form" action="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=<?php echo $admin ?>" method="post">
                                                <div class="control-group">
                                                    <input type="text" id="search" name="search" style="height: 30px">
                                                </div>
                                                <input type="hidden">
                                            </form>
                                        </li>
                                        <li class="large-40 tiptip">
                                            <a rel="<?php echo str_replace(":", "_", $group->recordID) ?>" class="button" title="Add People to Group" id="addMember" href="/content/group/ajax/addFriend"><span class="icon icon3"></span><span class="label">Add people</span></a>
                                        </li>
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
                    if (!empty($value->data->member))
                    {
                        $userID = $value->data->member;
                        $role = $value->data->role;
                        $action = $value->data->action;
                    }
                    else
                    {
                        $userID = $value->member;
                        $role = $value->role;
                        $action = $value->action;
                    }
                    $user = GroupController::findUser($userID);
                    $fullName = ucfirst($user->data->firstName)." ".ucfirst($user->data->lastName);
                    if ($user->data->profilePic != 'none')
                    {
                        $photo = HelperController::findPhoto($user->data->profilePic);
                        $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
                    }else {
                        $gender = HelperController::findGender($user->recordID);
                        if ($gender =='male')
                            $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                        else
                            $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
                    }
                    ?>
                    <div class="large-30" id="user_<?php echo str_replace(":", "_", $user->recordID) ?>">
                        <div class="large-35">
                            <a href="/content/myPost?username=<?php echo $user->data->username ?>">
                                <img src="<?php echo $profilePic; ?>" width="50" height="50">
                            </a>
                        </div>
                        <div class="large-65">
                            <div class="userItem">
                                <a class="fullName" href="/content/post?user=<?php echo $user->data->username ?>"><?php echo $fullName; ?></a>
                                <div class="tiptip action">
                                    <div class="dropdown">
                                        <a class="button" title="Setting"><span class="icon icon96"></span></a>
                                        <div class="dropdown-slider left w120">
                                            <?php
                                            if ($action == 0)
                                            {
                                                ?>
                                                <a rel="<?php echo $user->recordID ?>" title="Remove as admin" class="removeGroup ddm" href="/content/group/ajax/removeAdmin"><span class="label"> Remove as admin</span></a>
                                                <a id="leaveGroup" class="ddm" rel="<?php echo str_replace(":", "_", $group->recordID) ?>" href="/content/group/leave" title="<?php echo $groupName ?>"><span class="label"> Leave Group</span></a>
                                            <?php
                                            }
                                            else
                                            {
                                                if ($role == 'admin')
                                                {
                                                    ?>
                                                    <a class="roleGroup ddm" rel="<?php echo $user->recordID ?>" title="Remove as admin" href="/content/group/ajax/rolegroup"><span class="label"> Remove as admin</span></a>
                                                <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a class="roleGroup ddm" rel="<?php echo $user->recordID ?>" title="Add Group Admin" href="/content/group/ajax/rolegroup"><span class="label"> Make Admin</span></a>
                                                <?php } ?>
                                                <a rel="<?php echo $user->recordID ?>" title="Remove" role="remove" class="removeGroup ddm" href="/content/group/ajax/removeGroup"><span class="label">  Remove as group</span></a>
                                            <?php } ?>

                                        </div> <!-- /.dropdown-slider -->
                                    </div> <!-- /.dropdown -->
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
        <div class="large-30 uiRightCol">
            <?php $f3 = require('rightColGroup.php'); ?>
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
