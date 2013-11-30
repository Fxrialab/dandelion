$(document).ready(function(){
    $('h3').addClass('icon_arrow');
    $('.edit_wrapper:not(:first)').hide();
    $('h3:first').addClass('edit_active');
    $('h3:first').removeClass('icon_arrow');
    $('.edit_info_title').click(function(){
        $('.edit_active').removeClass('edit_active');
        $('h3').addClass('icon_arrow');
        $('#fr_edit').each (function(){
            this.reset();
        });
        $('.edit_wrapper').slideUp(100);
        if($(this).next('.edit_wrapper').is(':hidden')==true){
            $(this).children('h3').removeClass('icon_arrow');
            $(this).children('h3').addClass('edit_active');
            $(this).next('.edit_wrapper').slideDown(10);
        }
    });
});


//add, remove work
$(function(){
    var work    = $("#work");
    var i           = $("#work p").size() + 1;
    $("#addWorks").live("click", function(){
        $('<p><input type="text" id="edit_work" class="input" name="work_' + i +'" placeholder="Where have you worked?" /></p>').appendTo(work);
        $('.numberWork').attr('value', i);
        i++;
        return false;
    });
    $('#removeWorks').live('click', function() {
        if( i > 2 ) {
            $('#edit_work').parents('p').remove();
            i--;
        }
        $('.numberWork').attr('value', i-1);
        return false;
    });
    $('#delWork').live('click', function(){
        var works  = $(this).attr('name');
        $('#'+works).attr('name', 'delWork');
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#work-'+works).remove();
    });
});
// Add, remove College/University
$(function(){
    var CoUni    = $("#College");
    var i           = $("#College p").size() + 1;
    $("#addColleges").live("click", function(){
        $('<p><input type="text" id="edit_college" class="input" name="college_' + i +'" placeholder="Where did you go to college/university?" /></p>').appendTo(CoUni);
        $('.numberCollege').attr('value', i);
        i++;
        return false;
    });
    $('#removeColleges').live('click', function() {
        if( i > 2 ) {
            $('#edit_college').parents('p').remove();
            i--;
        }
        $('.numberCollege').attr('value', i-1);
        return false;
    });
    $('#delCollege').live('click', function(){
        var couni  = $(this).attr('name');
        $('#'+couni).attr('name', 'delCollege');
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#college-'+couni).remove();
    });
});
// Add, remove High School
$(function(){
    var HSchool     = $("#highSchool");
    var i           = $("#highSchool p").size() + 1;
    $("#addSchools").live("click", function(){
        $('<p><input type="text" id="edit_highschool" class="input" name="highschool_' + i +'" placeholder="Where did you go to high school?" /></p>').appendTo(HSchool);
        $('.numberHighschool').attr('value', i);
        i++;
        return false;
    });
    $('#removeSchool').live('click', function() {
        if( i > 2 ) {
            $('#edit_highschool').parents('p').remove();
            i--;
        }
        $('.numberHighschool').attr('value', i-1);
        return false;
    });
    $('#delHighschool').live('click', function(){
        var school  = $(this).attr('name');
        $('#'+school).attr('name', 'delHighschool');
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#highschool-'+school).remove();
    });
});

