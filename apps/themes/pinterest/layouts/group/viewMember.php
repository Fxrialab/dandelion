<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$members = F3::get('members');
?>
<nav class="ink-navigation">
    <ul class="member">
        <?php
        foreach ($members as $value)
        {
            ?>
            <li>
                <?php
                if ($value->mess = TRUE)
                {
                    ?>
                    <?php echo $value->name ?> (Da tham gia)
                    <?php
                }
                else
                {
                    ?>
                    <?php echo $value->name ?>(Da duoc them)
                <?php }
                ?>
            </li>
        <?php }
        ?>

    </ul>
</nav>