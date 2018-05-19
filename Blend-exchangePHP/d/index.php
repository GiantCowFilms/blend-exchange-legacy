<?php
    //Get file
    //$blob = file_get_contents("../document.txt");
    //$blob = fopen($_FILES['file']['tmp_name'], "rb");
    //Get Oauth keys
    $secretKeys = json_decode(file_get_contents("../secret/secret.json"));
    $Key = $secretKeys->key;
    $Cid = $secretKeys->cid;
    $Secret = $secretKeys->secret;
    $AccessToken = $secretKeys->accessToken;
    $RefreshToken = $secretKeys->refreshToken;

    //Load dropbox library
    require_once '../Google_Drive_Api/autoload.php';

    $client = new Google_Client();
    // Get your credentials from the console
    $client->setClientId($Cid);
    $client->setClientSecret($Secret);
    $AccessTokenJson = '{
        "access_token": "' . $AccessToken . '",
        "token_type": "Bearer",
        "expires_in": 3600,
        "refresh_token": "' . $RefreshToken . '",
        "created": 1424627698
    }';
    $client->setAccessToken($AccessTokenJson);

    $service = new Google_Service_Drive($client);

    $blendId = $_GET["blendId"];

    //include("../parts/database.php");

    //$blendData = $db->prepare("SELECT `id`, `fileName`, `fileGoogleId`, `flags`, `views`, `downloads`, `password`, `uploaderIp`, `questionLink`, `fileSize`,`deleted` FROM `blends` WHERE `id`= :id");
    //$blendData->execute(array('id' => $blendId));
    //$blendData = $blendData->fetchAll(PDO::FETCH_ASSOC)["0"];

    ////Check if file was deleted
    //if ($blendData["deleted"] == 1) {
    //    echo "            <div class=\"noticeWarning nwDanger bodyStack\">
    //                This file was deleted.
    //            </div>";
    //    exit();
    //}

    require_once '../parts/blend/BlendFile.php';

    $blend = BlendFile::getWithId($blendId);

    $blend->load(['fileName', 'fileGoogleId', 'flags', 'views', 'downloads', 'password', 'uploaderIp', 'questionLink', 'fileSize','deleted']);

        //New better download counter

    //Get IP adress
    $ipAdress = $_SERVER['REMOTE_ADDR'];
    $ipAdress = hash("sha256", $ipAdress, false);

    $referingAdress = '';
    if(isset($_SERVER['HTTP_REFERER'])) {
        $referingAdress = $_SERVER['HTTP_REFERER'];
        //Process URL to get rid of stuff after the last slash
        $notBlank = strlen($referingAdress) > 0;
        $matches = [];
        if (preg_match('/^http:\/\/blender.stackexchange.com\/questions\/[0-9]+\/[a-z0-9-]+/', $referingAdress, $matches)){
            $referingAdress = $matches["0"];
        }
    }

    $db->prepare("INSERT INTO `accesses` SET `ref`=:ref, `type`='download', `ip`='".$ipAdress."', `fileId`=:fileId, `date`=NOW()")->execute(array("fileId" => $blendId,'ref' => $referingAdress));

    $file = $service->files->get($blend->fileGoogleId);
    $request = new Google_Http_Request($file->getDownloadUrl(), 'GET', null, null);
    $SignhttpRequest = $client->getAuth()->sign($request);
    $httpRequest = $client->getIo()->makeRequest($SignhttpRequest);

    //Set header

    header('Content-type:  application/x-blender');

    echo $httpRequest->getResponseBody();

?>0