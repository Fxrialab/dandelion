<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = $this->f3->get('group');
if (!empty($group))
{
    foreach ($group as $key => $value)
    {
        ?>
        <div class="column-group">
            <div style ="padding:10px 5px; border-bottom: 1px solid #ccc;">
                <a href="#"><?php echo $value->data->name; ?></a>
                <div id="joinGroup-<?php echo str_replace(":", "_", $value->recordID) ?>"><a href="javascript:void(0)" class="joinGroup" style="float: right" rel="<?php echo str_replace(":", "_", $value->recordID) ?>">Join</a></div>
            </div>
        </div>
        <?php
    }
}
?>
<script>
    $("body").on("click", ".joinGroup", function(e) {
        e.preventDefault();
        var id = $(this).attr("rel");
        $.ajax({
            type: "POST",
            url: "/content/group/joinGroup",
            data: {id: id},
            cache: false,
            success: function(data) {
//             var obj = jQuery.parseJSON(data);
                if (data == 1) {
                    $('#joinGroup-' + id).html('Da tham gia');
                }

            }
        })
    });

</script>