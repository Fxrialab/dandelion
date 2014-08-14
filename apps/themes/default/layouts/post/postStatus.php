<?php
$status = F3::get('status');
$user = F3::get('user');
$image = F3::get('image');
$like = false;
$rand = rand(100, 100000);
ViewHtml::render('post/viewPost', array('status' => $status, 'user' => $user, 'image' => $image, 'like' => $like));
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".oembed<?php echo $rand; ?>").oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 768,
                    autoplay: false
                }
        );
    });
</script>