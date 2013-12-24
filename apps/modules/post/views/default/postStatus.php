<?php
$currentUser        = $this->f3->get('currentUser');
$content            = $this->f3->get('content');
$friendProfileInfo  = $this->f3->get('friendProfileInfo');
$tagged             = $this->f3->get('tagged');
$published          = $this->f3->get('published');
$statusID           = str_replace( ":" , "_", $this->f3->get('statusID'));
$rand               = rand(100,100000);

$currentUserID      = $currentUser->recordID;
$friendProfileID    = $this->f3->get('friendProfileID');
$currentUserName    = ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);
$friendName         = ucfirst($friendProfileInfo->data->firstName)." ".ucfirst($friendProfileInfo->data->lastName);
?>
<script type="text/javascript">
    //append video tagged after post status by ajax
    $(document).ready(function(){
        $('.taPostComment').autosize();
        $(".oembed<?php echo $rand ?>").oembed(null,
        {
            embedMethod: "append",
            maxWidth: 1024,
            maxHeight: 768,
            autoplay: false
        });
        $(".submitComment").bind('keypress',function(e){
            var code = e.keyCode || e.which;
            if(code == 13)
            {
                var statusID= $(this).attr('id').replace('textComment-','');
                var comment = $("#textComment-"+statusID).val();
                console.log('cm: ',comment);
                if (comment == '')
                {
                    return false;
                }else {
                    var url, urlString, urlSpace, urlHttp, urlFirst,fullURL;
                    var text = $('#textComment-'+statusID).val();
                    text = $('<span>'+text+'</span>').text(); //strip html
                    urlHttp = text.indexOf('http');
                    if(urlHttp >=0)
                    {
                        urlString = text.substr(urlHttp);
                        urlSpace = urlString.indexOf(" ");
                        if(urlSpace >=0)
                        {
                            urlFirst = text.substr(urlHttp,urlSpace);
                            if(isValidURL(urlFirst))
                            {
                                fullURL = url = urlFirst;
                            }
                        } else {
                            if(isValidURL(urlString))
                            {
                                fullURL = url = urlString;
                            }
                        }
                    }
                    $('#fmComment-'+statusID).append("<input id='fullURL' name='fullURL' type='hidden' value="+ fullURL+ ">") ;
                    $.ajax({
                        type: "POST",
                        url: "/content/post/postComment",
                        data: $('#fmComment-'+statusID).serialize(),
                        cache: false,
                        success: function(html){
                            $("#commentBox-"+statusID).before(html);
                            $("#textComment-"+statusID).val('');
                        }
                    });
                }
            }
            //return false;
        });
    })
</script>
<div class="uiBoxPostItem">
    <div class="uiBoxPostContainer column-group">
        <div class="large-10 uiActorPicCol">
            <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
        </div>
        <div class="large-85 uiPostContent">
            <div class="articleActorName fixMarginBottom-5">
                <?php if($friendProfileID && $currentUserID != $friendProfileID){ ?>
                    <a class="timeLineLink" href="#"><?php echo $currentUserName;?></a> was posted in wall of <a class="timeLineLink" href=""><?php  echo $friendName; ?></a>
                <?php } else { ?>
                    <a class="timeLineLink" href="#"><?php echo $currentUserName; ?></a>
                <?php } ?>
            </div>
            <div class="articleContentWrapper">
                <?php
                if($tagged =='none')
                {?>
                    <div class="textPostContainer fixMarginBottom-5">
                        <span class="textPost"><?php echo $content; ?></span>
                    </div>
                <?php
                }else {  ?>
                    <div class="textPostContainer fixMarginBottom-5">
                        <span class="textPost">
                            <?php echo substr($content,0,strpos($content,'_linkWith_')); ?>
                            <a href="<?php echo $tagged; ?>"><?php echo $tagged; ?></a>
                            <?php echo substr($content,strpos($content,'_linkWith_')+10); ?>
                            <a href="<?php echo $tagged; ?>" class="oembed<?php echo $rand ?>"></a>
                        </span>
                    </div>
                <?php
                } ?>
            </div>
            <div class="articleSelectOption">
                <div class="articleActions">
                    <nav class="ink-navigation">
                        <ul class="menu horizontal">
                            <!--Like Segments-->
                            <li>
                                <a class="likePostStatus" id="likeLinkID-<?php echo $statusID; ?>" name="likeStatus-null" title="Like post"></a>
                                <form class="likeHidden" id="likeHiddenID-<?php echo $statusID; ?>">
                                    <input type="hidden" name="id" value="<?php echo substr($currentUserID, strpos($currentUserID, ':') + 1); ?>">
                                    <input type="hidden" name="statusID" value="<?php echo $statusID; ?>">
                                </form>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <!--Comment Segments-->
                            <li>
                                <a href="#" class="commentBtn" id="stream-<?php echo $statusID;?>" title="Comment to post">Comment</a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <!--Share Segments-->
                            <li>
                                <a class="shareStatus" onclick="ShareStatus('<?php echo $statusID; ?>')" title="Share">Share</a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $published; ?>"></a></li>
                            <!----article post counter---->
                            <li class="rightFix">
                                <span>
                                    <a href="#" class="likeCounter gapArticleActions" title="Like"><i class="statusCounterIcon-like"></i>6</a>
                                    <a href="#" class="commentCounter gapArticleActions" title="Comment"><i class="statusCounterIcon-comment"></i>20</a>
                                    <a href="#" class="shareCounter gapArticleActions" title="Share"><i class="statusCounterIcon-share"></i>3</a>
                                    <a href="#" class="followPostCounter gapArticleActions" title="Follow Post"><i class="statusCounterIcon-followPost"></i>11</a>
                                </span>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="postActionWrapper uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $statusID; ?>">
                    <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $statusID?>">
                        <div class="large-10 uiActorCommentPicCol">
                            <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                        </div>
                        <div class="large-90 uiTextCommentArea">
                            <form class="ink-form" id="fmComment-<?php echo $statusID?>">
                                <fieldset>
                                    <div class="control-group">
                                        <div class="control">
                                            <input name="postID" type="hidden" value="<?php echo $statusID?>" />
                                            <textarea name="comment" class="taPostComment submitComment" id="textComment-<?php echo $statusID?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-5 uiPostOption">
            <a href="" class="postOption" data-action=".optionPopUp"><i class="optionIcon-articlePost"></i></a>
            <div class="uiPostOptionPopUpOver uiBox-PopUp topRightArrow" data-target=".optionPopUp">
                <nav class="ink-navigation">
                    <ul class="menu vertical">
                        <li><a class="test" href="#">Report this post</a></li>
                        <li><a href="#">Option 1</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
