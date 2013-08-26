<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/2/13 - 11:01 PM
 * Project: joinShare Network - Version: 1.0
 */
$user   =   F3::get('user');
?>
<div class="loginBlock" id="forgot">
    <div class="wrapperForgot">
        <h1 class="findYour">Reset your password</h1>
        <div style="margin-bottom: 10px;" class="dr"><span></span></div>
        <form id="email_form_box" action="/resetPassword" method="post">
            <div class="loginForm">
                <div class="control-group">
                    <div class="wrapper-reset">
                        <table>
                            <tbody>
                            <tr>
                                <td class="reset_left" style="border-right: 1px solid #e8ebf3;">
                                    <div class="">
                                        <strong class="reset_someshow">You want to change your password somehow ?</strong>
                                    </div>
                                    <table class="reset_width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" class="">
                                                <div class="reset_top">
                                                    <input type="radio" name="recover_method" value="send_email" checked="1" class="label_radio" id="u_0_0">
                                                    <label for="">
                                                        <div class="">
                                                            <img class="add-on" style="margin-right: 10px;" src="<?php echo F3::get("STATIC");?>images/email.gif" alt="" width="16" height="16">
                                                            <div class="">
                                                                <div>
                                                                    <strong class="format_reset">Please send a password reset link to my email</strong><br />
                                                                    <div class="reset_format_child">
                                                                        <strong class="format_reset_child"><?php echo $user->data->email; ?></strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <!--<tr>
                                            <td valign="top" class="">
                                                <div class="reset_top">
                                                    <input type="radio" id="recover_openid" name="recover_method" value="recover_openid"  class="label_radio">
                                                    <label for="">
                                                        <div class="">
                                                            <img class="add-on" style="margin-right: 10px;" src="<?php /*echo F3::get("STATIC");*/?>images/google.png" alt="" width="16" height="16">
                                                            <div class="">
                                                                <div>
                                                                    <strong class="format_reset">Use my Google account </strong><br />
                                                                    <div class="reset_format_child">
                                                                        <strong class="format_reset_child">Sign in to Google ( if you have not already) to quickly reset your password.</strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>-->
                                        </tbody>
                                    </table>
                                </td>
                                <td class="reset_left" style="padding-left: 13px;">
                                    <div class="">
                                        <div>
                                            <div>
                                                <img class="img" src="<?php echo $user->data->profilePic; ?>" alt="" width="80" height="80">
                                            </div>
                                            <div>
                                                <input name="email" type="hidden" value="<?php echo $user->data->email; ?>" />
                                            </div>
                                            <div>
                                                <div class="wrapper_username"><?php echo ucfirst($user->data->firstName).' '.ucfirst($user->data->lastName);?></div>
                                            </div>
                                        </div>
                                        <div class="wrapper_reset_link">
                                            <a href="#" class="reset_link">
                                                Not you?
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="dr drbottom"><span></span></div>
                <div class="controls">
                    <div class="row-fluid">
                        <p class="cannot"><a href="#" class="reset_link">No longer accessible anymore?</a></p>
                        <div class="btn_send">
                            <input id="reset_next" class="sendrequest" type="submit" value="Next" />
                            <a href="#" class="cancelAction" title="Back">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>