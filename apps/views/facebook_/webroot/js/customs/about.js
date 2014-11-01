$("body").on('click', '.editAbout', function(e) {
    var rel = $(this).attr('rel');
    $.ajax({
        type: "GET",
        url: "/" + rel,
        success: function(data) {
            $("." + rel + " .position").hide();
            $("." + rel + " .option").hide();
            $("." + rel).append(data);
        }
    });
});

$("body").on('click', '.editAboutCity', function(e) {
    var rel = $(this).attr('rel');
    $.ajax({
        type: "GET",
        url: "/" + rel,
        success: function(data) {
            $("." + rel + " div").hide();
            $("." + rel).prepend(data);
        }
    });
});

$("body").on('click', '.cancelAbout', function(e) {
    var rel = $(this).attr('rel');
    $('.' + rel + "Form").remove();
    $("." + rel + " .position").show();
    $("." + rel + " .option").show();
});

$("body").on('click', '.cancelAboutCity', function(e) {
    var rel = $(this).attr('rel');
    $('.' + rel + "City" + " ." + rel).remove();
    $("." + rel + "City div").show();
});

$("body").on('click', '.cancelForm', function(e) {
    var rel = $(this).attr('rel');
    $('.formBirthday').remove();
    $("." + rel + " div").show();
});
$("body").on('click', '.cancelFormName', function(e) {
    $('.nameForm').remove();
    $(".editname div").show();
});
//$("body").on('submit', '.#submitFormAbout', function(e) {
//    $.ajax({
//        type: "POST",
//        url: "/editabout",
//        data: $("#submitFormAbout").serialize(), // serializes the form's elements.
//        success: function(data)
//        {
//            if (data) {
//                var obj = jQuery.parseJSON(data);
//                $('.aboutForm').remove();
//                $('.divabout').html(obj.position);
//                $(".editabout .option").show();
//            }
//        }
//    });
//
//    return false; // avoid to execute the actual submit of the form.
//});
