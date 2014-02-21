<script type="text/javascript">
    $(document).ready(function(){
        var ddBirthDate = new DropDown( $('#ddBirthDate') );
        var ddBirthYear = new DropDown( $('#ddBirthYear') );
        var ddGender = new DropDown( $('#ddGender') );
        var ddInterest = new DropDown( $('#ddInterest') );
        var ddRelationship = new DropDown( $('#ddRelationship') );

        $('.saveBasicInfo').click(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/editBasicInfo",
                data: $('#fmBasicInfo').serialize(),
                cache: false,
                success: function(){
                    $('.uiBasicInfoEditPopUpOver').hide();
                }
            });
        });
    });
</script>
<div class="uiBasicInfoContainer">
    <form class="ink-form" id="fmBasicInfo">
        <div class="rowBoxItem column-group">
            <div class="large-30 leftColBox">Birth Date</div>
            <div class="large-50 rightColBox fixColor-111111">
                <div class="control large-40">
                    <select class="fixColor-a9b1c6 required" name="change_Month">
                        <?php $months = array('January','February','March','April','May','June','July','August','September','October','November','December'); for($i=0;$i<=11;$i++) { ; ?>
                            <option value="<?php echo $months[$i]; ?>" <?=$month==$months[$i]?'selected="selected"':'';?>><?php echo $months[$i]; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="control large-25 birthDay">
                    <select class="fixColor-a9b1c6 required" name="change_Day">
                        <?php for($i=1;$i<=31;$i++) { ; ?>
                            <option value="<?php echo $i; ?>" <?=$day==$i?'selected="selected"':'';?>><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="large-15">
                <div id="ddBirthDay" class="wrapper-dropdown-3" tabindex="1">
                    <span>Options</span>
                    <ul class="dropdown">
                        <li><a href="#"><i class="icon-globe icon-large"></i>Public</a></li>
                        <li><a href="#"><i class="icon-group icon-large"></i>Friends</a></li>
                        <li><a href="#"><i class="icon-lock icon-large"></i>Only Me</a></li>
                    </ul>
                    <input type="hidden" name="ddBirthDay" value="">
                </div>
            </div>
        </div>
        <div class="rowBoxItem column-group">
            <div class="large-30 leftColBox">Birth Year</div>
            <div class="large-50 rightColBox fixColor-111111">
                <div class="control large-40">
                    <select class="fixColor-a9b1c6 required" name="change_Year">
                        <?php for($i=2013;$i>=1905;$i--) { ; ?>
                            <option value="<?php echo $i; ?>" <?=$year==$i?'selected="selected"':'';?>><?php echo $i; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="large-15">
                <div id="ddBirthYear" class="wrapper-dropdown-3" tabindex="2">
                    <span>Options</span>
                    <ul class="dropdown">
                        <li><a href="#"><i class="icon-globe icon-large"></i>Public</a></li>
                        <li><a href="#"><i class="icon-group icon-large"></i>Friends</a></li>
                        <li><a href="#"><i class="icon-lock icon-large"></i>Only Me</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="rowBoxItem column-group">
            <div class="large-30 leftColBox">Gender</div>
            <div class="large-50 rightColBox fixColor-111111">
                <ul class="control unstyled inline uiRadioGender">
                    <?php
                    if ($gender == 'Male'){
                    ?>
                    <li>
                        <input type="radio" id="rb1" name="gender" checked="checked" value="1">
                        <label for="rb1">Male</label>
                    </li>
                    <li>
                        <input type="radio" id="rb1" name="gender" value="2">
                        <label for="rb1">Female</label>
                    </li>
                    <?php
                    }else {
                    ?>
                    <li>
                        <input type="radio" id="rb1" name="gender" value="1">
                        <label for="rb1">Male</label>
                    </li>
                    <li>
                        <input type="radio" id="rb1" name="gender" checked="checked" value="2">
                        <label for="rb1">Female</label>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="large-15">
                <div id="ddGender" class="wrapper-dropdown-3" tabindex="2">
                    <span>Options</span>
                    <ul class="dropdown">
                        <li><a href="#"><i class="icon-globe icon-large"></i>Public</a></li>
                        <li><a href="#"><i class="icon-group icon-large"></i>Friends</a></li>
                        <li><a href="#"><i class="icon-lock icon-large"></i>Only Me</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="rowBoxItem column-group">
            <div class="large-30 leftColBox">Interested In</div>
            <div class="large-50 rightColBox fixColor-111111">
                <ul class="control unstyled inline uiRadioGender">
                    <?php
                    if ($interest == 'Men'){
                    ?>
                    <li>
                        <input type="checkbox" id="rb1" checked="">
                        <label for="rb1">Men</label>
                    </li>
                    <li>
                        <input type="checkbox" id="rb1">
                        <label for="rb1">Women</label>
                    </li>
                    <?php
                    }elseif($interest == 'Women') {
                    ?>
                    <li>
                        <input type="checkbox" id="rb1">
                        <label for="rb1">Men</label>
                    </li>
                    <li>
                        <input type="checkbox" id="rb1" checked="">
                        <label for="rb1">Women</label>
                    </li>
                    <?php
                    }else {
                    ?>
                        <li>
                            <input type="checkbox" id="cb1">
                            <label for="rb1">Men</label>
                        </li>
                        <li>
                            <input type="checkbox" id="cb2">
                            <label for="rb1">Women</label>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="large-15">
                <div id="ddInterest" class="wrapper-dropdown-3" tabindex="2">
                    <span>Options</span>
                    <ul class="dropdown">
                        <li><a href="#"><i class="icon-globe icon-large"></i>Public</a></li>
                        <li><a href="#"><i class="icon-group icon-large"></i>Friends</a></li>
                        <li><a href="#"><i class="icon-lock icon-large"></i>Only Me</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="rowBoxItem column-group">
            <div class="large-30 leftColBox">Relationship Status</div>
            <div class="large-50 rightColBox fixColor-111111">
                <div class="control large-40 uiSelectRelation">
                    <select class="fixColor-a9b1c6 required" name="">
                        <option value>
                            None
                        </option>
                        <?php $relationship = array("Single","In a relationship","Engaged","Married","In an open relationship","Separated","It's complicated"); for($i=0;$i<=6;$i++) { ; ?>
                            <option value="<?php echo $i + 1; ?>"><?php echo $relationship[$i]; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="large-15">
                <div id="ddRelationship" class="wrapper-dropdown-3" tabindex="2">
                    <span>Options</span>
                    <ul class="dropdown">
                        <li><a href="#"><i class="icon-globe icon-large"></i>Public</a></li>
                        <li><a href="#"><i class="icon-group icon-large"></i>Friends</a></li>
                        <li><a href="#"><i class="icon-lock icon-large"></i>Only Me</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="actionPopUp column-group push-right large-100">
            <a class="uiMediumButton blue saveBasicInfo">Save Change</a>
            <a class="uiMediumButton white closeEditPopUpOver" onclick="closePopUpOver('.uiBasicInfoEditPopUpOver')">Cancel</a>
        </div>
    </form>
</div>