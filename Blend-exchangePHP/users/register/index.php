 <?php
    echo 'auth has been disabled, sorry'; exit();
    session_start();

    $username = $_GET["username"];
    $email = strtolower($_GET["email"]);
    $password = $_GET["password"];
    $passwordConfirm = $_GET["confirmPassword"];

    require($_SERVER["DOCUMENT_ROOT"]."/parts/privacy/consentRequirements.php");
    if(!$register_consent_requirements->verifyConsentFormSegement($_GET)) {
        echo '{
            "status": 0,
            "message": "' .$register_consent_requirements->lastError["error"]. '",
            "field": "' . $register_consent_requirements->lastError["field"] . '"
        }';
        exit();
    }

    include_once($_SERVER["DOCUMENT_ROOT"]."/parts/logger.php");
    logger("REGISTER_TRY",$_SERVER['REMOTE_ADDR'],"/logs/","register.log");

    if (strlen($username)  < 6) {
        echo '{
            "status": 0,
            "message": "Username must be at least 6 characters long.",
            "field": "username"
        }';
        exit();
    }

    if ($password != $passwordConfirm){
        echo '{
            "status": 0,
            "message": "Passwords do not match",
            "field": "confirmPassword"
        }';
        exit();
    }

    //Check if it is a sha256 hash, if not, throw in the towel!
    if(!preg_match('/^[A-Fa-f0-9]{64}$/',$password)){
        echo '{
            "status": 0,
            "message": "Passwords is not correct. Please limit to between 5-20 characters, that fall under this set: a-z,0-9,_,-,!,@,#,$,%,^,&,",
            "field": "password"
        }';
        logger("REGISTER_FAIL TYPE:PASS_NOT_HASH",$_SERVER['REMOTE_ADDR'],$_SERVER["DOCUMENT_ROOT"]."/logs/","register.log");
        exit();
    };
     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         echo '{
            "status": 0,
            "message": "Please include a valid email",
            "field": "email"
        }';
         logger("REGISTER_FAIL TYPE:EMAIL",$_SERVER['REMOTE_ADDR'],$_SERVER["DOCUMENT_ROOT"]."/logs/","register.log");
         exit();
     };

    $secretKeys = json_decode(file_get_contents("../../secret/secret.json"));

    //Check for taken username or email
    $userData = $db->prepare("SELECT `username` FROM `users` WHERE `username`:=username");
    $userData->execute(array('username' => $username,"email" => $email,"password" => $password));
    if($userData->rowCount() < 1) {
        echo '{
            "status": 0,
            "message": "This username is already in use",
            "field": "username"
        }';
        exit();
    }

    include("../../parts/database.php");
    $password = password_hash($password,PASSWORD_BCRYPT);
    $userData = $db->prepare("INSERT IGNORE INTO `users` SET `admin`=0,`email`=:email,`password`=:password,`username`=:username");
    $userData->execute(array('username' => $username,"email" => $email,"password" => $password));
    if($userData->rowCount() < 1) {
        echo '{
            "status": 0,
            "message": "Your username or email is already in use",
            "field": "email"
        }';
        exit();
    }
    $userId = $db->lastInsertId("Id");
    //Not the best way to check for results, doing the login check in a query might be bad, but it sure is fast!
        //Set session
        $_SESSION["loggedIn"] = true;
        $_SESSION["userId"] = $userId;
        $_SESSION["admin"] = false;
        //Send status
        logger("REGISTER_SUCCESS DETAILS:[USER_ID:".$userId.";EMAIL:".$email.";USERNAME:".$username."]",$_SERVER['REMOTE_ADDR'],$_SERVER["DOCUMENT_ROOT"]."/logs/","register.log");
        echo '{
            "status": 1,
            "message": "You are registered"
        }';

?>
