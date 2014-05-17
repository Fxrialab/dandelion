<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style>
    .scrollBar{
        overflow: -moz-scrollbars-vertical; 
        overflow-y: scroll;
    }
</style>
<script>
    $(document).ready(function() {

//        $('#viewGroup').scrollPaginationGroup({
//            nop: 20, // The number of posts per scroll to be loaded
//            offset: 0, // Initial offset, begins at 0 in this case
//            error: 'No More Group!', // When the user reaches the end this is the message that is
//            // displayed. You can change this if you want.
//            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
//            // This is mainly for usability concerns. You can alter this as you see fit
//            scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
//                    // but will still load if the user clicks.
//
//        });
        $('#typeActivity').html('<input type=hidden id=type name=type value=post >');
    });

</script>
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
        <div class="large-20">
            <a title="Create Group" class="button" id="createGroup" href="/content/group/create"><span class="icon icon3"></span><span class="label">Create Group</span></a>
        </div>

    </div>
</div>

<div class="uiMainColProfile large-100">
    <div id="viewGroup">
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
