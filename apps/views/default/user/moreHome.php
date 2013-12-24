<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 3:01 PM
 * Project: joinShare Network - Version: 1.0
 */

if($activities){
    foreach($activities  as $mod){
        //var_dump($mod);
        foreach(glob(MODULES.$mod['type'].'/views/default/more.php') as $views){
            require $views;
        }
    }
}
?>
<!--<script type="text/javascript">
    $(document).ready(function(){
        $(".oembed4").oembed(null,
            {
                embedMethod: "append",
                maxWidth: 1024,
                maxHeight: 768,
                autoplay: false
            });
    })
</script>-->