//add, remove email
$(function(){
    var email    = $("#Emails");
    var i           = $("#Emails p").size() + 1;
    $("#addEmail").click(function(){
        $('<p><input type="text" id="edit_email" class="input" name="email_' + i +'" placeholder="Email are you?" /></p>').appendTo(email);
        $('.numberEmail').attr('value', i);
        i++;
        return false;
    });
    $('#removeEmail').click(function() {
        if( i > 2 ) {
            $('#edit_email').parents('p').remove();
            i--;
        }
        $('.numberEmail').attr('value', i-1);
        return false;
    });
    $('#delEmail').live('click', function(){
     var emails  = $(this).attr('name');
     $('#'+emails).attr('name', 'delEmail');
     $.ajax({
     url     : '/ajax_delete_info',
     type    : 'POST',
     data    : $('#fr_edit').serialize(),
     cache   : false
     });
     $('#email-'+emails).remove();
     });
});
// Add, remove music
$(function(){
    var music    = $("#music");
    var i           = $("#music p").size() + 1;
    $("#addMusic").click(function(){
        $('<p><input type="text" id="edit_music" class="input" name="music_' + i +'" placeholder="What music do you like?" /></p>').appendTo(music);
        $('.numberMusic').attr('value', i);
        i++;
        return false;
    });
    $('#removeMusic').click(function() {
        if( i > 2 ) {
            $('#edit_music').parents('p').remove();
            i--;
        }
        $('.numberMusic').attr('value', i-1);
        return false;
    });
    $('#delMusic').live("click",function(){
        var musics  = $(this).attr('name');
        $('#'+musics).attr('name', 'delMusic');
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#music-'+musics).remove();
    });
});
// Add, remove books
$(function(){
    var books   = $("#books");
    var i       = $("#books p").size() + 1;
    $("#addBooks").live("click", function(){
        $('<p><input type="text" id="edit_book" class="input" name="books_' + i +'" placeholder="What books do you like?" /></p>').appendTo(books);
        $('.numberBook').attr('value', i);
        i++;
        return false;
    });
    $('#removeBooks').live('click', function() {
        if( i > 2 ) {
            $('#edit_book').parents('p').remove();
            i--;
        }
        $('.numberBook').attr('value', i-1);
        return false;
    });
    $('#delBook').live('click', function(){
        var book  = $(this).attr('name');
        $('#'+book).attr('name', 'delBook');
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#book-'+book).remove();
    });
});
// Add, remove movie
$(function(){
    var movies   = $("#movies");
    var i       = $("#movies p").size() + 1;
    $("#addMovies").live("click", function(){
        $('<p><input type="text" id="edit_movie" class="input" name="movies_' + i +'" placeholder="What movies do you like?" /></p>').appendTo(movies);
        $('.numberMovie').attr('value', i);
        i++;
        return false;
    });
    $('#removeMovies').live('click', function() {
        if( i > 2 ) {
            $('#edit_movie').parents('p').remove();
            i--;
        }
        $('.numberMovie').attr('value', i-1);
        return false;
    });
    $('#delMovie').live('click', function(){
        var film  = $(this).attr('name');
        $('#'+film).attr('name', 'delMovie');
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#movie-'+film).remove();
    });
});
// Add, remove television
$(function(){
    var television  = $("#tv");
    var i           = $("#tv p").size() + 1;
    $("#addTelevisions").live("click", function(){
        $('<p><input type="text" id="edit_television" class="input" name="television_' + i +'" placeholder="What TV shows do you like?" /></p>').appendTo(television);
        $('.numberTelevision').attr('value', i);
        i++;
        return false;
    });
    $('#removeTelevisions').live('click', function() {
        if( i > 2 ) {
            $('#edit_television').parents('p').remove();
            i--;
        }
        $('.numberTelevision').attr('value', i-1);
        return false;
    });
    $('#delTelevision').live('click', function(){
        var tv     = $(this).attr('name');
        $('#'+tv).attr('name', 'delTelevision');
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#television-'+tv).remove();
    });
});
// Add, remove games
$(function(){
    var games   = $("#games");
    var i       = $("#games p").size() + 1;
    $("#addGames").live("click", function(){
        $('<p><input type="text" id="edit_game" class="input" name="games_' + i +'" placeholder="What games do you like?" /></p>').appendTo(games);
        $('.numberGame').attr('value', i);
        i++;
        return false;
    });
    $('#removeGames').live('click', function() {
        if( i > 2 ) {
            $('#edit_game').parents('p').remove();
            i--;
        }
        $('.numberGame').attr('value', i-1);
        return false;
    });
    $('#delGame').live('click', function(){
        var getGame     = $(this).attr('name');
        $('#'+game).attr('name', 'delGame');
        //#game_han_quoc name="delGame"
        $.ajax({
            url     : '/ajax_delete_info',
            type    : 'POST',
            data    : $('#fr_edit').serialize(),
            cache   : false
        });
        $('#game-'+getGame).remove();
    });
});



