<div class="large-100">
    <div class="topBarGroup _box">
        <div class="column-group">
            <div class="large-65">
                <nav class="ink-navigation">
                    <ul class="horizontal menu">
                        <li><a href="/content/group/groupdetail?id=<?php echo $this->getId($data['group']->recordID) ?>"><?php echo $data['group']->data->name ?></a></li>
                        <li><a href="/content/group/members?id=<?php echo $this->getId($data['group']->recordID) ?>&act=membership">Members</a></li>
                        <li><a href="#">Event</a></li>
                        <li><a href="#">Photo</a></li>
                    </ul>
                </nav>
            </div>


        </div>
    </div>
</div>