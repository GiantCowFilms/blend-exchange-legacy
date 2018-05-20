<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/Google_Drive_Api/autoload.php');
require_once("../parts/database.php");
/**
 * BlendFile short summary.
 *
 * BlendFile description.
 *
 * @version 1.0
 * @author GiantCowFilms
 */

class BlendFile
{
    public $drive_service;
    public $id;
    private $properties = [];

    public function __construct($google_drive_service,$id = null) {
        $this->drive_service = $google_drive_service;
        $this->id = $id;
    }

    public static function createFromUpload($google_drive_service,$file) {
        $debug = false;

        $drive_file = new Google_Service_Drive_DriveFile();
        $drive_file->setTitle($file['name']);
        $drive_file->setDescription('Blend-Exchange User File');
        $drive_file->setMimeType('application/x-blender');

        $data = fopen($file['tmp_name'],"rb");
        $dataSize = filesize($file['tmp_name']);

        $google_drive_service->getClient()->setDefer(true);
        $request = $google_drive_service->files->insert($drive_file);

        //Set size of chuncks for upload
        $chunkSizeBytes = 1 * 1024 * 1024;

        // Create a media file upload to represent our upload process.
        $media = new Google_Http_MediaFileUpload(
          $google_drive_service->getClient(),
          $request,
          'application/octet-stream',
          null,
          true,
          $chunkSizeBytes
        );
        $media->setFileSize($dataSize);

        //Avoid uploading billions of teset files when debugging
        if (!$debug) {

            // Upload the various chunks. $status will be false until the process is
            // complete.
            $status = false;
            $handle = $data;
            while (!$status && !feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                $status = $media->nextChunk($chunk);
            }

            // The final value of $status will be the data from the API for the object
            // that has been uploaded.
            $result = false;
            if($status != false) {
                $result = $status;
            }

            fclose($handle);
            // Reset to the client to execute requests immediately in the future.
            $google_drive_service->getClient()->setDefer(false);

            if(!$result) {
                throw new Error("File upload failed (API Failure)");
                return;
            }

            $createdFile = $result;
        } else {
            $createdFile = new stdClass();
            $createdFile->id = 'demo file';
        }

        $blend = new BlendFile($google_drive_service);
        $blend->fileGoogleId = $createdFile->id;
        $blend->fileSize = $dataSize;
        $blend->fileName = $file["name"];
        $blend->views = 0;
        $blend->downloads = 0;
        $blend->deleted = 0;
        $blend->flags = '';
        $blend->adminComment = '';
        $blend->date = date('Y-m-d H:i:s');
        $blend->valid = 0;
        return $blend;
    }

    public static function getWithId($id,$google_drive_service = null) {
        $blend = new BlendFile($google_drive_service,$id);
        return $blend;
    }

    public function loadFavorites () {
        global $db;
        $rows = $db->prepare("SELECT `ip` FROM `accesses` WHERE `type`='favorite' AND `fileId`=:fileId");
        $rows->execute(array('fileId' => $this->id));
        $rows = $rows->rowCount();
        $this->properties["favorites"] = $rows;
    }

    public function loadFlags () {
        global $db;
        $rows = $db->prepare("SELECT `ip`,`id`,`val`,`accept` FROM `accesses` WHERE `type`='flag' AND `fileId`=:fileId");
        $rows->execute(array('fileId' => $this->id));
        $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
        $this->properties["flags"] = $rows;
    }

    public function loadDownloads () {
        global $db;
        $rows = $db->prepare("SELECT `ip` FROM `accesses` WHERE `type`='download' AND `fileId`=:fileId");
        $rows->execute(array('fileId' => $this->id));
        $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
        $ips = [];
        foreach ($rows as $key => $row)
        {
            $remove = false;
            foreach ($ips as $ip)
            {
                if($ip == $row["ip"]){
                    unset($rows[$key]);
                    $remove = true;
                    break;
                }
            }
            if($remove == false){
                $ips[] = $row["ip"];
            }
        }

        $this->properties["downloads"] = count($rows);
    }



    public function loadViews () {
        global $db;
        //Read download count
        $rows = $db->prepare("SELECT `ip` FROM `accesses` WHERE `type`='view' AND `fileId`=:fileId");
        $rows->execute(array('fileId' => $this->id));
        $rows = $rows->fetchAll(PDO::FETCH_ASSOC);
        $ips = [];
        foreach ($rows as $key => $row)
        {
            $remove = false;
            foreach ($ips as $ip)
            {
                if($ip == $row["ip"]){
                    unset($rows[$key]);
                    $remove = true;
                    break;
                }
            }
            if($remove == false){
                $ips[] = $row["ip"];
            }
        }
        $this->properties["views"] = count($rows);
    }

    public function load($params) {
        global $db;
        $query = 'SELECT ';
        $getting_query = '';
        foreach ($params as $param) {
        $getting_query = $getting_query . ' `'.$param.'`,';
        }
        $getting_query = substr($getting_query,0,-1); //Remove last comma
        $query = $query . $getting_query . ' FROM `blends` WHERE `id`=:id';
        $blendData = $db->prepare($query);
        $blendData->execute(array('id' => $this->id));
        if($blendData->rowCount() == 0) {
            return false;
        }
        $blendData = $blendData->fetchAll(PDO::FETCH_ASSOC)["0"];
        foreach ($params as $param) {
            $this->properties[$param] = $blendData[$param];
        }
        return true;
    }

    public function __set ($name,$value) {
        $this->properties[$name] = $value;
    }

    public function __get ($name) {
        return $this->properties[$name];
    }

    public function save() {
        global $db;
        //$this->properties['id'] = $this->id;
        //unset($this->properties['id'] );
        //unset($this->properties['fileGoogleId'] );
        ////unset($this->properties['fileName'] );
        //unset($this->properties['views'] );
        //unset($this->properties['downloads'] );
        //unset($this->properties['deleted'] );
        //unset($this->properties['flags'] );
        //unset($this->properties['adminComment'] );
        //unset($this->properties['date'] );
        //unset($this->properties['uploaderIp'] );
        //unset($this->properties['questionLink'] );
        //unset($this->properties['password'] );
        //unset($this->properties['owner'] );
        //unset($this->properties['fileSize'] );

        $query = 'INSERT INTO `blends` SET `id`=NULL,';
        $setting_query = '';
        foreach ($this->properties as $prop => $value) {
            $setting_query = $setting_query . ' `'.$prop.'`=:'.$prop.',';
        }
        $setting_query = substr($setting_query,0,-1); //Remove last comma
        $updating_query = '';
        foreach ($this->properties as $prop => $value) {
            $updating_query = $updating_query . ' `'.$prop.'`=VALUES('.$prop.'),';
        }
        $updating_query = substr($updating_query,0,-1); //Remove last comma
        $blendId = 'NULL';
        if($this->id !== null) {
            $blendId = $this->id;
        }
        $query = $query . $setting_query . ' ON DUPLICATE KEY UPDATE `id`='.$blendId.',' . $updating_query;
        $db->prepare($query)->execute($this->properties);
    }
}