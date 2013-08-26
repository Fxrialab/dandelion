<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/1/13 - 8:53 AM
 * Project: joinShare Network - Version: 1.0
 */
?>
<div class="clearfix wrapper">
    <div class="wrapperHolder" id="wrapperholder">
        <div class="left">

            <div class="logo_bigger">
                <img src="<?php echo F3::get('STATIC'); ?>images/S_Landing-Page_03.png" alt="" />
            </div>
            <div class="linkPage">
	    				<span class="img">
	    					<img src="<?php echo F3::get('STATIC'); ?>images/S_Landing-Page_06.png" alt="" />
	    				</span>
	    				<span class="img">
	    					<img src="<?php echo F3::get('STATIC'); ?>images/S_Landing-Page_08.png" alt="" />
	    				</span>
	    				<span class="img">
	    					<img src="<?php echo F3::get('STATIC'); ?>images/S_Landing-Page_10.png" alt="" />
	    				</span>
	    				<span class="img">
	    					<img src="<?php echo F3::get('STATIC'); ?>images/S_Landing-Page_12.png" alt="" />
	    				</span>
	    				<span class="img">
	    					<img src="<?php echo F3::get('STATIC'); ?>images/S_Landing-Page_14.png" alt="" />
	    				</span>
            </div>
            <div class="language">
                <table>
                    <tr>
                        <td class="label greencolor">
                            <label>Language :</label>
                        </td>
                        <td>
                            <div class="field_container">
                                <select class="select" name="sex" id="sex">
                                    <option value="0">
                                        English (United State)
                                    </option>
                                    <option value="1">
                                        English (United Kingdom)
                                    </option>
                                    <option value="2">
                                        France
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
        <div class="right">

            <div class="title">
                <h3><span>New to SocialeWired?</span> Sign Up Now!</h3>
            </div>
            <div class="" id="reg_error"></div>
            <form id="reg_form_box" class="large_form" method="post" action="/signUp">
                <table class="uiGrid editor" cellspacing="0" cellpadding="1">
                    <tbody>
                    <tr>
                        <td class="label">
                            <label for="firstname">First Name:</label>
                        </td>
                        <td>
                            <div class="field_container">
                                <input type="text" class="inputtext required" id="firstname" name="firstName" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <label for="lastname">Last Name:</label>
                        </td>
                        <td>
                            <div class="field_container">
                                <input type="text" class="inputtext required" id="lastname" name="lastName" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <label for="reg_email__">Email:</label>
                        </td>
                        <td>
                            <div class="field_container">
                                <input type="text" class="inputtext required" id="email" name="email" placeholder="example@gmail.com"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <label for="reg_passwd__">Password :</label>
                        </td>
                        <td>
                            <div class="field_container">
                                <input type="password" class="inputtext required" id="password" name="password" value=""/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <label for="reg_portalcode__">Postal Code :</label>
                        </td>
                        <td>
                            <div class="field_container">
                                <input type="text" class="inputtext required" id="postalCode" name="postalCode" value=""/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            I am:
                        </td>
                        <td>
                            <div class="field_container">
                                <select class="select required" name="sex" id="sex">
                                    <option value>
                                        Select Sex:
                                    </option>
                                    <option value="1">
                                        Female
                                    </option>
                                    <option value="2">
                                        Male
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Birthday:
                        </td>
                        <td>
                            <div class="field_container">
                                <select name="birthdayMonth" id="birthday_month" class="required" onchange="">
                                    <option value>
                                        Month:
                                    </option>
                                    <?php $months = array('January','February','March','April','May','June','July','August','September','October','November','December'); for($i=0;$i<=11;$i++) { ; ?>
                                        <option value="<?php echo $i + 1; ?>"><?php echo $months[$i]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <select name="birthdayDay" id="birthday_day" class="required">
                                    <option value>
                                        Day:
                                    </option>
                                    <?php for($i=1;$i<=31;$i++) { ; ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="birthdayYear" id="birthday_year" class="required" onchange="">
                                    <option value>
                                        Year:
                                    </option>
                                    <?php for($i=1999;$i>=1905;$i--) { ; ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            <input type="checkbox" id='regCheckbox' name="regCheckbox" class="required"/>
                        </td>
                        <td>
                            <div class="policy">
                                Please read and agree to the <a href="">Terms</a> and <a href="">Privacy Policy</a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="reg_btn clearfix">
                    <label class="button buttonSpecial" for="">
                        <input id="submitForm" class="submit" name="submitForm" value="Sign Up Free!" type="submit"/>
                    </label>
                            <span id="twitter_icon" class="twitter_icon">
                                <img class="img" src="<?php echo F3::get('STATIC'); ?>images/twitterlogo.png" alt=""/>
                            </span>
                            <span id="facebook_icon" class="facebook_icon">
                                <img class="img" src="<?php echo F3::get('STATIC'); ?>images/facebooklogo.png" alt=""/>
                            </span>
                </div>
            </form>

        </div>
    </div>
</div>