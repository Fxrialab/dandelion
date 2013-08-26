<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/1/13 - 9:09 AM
 * Project: joinShare Network - Version: 1.0
 */
?>
<div class="header">
    <div class="clearfix main">
        <div class="left">
            <div class="logo"><img src="<?php echo F3::get('STATIC'); ?>images/landing_logo.png" alt="" /></div>
        </div>
        <div class="right">

            <div class="loginContainer">
                <form method="post" action="/login" id="login_form">
                    <table cellspacing="0">
                        <tr>
                            <td>
                                <input type="text" class="inputtext DOMControl_placeholder" name="email" id="login_email" placeholder="Email are you?" value="" tabindex="1" onkeyup="HideMessage();">

                            </td>
                            <td>
                                <input type="password" class="inputtext DOMControl_placeholder" name="password" id="login_password" value="" tabindex="2">

                            </td>
                            <td>
                                <label class="button buttonConfirm" for="">
                                    <input value="Sign In" tabindex="4" type="submit" id="login_submit">
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="login_form_label_field">
                                <div class="inputLabel">
                                    <input id="persist_box" type="checkbox" name="persistent" value="1" class="inputLabelCheckbox">
                                    <label for="persist_box">Remember me</label>
                                </div>
                            </td>
                            <td class="login_form_label_field">
                                <a href="/forgotPassword" rel="nofollow">Forgot Password?</a>
                            </td>
                        </tr>
                    </table>
                </form>
                <div class="alert alert-error" id="errorMsg" style="display: none;">
                    <!--<button type="button" class="close" data-dismiss="alert">x</button>-->
                    <span id="error_signin"></span>
                </div>
            </div>
            <script type="text/javascript">
                $('#login_email').inputToggle({
                    'inactive' : 'gray',
                    'active' : 'black'
                });
                $('#login_password').inputToggle({
                    'inactive' : 'gray',
                    'active' : 'black'
                });
            </script>
        </div>
    </div>
</div>