<li class="large-50 medium-100 small-100">
    <div class="friendItemWrapper column-group">
        <a class="large-30 medium-60 small-100" href="">
            <img src="<?php echo $avatar; ?>">
        </a>
        <div class="large-40 medium-80 small-100 infoFriends">
            <p class="fontSize-14"><a href="/content/myPost?username=<?php echo $username; ?>"><?php echo $fullName; ?></a></p>
            <?php
            if (!empty($numberFriends))
            {
                ?>
                <span><a class="fixcolor-adabab" href=""><?php echo $numberFriends; ?> friends</a></span>
                <?php
            }
            ?>
        </div>
        <div class="large-30 medium-60 small-100 actionFriends">
            <?php
            if ($statusFriendsShip == 'request' || $statusFriendsShip == 'later' || $statusFriendsShip == 'addFriend')
            {
                if ($statusFriendsShip == 'request' || $statusFriendsShip == 'later')
                {
                    ?>
                    <a class="requestFriend uiSmallButton orange linkHover-fffff">Friend Request Sent</a>
                    <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                        <nav class="ink-navigation">
                            <ul class="menu vertical">
                                <li><a>Report/Block</a></li>
                                <li><a class="cancelRequestFriend" id="<?php echo $rpFriendsID; ?>">Cancel Request</a></li>
                            </ul>
                        </nav>
                    </div>
                    <?php
                }
                else
                {
                    if ($currentUser->recordID != $friend)
                    {
                        ?>
                        <a class="addFriend uiSmallButton orange linkHover-fffff" id="<?php echo $rpFriendsID; ?>">Add Friend</a>
                        <?php
                    }
                }
            }
            elseif ($statusFriendsShip == 'respondRequest')
            {
                ?>
                <a class="respondFriendRequest uiSmallButton orange linkHover-fffff">Respond to Friend Request</a>
                <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                    <nav class="ink-navigation">
                        <ul class="menu vertical">
                            <li><a class="confirmFriend" id="<?php echo $rpFriendsID; ?>">Confirm Friend</a></li>
                            <li><a class="cancelRequestFriend" id="<?php echo $rpFriendsID; ?>">Unaccept Request</a></li>
                        </ul>
                    </nav>
                </div>
                <?php
            }
            else
            {
                ?>
                <a class="isFriend uiSmallButton orange linkHover-fffff">Friend</a>
                <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                    <nav class="ink-navigation">
                        <ul class="menu vertical">
                            <li><a>Report/Block</a></li>
                            <li><a class="cancelRequestFriend" id="<?php echo $rpFriendsID; ?>">Unfriend</a></li>
                        </ul>
                    </nav>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</li>


////////////////////////////////////////////
<div class="column-group">
    <div class="large-80 medium-100 small-100 push-center lineStroke overflowStyle">
        <div class="column-group">
            <div class="large-65 push-center fixMarginBottom-5">
                <a id="uiLogInLink" class="uiTabNav linkColor-9aa9c8 fontSize-18 activeLink" name="uiLogInBox">Log In</a>
                <span class="linkStyles fontSize18"> | </span>
                <a id="uiSignUpLink" class="uiTabNav linkColor-9aa9c8 fontSize-18" name="uiSignUpBox">Sign Up</a>
            </div>
        </div>
    </div>
</div>
<div class="column-group">
    <div class="large-60 medium-100 small-100 push-center">
        <div class="column-group">
            <div class="large-50 medium-100 small-100">
                <div id="uiLogInBox" class="box uiContent large-80 medium-100 small-100">
                    <form class="ink-form fixMarginTop-10" method="post" action="/login" id="fmLogIn">
                        <fieldset>
                            <div class="control-group">
                                <div class="control">
                                    <input type="text" placeholder="Your Email" name="emailLogIn" id="emailLogIn">
                                </div>
                            </div>
                            <div class="uiRememberMeElement fixMarginBottom-5">
                                <div class="control">
                                    <input id="cbRememberMe" class="cbRememberMe" type="checkbox" name="persistent" value="1">
                                    <label for="cbRememberMe" class="linkColor-9aa9c8">Remember Me</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control">
                                    <input type="password" placeholder="Your Password" name="pwLogIn" id="pwLogIn">
                                </div>
                            </div>
                            <div class="column-group">
                                <div class="large-70 medium-100 small-100">
                                    <a class="linkColor-9aa9c8" href="/forgotPassword">Forgot Password</a>
                                </div>
                                <div class="large-30 medium-80 small-100">
                                    <input type="submit" class="uiMediumButton orange" id="smLogIn" name="smLogIn" value="Log In">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div id="uiSignUpBox" class="box uiContent large-100 medium-100 small-100" style="display: none">
                    <h3 class="fixColor-fffff fontSize-18"><b>New to Dandelion</b>? Sign Up Now</h3>
                    <form class="ink-form" method="post" action="/signUp" id="fmSignUp">
                        <fieldset>
                            <div class="control-group">
                                <div class="column-group">
                                    <div class="control large-45">
                                        <input id="firstNameSignUp" type="text" name="firstName" placeholder="First Name">
                                    </div>
                                    <div class="control large-50 push-right">
                                        <input id="lastNameSignUp" type="text" name="lastName" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control">
                                    <input id="emailSignUp" type="text" name="emailSignUp" placeholder="Email">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control">
                                    <input id="pwSignUp" type="password" name="pwSignUp" placeholder="Password">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="column-group uiBirthday">
                                    <div class="control large-40">
                                        <select id="birthdayMonthSignUp" class="fixColor-a9b1c6 required" name="birthdayMonth">
                                            <option value>
                                                Month:
                                            </option>
                                            <?php $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                                            for ($i = 0; $i <= 11; $i++)
                                            {
; ?>
                                                <option value="<?php echo $i + 1; ?>"><?php echo $months[$i]; ?>
                                                </option>
<?php } ?>
                                        </select>
                                    </div>
                                    <div class="control large-25 fixMarginLeft-8">
                                        <select id="birthdayDaySignUp" class="fixColor-a9b1c6 required" name="birthdayDay">
                                            <option value="">
                                                Day:
                                            </option>
<?php for ($i = 1; $i <= 31; $i++)
{
; ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>
                                        </select>
                                    </div>
                                    <div class="control large-30 push-right">
                                        <select id="birthdayYearSignUp" class="fixColor-a9b1c6 required" name="birthdayYear">
                                            <option value="">
                                                Year:
                                            </option>
<?php for ($i = 2013; $i >= 1905; $i--)
{
; ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?>
                                                </option>
<?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group uiGender">
                                <div class="control large-40">
                                    <select id="genderSignUp" class="fixColor-a9b1c6 select required" name="sex">
                                        <option value>Gender</option>
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                    </select>
                                </div>
                            </div>
                            <div class="uiAgreeTermsPrivacyPolicy fixMarginBottom-10">
                                <div class="control">
                                    <input id="cbAgreeTermsPrivacyPolicy" class="cbAgreeTermsPrivacyPolicy required" type="checkbox" name="regCheckbox">
                                    <label for="cbAgreeTermsPrivacyPolicy" class="linkColor-9aa9c8">
                                        Please read and agree to the Terms and Privacy Policy
                                    </label>
                                </div>
                            </div>
                            <div class="column-group">
                                <div class="content-center">
                                    <input type="submit" class="uiMediumButton orange" id="smSignUp" name="smSignUp" value="Sign Up">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="large-45 medium-80 small-100 push-right top-space">
                <div class="box uiIntroductionBox">
                    bbbb
                </div>
                <div class="box fixMarginTop-10">
                    <div class="large-100 push-left">
                        <form class="ink-form">
                            <fieldset>
                                <div class="control-group uiLanguage">
                                    <label class="large-30 fixMarginRight-10 fixColor-fffff fontSize-14 content-right">Language:</label>
                                    <div class="control large-50">
                                        <select class="fixColor-a9b1c6" required="">
                                            <option>English</option>
                                            <option>Vietnamese</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
