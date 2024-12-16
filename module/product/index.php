<?php 
    if (!defined("ROOT"))
    {
        echo "Err!"; exit;	
    }
    $ac = getIndex("ac","home");
    if ($ac=="home")
		{
			include ROOT."/module/product/home.php";
		}
    if ($ac=="detail")
        {
            include ROOT."/module/product/detail.php";
        }
?>