<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/22/13 - 8:44 AM
 * Project: joinShare Network - Version: 1.0
 */
$notifyAjaxs = F3::get('notifyAjax');

if ($notifyAjaxs)
{
    $notifyAjax = $notifyAjaxs[0];
    $actorName  = $notifyAjax['name'];
    $currentUser= $notifyAjax['currentUser'];
    $actorID    = $notifyAjax['actor'];
    $link       = $notifyAjax['link'];
    $content    = $notifyAjax['content'];
    $type       = $notifyAjax['type'];
    $text       = $notifyAjax['text'];
    $pfCommentActor = $notifyAjax['pfCommentActor'];
    $published  = $notifyAjax['published'];
    $currentUserName    = ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);
    $pfCommentActorName = ucfirst($pfCommentActor[$actorID]->data->firstName)." ".ucfirst($pfCommentActor[$actorID]->data->lastName);
?>
<ul class="flyoutItemList NewNotify">
    <li class="notification">
        <a class="notifyMainLink" href="/content/post/<?php echo $link; ?>">
            <div class="notifyBlock">
                <img class="notifyPhotoAuthor" src="<?php echo F3::get('BASE_URL'); ?><?php echo $pfCommentActor[$actorID]->data->profilePic; ?>" />
                <div class="notifyInfo">
                    <div class="notifyText">
                        <span class="blue Name">
                            <?php
                            //$check  = strpos($actorName, $currentUserName);
                            echo $actorName;
                            /*if ($check)
                            {
                                //$getNearLastAnswer  = substr($actorName, $check + 1);
                                $getLastAnswer      = str_replace($currentUserName, '', $actorName);
                                echo $pfCommentActorName.", ".$getLastAnswer;
                            }else {
                                echo $actorName;
                            }*/
                            ?>
                        </span>
                        <?php
                        $lengthComment = strlen($content);
                        $contentStatusDisplay = ($lengthComment > 40) ? str_replace(substr($content, 40), '...', $content) : $content;
                        ?>
                        <span class="label_text"> <?php echo $text." in ".$type; ?> </span>
                    </div>
                    <div id="contentNot"> <?php echo $content; ?></div>
                </div>
                <div class="notifyFooter swTimeComment" title="<?php echo $published;?>"></div>
            </div>
        </a>
    </li>
</ul>
<?php } ?>