<div class="column-group">
    <div class="large-30">
        <a href="/"><img src="<?php echo $this->f3->get('IMG'); ?>logo.png" style="margin-top: 5px"></a>
    </div>
    <div class='large-30'></div>
    <div class='large-40'>
        <form class="ink-form" method="post" action="/login" id="fmLogIn" style="margin: 0">
            <fieldset>
                <div class="control-group">
                    <div class="large-40">
                        <div style="padding: 0 5px;">
                            <div class="control">
                                <label class="float-left" style="color: #fff">Email</label>
                                <input type="text" placeholder="Your Email" name="emailLogIn" id="emailLogIn">
                                <div class="float-left">
                                    <input id="cbRememberMe" class="cbRememberMe" type="checkbox" name="persistent" value="1">
                                    <label for="cbRememberMe" style="color: #fff">Remember Me</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="large-40">
                        <div style="padding: 0 5px;">
                            <div class="control">
                                <label class="float-left" style="color: #fff">Password</label>
                                <input type="password" placeholder="Your Password" name="pwLogIn" id="pwLogIn">
                                <div class="float-left"><a  style="color: #fff" href="/forgotPassword">Forgot Password</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="large-15">
                        <div style="padding-top: 25px;">
                            <div class='control'>
                                <input type="submit" class="ink-button green" id="smLogIn" name="smLogIn" value="Log In">
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</div>