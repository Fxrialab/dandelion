<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$user = F3::get('user');
?>
<div class="ink-grid">
    <div class="column-group">
        <h1 style="text-align: center; margin-bottom: 30px">Likes</h1>
        <?php
        foreach ($user as $value)
        {
            ?>
            <div class="large-20">
                <div class="post profile">
                    <a href="user?user=<?php echo $value->data->username ?>&type=like">
                        <h5><?php echo $value->data->fullName ?></h5>
                        <p>
                            <span>320 post</span> . <span>320 follower</span>
                        </p>

                        <div class="large-50">
                            <div class="thumbMax"></div>
                        </div>
                        <div class="large-50">
                            <div class="thumbLeft"></div>
                            <div class="thumbRight"></div>
                            <div class="thumbLeft"></div>
                            <div class="thumbRight"></div>
                        </div>
                        <a class="ink-button large-100" style="margin-left: 0px">Follow</a>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>