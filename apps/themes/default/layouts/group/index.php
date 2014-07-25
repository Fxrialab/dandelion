<div style ="padding:5px; border: 1px solid #ccc; margin-bottom: 10px">
    <div class="column-group">
        <div class="large-85">
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
        <div class="large-15 tiptip">
            <a class="button" rel="Greate New Group" title="Greate Group" id="createGroup" href="/content/group/create">Create Group</a>
        </div>

    </div>
</div>

<div class="uiMainColProfile groupWrapper large-100">
    <input type="hidden" id="roleGroup" value="">
    <div style="padding: 10px 15px; background-color: #ddd;">
        <h5> 
            <?php
            if ($role == 'admin')
                echo 'ADMIN GROUPS';
            else
                echo 'MEMBERSHIP GROUPS';
            ?>
        </h5>
    </div>
    <div id="viewGroup">

    </div>
    <script>

        $(document).ready(function() {
            $('#viewGroup').scrollPaginationGroup({
                nop: 20,
                offset: 0,
                error: '',
                delay: 500,
                scroll: true
            });
        });

    </script>
