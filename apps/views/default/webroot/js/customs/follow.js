function FollowByElement($element)
{
    $(document).ready(function(){
        var Follow      = 'Follow';
        var UnFollow    = 'UnFollow';

        $($element).each(function()
        {
            var getStatusFollow = $(this).attr('name').replace('getStatus-', '');
            $(this).data("state", {pressed: false});
            if (getStatusFollow == 'following')
            {
                $(this).html(UnFollow);
                $(this).data("state", {pressed: true});
            }
            if (getStatusFollow == 'null')
            {
                $(this).html(Follow);
                $(this).data("state", {pressed: false});
            }

            $(this).live('click', function()
            {
                var getID = $(this).attr('id').replace('followID-', '');
                if ($(this).data("state").pressed)
                {
                    $(this).html(Follow);
                    $.ajax({
                        type: 'POST',
                        url: '/unFollow',
                        data: $('#FollowID-'+getID).serialize(),
                        cache: false,
                        success: function(){

                        }
                    });
                    $(this).data("state", {pressed: false});
                }else {
                    $(this).html(UnFollow);
                    $.ajax({
                        type: 'POST',
                        url: '/follow',
                        data: $('#FollowID-'+getID).serialize(),
                        cache: false,
                        success: function(){
                            console.log(this);
                        }
                    });
                    $(this).data("state", {pressed: true});
                }
            });
        })
    });
}