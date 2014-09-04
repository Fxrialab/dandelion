<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#searchWork').keyup(function (){
            var work = $(this).val();
            if (work != '')
            {
                $.ajax({
                    type: "POST",
                    url: "/searchWork",
                    data: {workIs: work},
                    success: function(data){
                        //Clear the results list
                        $('#workList').empty();
                        if (data.success)
                        {
                            console.log(data);
                            //Display the results
                            if(data.results.length > 0)
                            {
                                var $data = removeDuplicate(data.results,'workName');
                                //check if return to result is larger, just display 7 results
                                if ($data.length > 7)
                                {
                                    for(var i=0; i < $data.length - 7; i++)
                                    {
                                        $data.pop();
                                    }
                                }
                                //Loop through each result and add it to the list
                                $.each($data, function()
                                {
                                    $('#workList').append("<li class='oldWork'>"+ this.workName +"</li>");
                                });
                                $('#workList').append("<li class='newWork'>"+work+"</li>");
                                //Display a work then add it
                                $('.oldWork').click(function() {
                                    $('#workList li').hide();
                                    $('#searchWork').val('');
                                    var workName = $(this).html();
                                    $('.workContainer').append("<div class='addJob large-85 column-group'>" +
                                        "<div class='large-20 workLogo fixMarginBottom-20'>" +
                                        "<img />" +
                                        "</div>" +
                                        "<div class='large-80 workTitle fixMarginBottom-20'>" +
                                        "<p class='fixColor-0069d6'>"+ workName +"</p>" +
                                        "</div>" +
                                        "<div class='large-100 actionArea'>" +
                                        "<div class='large-60 jobAction'>" +
                                        "<a class='uiSmallButton blue addNewWork'>Add Job</a>" +
                                        "<a class='uiSmallButton white cancelWork'>Cancel</a>" +
                                        "</div>" +
                                        "</div>" +
                                        "</div>");
                                    //var ddWork = new DropDown( $('#ddWork') );
                                    $('.addNewWork').click(function() {

                                        var newWork = $('.workTitle p').html();
                                        console.log('clicked', newWork);
                                        $.ajax({
                                            async: true,
                                            type: 'POST',
                                            beforeSend: function(){
                                                $('.uiEduWorkEditPopUpOver').addClass('loading');
                                            },
                                            url: '/loadEduWork',
                                            data: {work: newWork},
                                            complete: function(request, json) {
                                                $('.uiEduWorkEditPopUpOver').removeClass('loading');
                                                $('.uiEduWorkEditPopUpOver').html(request.responseText);
                                            }
                                        });
                                    });
                                    $('.cancelWork').click(function() {
                                        $('.addJob').detach();
                                    });
                                });
                            } else {
                                $('#workList').append("<li class='no-results'>"+ data.new +"</li>");
                            }
                        }else {
                            //Display the error message
                            $('#workList').append("<li class='newWork'>"+ data.new +"</li>");
                            $('.newWork').click(function() {
                                $('.newWork').hide();
                                $('#searchWork').val('');
                                $('.workContainer').append("<div class='addJob large-85 column-group'>" +
                                    "<div class='large-20 workLogo fixMarginBottom-20'>" +
                                    "<img />" +
                                    "</div>" +
                                    "<div class='large-80 workTitle fixMarginBottom-20'>" +
                                    "<p class='fixColor-0069d6'>"+ data.new +"</p>" +
                                    "</div>" +
                                    "<div class='large-100 actionArea'>" +
                                    "<div class='large-60 jobAction'>" +
                                    "<a class='uiSmallButton blue addNewWork'>Add Job</a>" +
                                    "<a class='uiSmallButton white cancelWork'>Cancel</a>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>");
                                //var ddWork = new DropDown( $('#ddWork') );
                                $('.addNewWork').click(function() {

                                    var newWork = $('.workTitle p').html();
                                    console.log('clicked', newWork);
                                    $.ajax({
                                        async: true,
                                        type: 'POST',
                                        beforeSend: function(){
                                            $('.uiEduWorkEditPopUpOver').addClass('loading');
                                        },
                                        url: '/loadEduWork',
                                        data: {work: newWork},
                                        complete: function(request, json) {
                                            $('.uiEduWorkEditPopUpOver').removeClass('loading');
                                            $('.uiEduWorkEditPopUpOver').html(request.responseText);
                                        }
                                    });
                                });
                                $('.cancelWork').click(function() {
                                   $('.addJob').detach();
                                });
                            });
                        }
                        $('#workList').fadeIn();
                    }
                })
            }else {
                $('#workList').empty();
            }
        });
        function removeDuplicate(arr, prop) {
            var new_arr = [];
            var lookup  = {};
            var $i;
            for ($i in arr) {
                lookup[arr[$i][prop]] = arr[$i];
            }

            for ($i in lookup) {
                new_arr.push(lookup[$i]);
            }

            return new_arr;
        }

    })
</script>
<div class="uiEduWorkContainer">
    <form class="ink-form" id="fmEduWork">
        <div class="rowBoxItem column-group workContainer">
            <div class="large-85">
                <input type="text" id="searchWork" name="work" value="" placeholder="Where have you worked?">
            </div>
            <div class="large-85" id="workResults">
                <ul id="workList">
                </ul>
            </div>
            <?php
            if ($works)
            {
                foreach ($works->data->work as $work)
                {
                    $id = $work->clusterID.":".$work->recordPos;
                ?>
                    <div class="large-85 addJob column-group">
                        <div class="large-20 workLogo fixmarginbottom-20">
                            <img src="">
                        </div>
                        <div class="large-80 workCurrentTitle fixmarginbottom-20">
                            <p class="fixColor-0069d6"><?php echo $findWork[$id][0]->workName; ?></p>
                        </div>
                    </div>
                    <script type="text/javascript">
                        var dd<?php echo $findWork[$id][0]->work; ?> = new DropDown( $('#dd<?php echo $findWork[$id][0]->work; ?>') )
                    </script>
                    <div class="large-15">
                        <div id="dd<?php echo $findWork[$id][0]->work; ?>" class="wrapper-dropdown-3" tabindex="2">
                            <span>g</span>
                            <ul class="dropdown">
                                <li><a href="#"><i class="icon-globe icon-large"></i>Public</a></li>
                                <li><a href="#"><i class="icon-group icon-large"></i>Friends</a></li>
                                <li><a href="#"><i class="icon-lock icon-large"></i>Only Me</a></li>
                            </ul>
                            <input type="hidden" name="ddRelationship" value="">
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
        <div class="rowBoxItem column-group">
            <div class="large-85">
                <input type="text" id="searchCollege" name="work" value="" placeholder="Where did you go to college?">
            </div>
        </div>
        <div class="rowBoxItem column-group">
            <div class="large-85">
                <input type="text" id="searchHiSchool" name="work" value="" placeholder="Where did you go to school?">
            </div>
        </div>
        <div class="actionPopUp column-group push-right large-100">
            <a class="uiMediumButton blue saveEduWork">Save Change</a>
            <a class="uiMediumButton white closeEditPopUpOver" onclick="closePopUpOver('.uiEduWorkEditPopUpOver')">Cancel</a>
        </div>
    </form>
</div>