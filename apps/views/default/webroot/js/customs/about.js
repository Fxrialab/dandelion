$(document).ready(function(){
    $('#basicInfo').click(function (e){
        e.preventDefault();
        $('.uiBasicInfoEditPopUpOver').show();
        var year        = $('.txtBirthYear').html();
        var monthDay    = $('.txtBirthDate').html();
        var day         = monthDay.substr(monthDay.search(' '));
        var month       = monthDay.substr(0, monthDay.search(day));
        var gender      = $('.txtGender').html();
        var interest    = $('.txtInterest').html();
        var relation    = $('.txtRelation').html();
        var birthDayStatus  = $('#birthDateIcon').attr('class').replace(' icon-large', '').replace('icon-', '');
        var birthYearStatus = $('#birthYearIcon').attr('class').replace(' icon-large', '').replace('icon-', '');
        var genderStatus    = $('#genderIcon').attr('class').replace(' icon-large', '').replace('icon-', '');
        var interestStatus  = $('#interestIcon').attr('class').replace(' icon-large', '').replace('icon-', '');
        var relationStatus  = $('#relationIcon').attr('class').replace(' icon-large', '').replace('icon-', '');

        console.log('txtRelation', birthDayStatus);
        $.ajax({
            async: true,
            type: 'POST',
            beforeSend: function(){
                $('.uiBasicInfoEditPopUpOver').addClass('loading');
            },
            url: '/loadBasicInfo',
            data: {month:month, day:day, year:year, gender:gender, interest:interest, relation:relation,
                birthDayStatus:birthDayStatus, birthYearStatus:birthYearStatus, genderStatus:genderStatus, interestStatus:interestStatus, relationStatus:relationStatus},
            complete: function(request, json) {
                $('.uiBasicInfoEditPopUpOver').removeClass('loading');
                $('.uiBasicInfoEditPopUpOver').html(request.responseText);
            }
        });
        return false;
    });
    //Education and Work
    $('#eduWork').click(function (e){
        e.preventDefault();
        $('.uiEduWorkEditPopUpOver').show();

        $.ajax({
            async: true,
            type: 'POST',
            beforeSend: function(){
                $('.uiEduWorkEditPopUpOver').addClass('loading');
            },
            url: '/loadEduWork',
            data: {},
            complete: function(request, json) {
                $('.uiEduWorkEditPopUpOver').removeClass('loading');
                $('.uiEduWorkEditPopUpOver').html(request.responseText);
            }
        });
        return false;
    });
});

function closePopUpOver($popUpOver) {
    $($popUpOver).hide();
}