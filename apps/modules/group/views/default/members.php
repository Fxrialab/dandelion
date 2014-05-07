<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = $this->f3->get('group');
$f3 = require('groupBar.php');
$members = $this->f3->get('members');
$admin = $this->f3->get('admin');
$countMember = $this->f3->get('countMember');
?>

<div class="column-group">
    <div class="large-70">
        <div class="large-100">
            <div class="column-group">
                <div style ="padding:5px 0; margin-bottom: 10px">
                    <div class="large-30">
                        <select id="callbacks" onchange="window.location = jQuery('#callbacks option:selected').val();">
                            <option value="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>">All members (<?php echo $countMember ?>)</option>
                            <option value="/content/group/members?id=<?php echo str_replace(":", "_", $group->recordID) ?>&act=admin" <?php if ($admin == 'admin') echo 'selected' ?>>Admins</option>
                        </select>
                    </div>
                    <div class="large-70">
                        <div style ="padding-left: 20px;">
                            <nav class="ink-navigation">
                                <ul class="horizontal menu">
                                    <li>
                                        <form class="ink-form" action="" method="get">
                                            <div class="control-group">
                                                <input type="text" id="search" name="search" style="height: 30px">
                                            </div>
                                            <input type="hidden">
                                        </form>
                                    </li>
                                    <a style="float: right; margin:0 10px" rel="leanModal" class="ink-button" name="modalAddMember" href="#modalAddMember">Add people</a>
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
                <div class="large-30">
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
                                        <li><a action="removeGroup" rel="leanModalRemove" name="modalRemove" relID="<?php echo $user->recordID ?>" href="#modalRemove"> Remove as admin</a></li>
                                        <li><a href="#2">Leave Group</a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li><a class="makeAdmin" action="makeAdmin" rel="leanModal" name="modalMember" relID="<?php echo $user->recordID ?>" href="#modalMember">Make Admin</a></li>
                                        <li><a action="removeGroup" rel="leanModalRemove" name="modalRemove" relID="<?php echo $user->recordID ?>" href="#modalRemove"> Remove as admin</a></li>
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
    </div>
    <div class="large-30">
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
<div id="modalGroup">
    <div class="modalGroupHeader">
        <h2>Create group</h2>
    </div>
    <?php $f3 = require('form.php'); ?>
</div>
<div id="modalAddMember">
    <div class="modalGroupHeader">
        <h2>Add member</h2>
    </div>
    <?php $f3 = require('formMember.php'); ?>
</div>
<div id="modalMember">
    <div class="modalGroupHeader">
        <h2>Add Group Admin</h2>
    </div>
    <?php
    $f3 = require('formAddAdmin.php');
    ?>
</div>
<div id="modalRemove">
    <div class="modalGroupHeader">
        <h2>Remove</h2>
    </div>
    <?php
    $f3 = require('removeGroup.php');
    ?>
</div>

<script>

                            $('#callbacks').selectric();
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
