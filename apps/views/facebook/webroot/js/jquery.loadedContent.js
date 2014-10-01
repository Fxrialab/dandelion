function Load_external_content()
{
    $('#autoloadModule').load('testLoaded.php').hide().fadeIn(3000);
}
setInterval('Load_external_content()', 10000);