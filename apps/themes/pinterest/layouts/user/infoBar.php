<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$user = F3::get('user');
$countPost = F3::get('countPost');
$countLike = F3::get('countLike');
$countGroup = F3::get('countGroup');
?>
<div class="ink-grid">
    <div style="background-color: #fff; margin: 20px 25px; border-radius: 5px;  box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
        <div style="padding:10px 20px; border-bottom: 1px solid #ddd">
            <div class="column-group">

                <div class="large-90">
                    <h1><?php echo $user->data->fullName ?></h1>
                </div>
                <div class="large-10"><a href="#" class="ink-button">Follow</a></div>
            </div>
        </div>
        <div class="column-group">
            <div class="large-100">
                <nav class="ink-navigation">
                    <ul class="menu horizontal tabs">
                        <li class="large-20"><a href="user?user=<?php echo $user->data->username ?>&type=board"><?php echo $countGroup ?> Board</a></li>
                        <li class="large-20"><a href="user?user=<?php echo $user->data->username ?>&type=post"><?php echo $countPost ?> Post</a></li>
                        <li class="large-20"><a href="user?user=<?php echo $user->data->username ?>&type=like"><?php echo $countLike ?> Like</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>