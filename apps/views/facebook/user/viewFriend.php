
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($friends as $k => $value)
{
    ?>
    <div class="large-50">
        <div style="border: 1px solid #ccc; margin: 10px; position: relative">
            <?php
            if ($value['avatar'] != 'none')
            {
                ?>
                <img  style="width: 100px" src="<?php echo UPLOAD_URL ?>avatar/170px/<?php echo $value['avatar'] ?>">
                <?php
            }
            else
            {
                ?>
                <img  style="width: 100px"  src="<?php echo UPLOAD_URL ?>avatar/170px/avatarMenDefault.png">
                <?php
            }
            ?>
            <a style="position: absolute; top: 30px; left: 110px; font-weight: bold; font-size: 14px"><?php echo $value['fullName'] ?></a>
            <span style="position: absolute; top: 50px; left: 110px;">123 friends</span>

            <div style="position: absolute; top: 35px; right: 10px; margin: 0;">
                <div class="friendButton">
                    <div>
                        <div class="button icon approve"><span class="label">Friends</span></div>
                        <div class="info">
                            <nav class="ink-navigation">
                                <ul class="menu vertical menu_arrow shadow">
                                    <div class="arrow_menu" style="left: 50%"></div>
                                    <li><a href="#">Get Notifications</a></li>
                                    <li><a href="#">Close Friends</a></li>
                                    <li><a href="#">Suguest</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
