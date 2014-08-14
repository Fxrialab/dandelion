<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$user = F3::get('user');
?>
<nav class="ink-navigation uiTimeLineHeadLine">
    <ul class="menu horizontal">
        <li><a href="/content/user?user=<?php echo $user->data->username ?>">TimeLine</a></li>
        <li><a href="/about?user=<?php echo $user->data->username ?>">About</a></li>
        <li><a href="/friends?user=<?php echo $user->data->username ?>">Friends</a></li>
        <li><a href="/content/photo?user=<?php echo $user->data->username ?>">Photos</a></li>
        <li><a href="#">More</a></li>
    </ul>
</nav>