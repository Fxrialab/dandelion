/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/30/13 - 2:50 PM
 * Project: userwired Network - Version: 1.0
 */
$(document).ready(function()
{
    $('#searchText').keyup(function()
    {
        var searchText = $(this).val();
        $.ajax({
            type: "POST",
            url: "/search",
            data: {data: searchText},
            beforeSend: function(){
                //Lets add a loading image
                $('#resultsHolder').addClass('loading');
            },
            success: function(data){
                $('#resultsHolder').removeClass('loading');
                //Clear the results list
                $('#resultsList').empty();
                if (data.success)
                {
                    //Display the results
                    if(data.results.length > 0)
                    {
                        //Loop through each result and add it to the list
                        $.each(data.results, function()
                        {
                            $('#resultsList').append("<li rel='" + this.recordID + "'>" +
                                "<a href='/content/myPost?username="+ this.username +"'>" +
                                    "<span>" +
                                        "<img class='imgFindPeople' src='"+ this.profilePic +"' width='30' height='30'/>" +
                                        "<span class='infoPeople'>" + this.firstName + " " + this.lastName +"</span>" +
                                    "</span>" +
                                "</a>" +
                                "</li>");
                        });
                    } else {
                        $('#resultsList').append("<li class='no-results'>"+ data.error +"</li>");
                    }
                } else {
                    //Display the error message
                    $('#resultsList').append("<li class='no-results'>"+ data.error +"</li>");
                }
                $('#resultsList').fadeIn();
            }
        })
    })
});