<div class="uiBoxTitle">
    <div class="column-group">
        <div style="padding: 13px">
            <div class="large-60 ">
                <h2>Photos</h2>
            </div>
            <div class="large-30">
                <a href="#" class="button dialogAlbum"><span class="label">Greate album</span></a>
                <a href="#" class="button"><span class="label">Add video</span></a>
            </div>
            <div class="label-10">
                <a href="#" class="button"><span class="icon icon145"></span></a>
            </div>
        </div>
    </div>
    <div class="column-group">
        <nav class="ink-navigation">
            <ul class="menu horizontal">
                <li><a href="/content/photo?user=<?php echo F3::get('SESSION.username') ?>">Photos of you</a></li>
                <li><a href="/content/photo/myAlbum?user=<?php echo F3::get('SESSION.username') ?>">Albums</a></li>
                <li><a href="">Not Tagged</a></li>
            </ul>
        </nav>
    </div>
</div>