 <?php
    echo 'auth has been disabled, sorry'; exit();
    session_start();

    include_once($_SERVER["DOCUMENT_ROOT"]."/parts/logger.php");
    logger("LOGIN_TRY",$_SERVER['REMOTE_ADDR'],$_SERVER["DOCUMENT_ROOT"]."/logs/","login.log");

    $username = $_GET["username"];
    $password = $_GET["password"];


    $secretKeys = json_decode(file_get_contents("../../secret/secret.json"));

    include("../../parts/database.php");

    $userData = $db->prepare("SELECT `id`,`admin`,`password` FROM `users` WHERE `username`=:username");
    $userData->execute(array('username' => $username));
    //Not the best way to check for results, doing the login check in a query might be bad, but it sure is fast!
    $loginData = $userData->fetchAll(PDO::FETCH_ASSOC)["0"];
    if($userData->rowCount() == 1 && password_verify($pass,$loginData['password'])){
            $userId = $loginData["id"];
            $admin = $loginData["admin"];
            //Set session
            $_SESSION["loggedIn"] = true;
            $_SESSION["userId"] = $userId;
            $_SESSION["admin"] = $admin > 0;


            ////Create long term cookie
            ////Sleeper Cookie
            //$token = bin2hex(random_bytes(32));

            //setcookie("extendLogin", $token, time() + (86400 * 90), "/");
            //$userData = $db->prepare("UPDATE `users` SET `loginToken`:=`loginToken`");
            //$userData->execute(array('loginToken' => $token));

            //Send status
            logger("LOGIN_SUCCESS",$_SERVER['REMOTE_ADDR'],$_SERVER["DOCUMENT_ROOT"]."/logs/","login.log");
            echo '{
            "status": 1,
            "message": "You are logged in"
        }';
    } else {
        //Send status
        echo '{
            "status": 0,
            "message": "Login failed"
        }';
        logger("LOGIN_FAIL",$_SERVER['REMOTE_ADDR'],$_SERVER["DOCUMENT_ROOT"]."/logs/","login.log");
    }

?>
