<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 10/2/13 - 11:22 AM
 * Project: userwired Network - Version: 1.0
 */
$resultSearch   = F3::get('resultSearch');
$infoOfSearchFound  = F3::get('infoOfSearchFound');
//var_dump($resultSearch);
if ($resultSearch)
{
?>
    <div class="mainSearchWrapper">
    <?php
    foreach ($resultSearch as $people)
    {
        $fullName   = ucfirst($infoOfSearchFound[$people][0]->firstName)." ".ucfirst($infoOfSearchFound[$people][0]->lastName);
        $linkProfile= $infoOfSearchFound[$people][0]->username;
        $profilePic = $infoOfSearchFound[$people][0]->profilePic;
    ?>
        <div class="searchResultItems">
            <a class="linkProfile" href="">
                <img src="<?php echo $profilePic; ?>">
            </a>
            <div class="infoItem">
                <div class="infoSearch">
                    <div class="fullName">
                        <a href="/content/myPost?username=<?php echo $linkProfile; ?>"><?php echo $fullName; ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    </div>
<?php
}
?>
