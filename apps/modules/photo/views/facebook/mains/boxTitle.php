<div class="uiBoxTitle">
    <div class="column-group">
        <div style="padding: 13px">
            <div class="large-60">
                <h2>Photos</h2>
            </div>
            <div class="large-40 push-right actionBox">
                <a href="#" class="button dialogAlbum"><span class="label">Create photo album</span></a>
            </div>
        </div>
    </div>
    <div class="column-group">
        <nav class="ink-navigation">
            <ul class="menu horizontal">
                <li><a href="/content/photo?user=<?php echo $this->f3->get('SESSION.username') ?>">Photos of you</a></li>
                <li><a href="/content/photo/album?user=<?php echo $user->data->username ?>">Albums</a></li>
            </ul>
        </nav>
    </div>
</div>