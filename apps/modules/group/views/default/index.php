<div style ="padding:5px; border: 1px solid #ccc; margin-bottom: 10px">
    <div class="column-group">
        <div class="large-80">
            <nav class="ink-navigation">
                <ul class="horizontal menu">
                    <li><a href="#">Suggested Groups</a></li>
                    <li><a href="#">Friends Groups</a></li>
                    <li><a href="/content/group?category=nearby">Nearby Groups</a></li>
                    <li><a href="/content/group?category=membership">Your Groups</a></li>
                    <li><a href="/content/group?category=admin">Groups You Admin</a></li>
                </ul>
            </nav>
        </div>
        <div class="large-20 tiptip">
            <a title="Create Group" class="button" id="createGroup" href="/content/group/create"><span class="icon icon3"></span><span class="label">Create Group</span></a>
        </div>

    </div>
</div>

<div class="uiMainColProfile groupWrapper large-100">
    <div id="viewGroup" class="viewMoreGroups">
        <?php
        if ($this->f3->get('groupMember') != 'null')
        {
            foreach ($this->f3->get('groupMember') as $key => $value)
            {
                $f3 = require('viewGroup.php');
            }
        }
        ?>
    </div>
</div>
