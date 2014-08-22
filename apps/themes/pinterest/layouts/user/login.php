<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="column-group">
    <div class="large-40 medium-100 small-100 push-center">
        <form class="ink-form formLogin" method="post" action="/login">
            <div><h2>Login</h2></div>
            <div class="column-group">
                <label class="large-25">Email</label>
                <input type="text" class="large-75" name="emailLogIn"  placeholder="Your Email">
            </div>
            <div class="column-group">
                <label class="large-25">Password</label>
                <input type="password"  name="pwLogIn" class="large-75"  placeholder="Your Password">
            </div>
            <div class="column-group">
                <div style="float: right">
                    <a href="/forgotPassword">Forgot Password</a>
                </div>
            </div>
            <div class="column-group">
                <div style="float: right">
                    <input type="submit" class="ink-button green" id="smLogIn" name="smLogIn" value="Log In">
                    <a href="/signUp" class="ink-button">Sign Up</a>
                </div>
            </div>
        </form>
    </div>
</div>