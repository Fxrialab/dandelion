<div class="column-group">
    <div class="large-50 medium-100 small-100 push-center">
        <form class="ink-form formSignUp" method="post" action="/signUp" id="fmSignUp">
            <div><h2>Sign Up</h2></div>
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
                    <div class="control large-35">

                        <select id="birthdayMonthSignUp" class="fixColor-a9b1c6 required" name="birthdayMonth">
                            <option value>
                                Month:
                            </option>
                            <?php
                            $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                            for ($i = 0; $i <= 11; $i++)
                            {
                                ;
                                ?>
                                <option value="<?php echo $i + 1; ?>"><?php echo $months[$i]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="large-5"></div>
                    <div class="control large-25 fixMarginLeft-8">
                        <select id="birthdayDaySignUp" class="fixColor-a9b1c6 required" name="birthdayDay">
                            <option value="">
                                Day:
                            </option>
                            <?php
                            for ($i = 1; $i <= 31; $i++)
                            {
                                ;
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="control large-30 push-right">
                        <select id="birthdayYearSignUp" class="fixColor-a9b1c6 required" name="birthdayYear">
                            <option value="">
                                Year:
                            </option>
                            <?php
                            for ($i = 2013; $i >= 1905; $i--)
                            {
                                ;
                                ?>
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
                <div style='margin-top:30px; text-align: right'>
                    <input type="submit" class="ink-button green" id="smSignUp" name="smSignUp" value="Sign Up">
                </div>
            </div>
        </form>
    </div>
</div>