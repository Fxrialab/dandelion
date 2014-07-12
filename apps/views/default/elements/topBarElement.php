
<div class="ink-grid">
    <div class="column-group">
        <div class="large-80">
            <div class="large-20">
                <a href="/"><i class="topNavIcon1-logo"></i></a>
            </div>
            <div class="large-45" id="uiSearch">
                <div class="control-group">
                    <div class="control large-100 append-button ink-form column-group">
                    <input class="large-100" type="text" id="search" name="search" autocomplete="off">
                        <!--<div class="large-10"><a href="" class=""><i class="topNavIcon2-search"></i></a></div>-->
                    </div>
                </div>
                <div id="resultsHolder">
                    <ul id="resultsList">
                    </ul>
                </div>
            </div>
            <div class="large-5">
                <a class="float-right" href="/content/post?user=<?php echo $this->f3->get('SESSION.username'); ?>">
                    <img src="<?php echo $this->f3->get('SESSION.avatar'); ?>" width="30" height="30">
                </a>
            </div>
            <div class="large-5">
                <a style="line-height: 30px; color: #fff; font-weight: bold; padding-left: 10px" href="/content/post?user=<?php echo $this->f3->get('SESSION.username'); ?>">
                    <?php echo $this->f3->get('SESSION.firstname'); ?>
                </a>
            </div>
            <div class="large-5">
                <a class="float-right" style="line-height: 30px; color: #fff; font-weight: bold" href="/home">Home</a>
            </div>
            <div class="large-5">
                <div class="float-right">
                    <?php $this->element('friendRequest'); ?>
                </div>
            </div>
            <div class="large-5">
                <div class="float-right">
                    <?php $this->element('message'); ?>
                </div>
            </div>
            <div class="large-5">
                <div class="float-right">
                    <?php $this->element('notification'); ?>
                </div>

            </div>
            <div class="large-5">
                <div class="float-right">
                    <a data-dropdown="#dropdown-setting"><i class="icon30-setting"></i></a>
                    <div id="dropdown-setting" class="dropdown dropdown-tip dropdown-anchor-right">
                        <ul class="dropdown-menu">
                            <li><a href="#">Account Setting</a></li>
                            <li><a href="#">Privacy Setting</a></li>
                            <li><a href="/logout">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<nav class="ink-navigation ink-grid">
    <ul class="menu horizontal large-80">
        <li>
            <a href="/"><i class="topNavIcon1-logo"></i></a>
        </li>
        <li  class="large-50">
            <div id="uiSearch">
                <form class="ink-form">
                    <div class="control-group">
                        <div class="control">
                            <input class="large-100" type="text" id="search" name="search" autocomplete="off" style="margin-top: 5px">

<div class="large-10"><a href="" class=""><i class="topNavIcon2-search"></i></a></div>
                        </div>
                    </div>
                </form>
                <div id="resultsHolder">
                    <ul id="resultsList">
                    </ul>
                </div>
            </div>
        </li>
        <li >
            <a href="#">item</a>
        </li>
        <li >
            <a href="#">item</a>
        </li>
        <li >
            <a href="#">item</a>
        </li>
        <li >
            <a href="#">item</a>
        </li>
        <li>
            <a data-dropdown="#dropdown-setting">item</a>
            <div id="dropdown-setting" class="dropdown dropdown-tip dropdown-anchor-right">
                <ul class="dropdown-menu">
                    <li><a href="#">Account Setting</a></li>
                    <li><a href="#">Privacy Setting</a></li>
                    <li><a href="/logout">Log Out</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
<div class="large-5">
    <div class="float-right">
        <a data-dropdown="#dropdown-setting"><i class="icon30-setting"></i></a>
        <div id="dropdown-setting" class="dropdown dropdown-tip dropdown-anchor-right">
            <ul class="dropdown-menu">
                <li><a href="#">Account Setting</a></li>
                <li><a href="#">Privacy Setting</a></li>
                <li><a href="/logout">Log Out</a></li>
            </ul>
        </div>
    </div>
</div>-->