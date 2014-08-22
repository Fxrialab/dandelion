
    <?php

    $msg = F3::get('msg');
    if ($msg == 'login')
        ViewHtml::render('user/login');
    else
        ViewHtml::render('user/signUp');
    ?>
