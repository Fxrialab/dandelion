<div id="topBar">
    <div class="ink-grid">
        <div class="column-group">
            <div class="large-5" style="position: relative">
                <a data-dropdown="#dropdown-category" href="#" class="ink-button link-button">|||</a>
                <div id="dropdown-category" class="dropdown dropdown-tip">
                    <ul class="dropdown-menu menu">
                        <li><a href="javascript:void(0)" class="postModal">Category 1</a></li>
                    </ul>
                </div>
            </div>
            <div class="large-10">
                <form class="ink-form">
                    <input type="text" name="search" style="height: 30px; margin-top: 5px">
                </form>
            </div>
            <div class="large-70">
                <div style="text-align: center; "><a href="/" style="color: #fff"><h4>Dandelion</h4></a></div>
            </div>
            <div class="large-5" style="position: relative">
                <a data-dropdown="#dropdown-action" href="#" class="ink-button link-button">+</a>
                <div id="dropdown-action" class="dropdown dropdown-tip">
                    <ul class="dropdown-menu menu">
                        <li><a href="javascript:void(0)" class="postModal">Upload Post</a></li>
                        <li><a id="createGroup" href="/content/group/create">Greate Group</a></li>
                    </ul>
                </div>
            </div>
            <div class="large-10">
                <a data-dropdown="#dropdown-profile" href="#" class="ink-button link-button"><?php echo F3::get('SESSION.fullname') ?></a>
                <div id="dropdown-profile" class="dropdown dropdown-tip dropdown-anchor-right">
                    <ul class="dropdown-menu menu">
                        <li><a href="/user?user=<?php echo F3::get('SESSION.username') ?>">Your Profile and Pins</a></li>
                        <li><a href="/settings">Settings</a></li>
                        <li><a href="/friend">Friend</a></li>
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>