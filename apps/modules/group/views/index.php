<div class="tab-bar-group _box">
    <div class="column-group">
        <div class="large-80">
            <nav class="ink-navigation">
                <ul class="horizontal menu">
                    <li class="_f14"><a href="#">Suggested Groups</a></li>
                    <li class="_f14"><a href="#">Friends Groups</a></li>
                    <li class="_f14"><a href="/content/group?category=nearby">Nearby Groups</a></li>
                    <li class="_f14"><a href="/content/group?category=membership">Your Groups</a></li>
                    <li class="_f14"><a href="/content/group?category=admin">Groups You Admin</a></li>
                </ul>
            </nav>
        </div>
        <div class="large-20 _fr" style="margin-top: 5px;">
            <a class="button popup active" rel="Greate New Group" title="Greate Group" href="/content/group/create"><i class="fa fa-plus"></i>Create Group</a>
        </div>

    </div>
</div>

<div class="large-100 _box">
    <input type="hidden" id="roleGroup" value="<?php echo $this->f3->get('role') ?>">
    <div class="_box_t _fw">
            <?php
            if ($this->f3->get('role') == 'admin')
                echo 'ADMIN GROUPS';
            else
                echo 'MEMBERSHIP GROUPS';
            ?>
    </div>
    <div id="viewGroup" >

    </div>
</div>
<script>
    $(document).ready(function () {
        $('#viewGroup').scrollPaginationGroup({
            nop: 20,
            offset: 0,
            error: '',
            delay: 500,
            scroll: true
        });
    });

</script>