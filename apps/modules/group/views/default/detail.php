<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = $this->f3->get('group');
?>
<script>
    $(document).ready(function() {

        $('#contentContainer').scrollPagination({
            nop: 5, // The number of posts per scroll to be loaded
            offset: 0, // Initial offset, begins at 0 in this case
            error: 'No More Posts!', // When the user reaches the end this is the message that is
            // displayed. You can change this if you want.
            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
            // This is mainly for usability concerns. You can alter this as you see fit
            scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
                    // but will still load if the user clicks.

        });

    });
    $(document).ready(function() {
        $('#typeActivity').html('<input type=hidden id=type name=type value=group >');
        $('#typeActivityID').html('<input type=hidden id=typeID name=typeID value=<?php echo $group->recordID ?>>');
    })
</script>
<div id="modalGroup">
    <div class="modalGroupHeader">
        <h2>Create group</h2>
    </div>
    <?php $f3 = require('form.php'); ?>
</div>
<?php $f3 = require('groupBar.php'); ?>
<div class="uiMainColProfile large-80">
    <?php
    FactoryUtils::element('formPost', array('module' => 'post'));
    ?>
    <input type="hidden" id="type" name="type" value="group">
    <input type="hidden" id="typeID" name="typeID" value="<?php echo $group->recordID ?>">

    <div id="contentContainer">

    </div> 

</div>
