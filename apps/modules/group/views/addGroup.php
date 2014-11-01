<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script>
    $(document).ready(function() {

        $('#groupSuccess').scrollLoadGroup({
            nop: 5, // The number of posts per scroll to be loaded
            offset: 0, // Initial offset, begins at 0 in this case
            error: 'No More Group!', // When the user reaches the end this is the message that is
            // displayed. You can change this if you want.
            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
            // This is mainly for usability concerns. You can alter this as you see fit
            scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
                    // but will still load if the user clicks.

        });

    });
</script>


<div class="uiMainColProfile large-100" id="groupSuccess">

</div>
