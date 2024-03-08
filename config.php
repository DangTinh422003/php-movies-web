<?php 
    //This file is using for storage constants and variable, also have useful function

    //Sesstion expire time
    define("EXPIRE_TIME", 60 * 60 * 24);


    function redirect($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
        
    //
?>