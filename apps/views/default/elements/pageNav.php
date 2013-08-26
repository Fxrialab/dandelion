<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/5/13 - 9:28 AM
 * Project: joinShare Network - Version: 1.0
 */
?>
<div class="navPages">
    <span>
        <ul class="navigation">
            <li class="link active"><a href="/content/myPost">My Post</a></li>
            <li class="link"><a href="/info">About</a></li>
            <li class="link"><a id="photos" href="/content/myPhoto">My Photo</a></li>
            <li class="link"><a href="/content/myQandA">My Q&A</a></li>
            <!--<li class="link"><a href="/content/group">Group</a></li>-->
        </ul>
    </span>
    <span>
        <div id="viewProfileAs">
            <a href="">View profile as</a>
            <span class="moreBtn"></span>
        </div>
    </span>
</div>
<script type="text/javascript">
    $('.link a').click( function() {
        $('.navigation li').removeClass('active');
        $(this).parent().addClass('active');
    });
</script>