/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/30/13 - 2:50 PM
 * Project: userwired Network - Version: 1.0
 */
$(document).ready(function()
{
    $('#search').keyup(function()
    {
        var searchText = $(this).val();
        //console.log('searchText:',searchText);
        if (searchText != '')
        {
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
                        console.log(data);
                        //Display the results
                        if(data.results.length > 0)
                        {
                            //check if return to result is larger, just display 8 results
                            if (data.results.length > 9)
                            {
                                for(var i=0; i < data.results.length - 9; i++)
                                {
                                    data.results.pop();
                                }
                            }
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
                            $('#resultsList').append("<li class='moreSearch'><a href='/moreSearch?search="+searchText+"'><span class='moreSearchText'>See more results for '"+searchText+"'</span></a></li>");
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
        }else {
            $('#resultsList').empty();
        }
    })
});