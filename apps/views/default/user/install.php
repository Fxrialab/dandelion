<div class="control-group uiCreateDB large-80 push-center">
    <p class="ink-alert basic info"><?php echo $msgNotice; ?></p>
    <?php
    if ($msgNotice && $flag == '2')
    {
    ?>
    <form action="/installDB" class="ink-form" method="post">
        <fieldset>
            <div class="control-group large-100">
                <label for="text-input" class="fontSize-18">Database Name</label>
                <div class="control">
                    <input id="text-input" type="text" name="dbName" placeholder="Please input database name">
                </div>
                <div class="control large-10 fixMarginTop-10">
                    <input id="createDB" class="uiMediumButton orange" type="submit" value="Create">
                </div>
            </div>
        </fieldset>
    </form>
    <?php
    }
    ?>
</div>