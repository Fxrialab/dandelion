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
        console.log('txtRelation', day);
        $.ajax({
            async: true,
            type: 'POST',
            beforeSend: function(){
                $('.uiBasicInfoEditPopUpOver').addClass('loading');
            },
            complete: function(request, json) {
                $('.uiBasicInfoEditPopUpOver').removeClass('loading');
                $('.uiBasicInfoEditPopUpOver').html(request.responseText);
            },
            url: '/loadBasicInfo',
            data: {month:month, day:day, year:year, gender:gender, interest:interest, relation:relation}
        });
        return false;
    });

});

function closePopUpOver($popUpOver) {
    $($popUpOver).hide();
}