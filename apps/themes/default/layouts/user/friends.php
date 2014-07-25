<script>
    $(document).ready(function() {
        $('#scrollFriends').scrollPaginationFriend({
            nop: 20, // The number of posts per scroll to be loaded
            offset: 0, // Initial offset, begins at 0 in this case
            error: '', // When the user reaches the end this is the message that is
            // displayed. You can change this if you want.
            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
            // This is mainly for usability concerns. You can alter this as you see fit
            scroll: true // The main bit, if set to false posts will not load as the user scrolls.
                    // but will still load if the user clicks.
        });
    });

</script>

<input type="hidden" id="userID" name="userID" value="<?php echo $user->recordID ?>">
<div class="arrow_timeLineMenuNav">
    <div class="arrow_timeLine" style="left: 19%"></div>
</div>


<div class="uiMainColAbout">

    <div class="uiPhotoWrapper">
        <div class="uiBoxTitle">
            <div class="column-group">
                <div style="padding: 13px">
                    <div class="large-60 ">
                        <h2>Friends</h2>
                    </div>
                    <div class="large-35">
                        <a href="#" class="button dialogAlbum">Friends Requests</span></a>
                        <a href="#" class="button icon add"><span class="label">Find Friends</span></a>
                    </div>
                    <div class="large-5 ">
                        <a data-dropdown="#dropdown-setting-friend" class="button icon edit"></a>
                        <div id="dropdown-setting-friend" class="dropdown dropdown-tip dropdown-anchor-right">
                            <ul class="dropdown-menu"> 
                                <li><a href="#">Mange Sections</a></li>
                                <li><a href="#">Edit privacy</a></li></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column-group">
                <div class="large-75">
                    <div style="margin-top: 15px;">
                        <nav class="ink-navigation">
                            <ul class="menu horizontal">
                                <li><a href="/content/friends?user=<?php echo $username ?>&f=friend_all">All friends (2)</a></li>
                                <li><a href="/content/friends?user=<?php echo $username ?>&f=friend_recent">Recently Added</a></li>
                                <li><a href="/content/friends?user=<?php echo $username ?>&f=following">Following</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="large-25">
                    <div style="margin-top: 10px; margin-right: 12px;">
                        <form class="ink-form">
                            <div class="control-group">
                                <div class="control">
                                    <input type="text" name="search" id="searchFriend" placeholder="Search friends?">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow_firend_all"></div>
        <div class="column-group">
            <div class="photoAll" id="scrollFriends">

            </div>
        </div>
    </div>
    <script>
        $('#searchFriend').keyup(function() {
            var key = $(this).val();
            var userID = $("#userID").val();
            $.ajax({
                type: "POST",
                data: {key: key, userID: userID},
                url: "/searchFriend",
                success: function(data) {
                    $('#scrollFriends').html(data);
                }

            });
        });
    </script>