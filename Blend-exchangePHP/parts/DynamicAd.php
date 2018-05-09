<?php

/**
 * DynamicAd short summary.
 *
 * DynamicAd description.
 *
 * @version 1.0
 * @author GiantCowFilms
 */
class DynamicAd {

    public $textSettings;
    public $getText;
    public $imageName;
    public $x;
    public $y;
    public $align;
    //Read from disk
    public $image;
    public $font;
    public $cacheText;

    public function __construct($x,$y, $align = 'left', array $textSettings, $imageName, $getText, $cacheText = true, $font = "RalewayBold.ttf")
    {
        $this->x = $x;
        $this->y = $y;
        $this->textSettings = $textSettings;
        $this->imageName = $imageName;
        $this->getText = $getText;
        $this->align = $align;
        $this->font = $font;
        $this->cacheText = $cacheText;
    }

    public function setCachedValue() {
        if (!is_dir('./cache')) {
            // dir doesn't exist, make it
            mkdir('./cache');
        }
        $cacheData = [
            "expires" => time() + 24 * 60 * 60,
            "value" => call_user_func($this->getText),
        ];
        $val = var_export($cacheData,true);
        $cacheValue = '<?php $val = ' . $val . ';';
        $cacheFileName = $this->imageName . '-cache';
        file_put_contents('./cache/'.$cacheFileName,$cacheValue,LOCK_EX);
        return $cacheData["value"];
    }

    public function getCachedValue()
    {
        $cacheFileName = $this->imageName . '-cache';
        if (file_exists('./cache/' . $cacheFileName)) {
            //based on https://blog.graphiq.com/500x-faster-caching-than-redis-memcache-apc-in-php-hhvm-dcd26e8447ad
            //Requires opcache.max_files and memory_consumption to be increased in ini file. Overuse of memroy my cause crashes, so be careful
            @include './cache/' . $cacheFileName;
            if ($val["expires"] < time()) {
                $value = $this->setCachedValue();
            } else {
                $value = $val["value"];
            }
        } else {
            $value = $this->setCachedValue();
        }
        return $value;
    }

    public function getString( )
    {
        //$this->getText(); *should* work but doesn't D:
        if($this->cacheText) {
            $value = $this->getCachedValue();
        } else {
            $value = call_user_func($this->getText);
        }
        return $value;
    }

    public function drawAdd( )
    {
        if($this->align = 'center'){
            $bounds = imagettfbbox($this->textSettings["size"], 0, $this->getResources( )["font"], $this->getString());

            $this->x = ceil((imagesx($this->getResources( )["image"]) - $bounds[2]) / 2);
        }

        $resources = $this->getResources();
        $this->image = $this->getResources( )["image"];
	    imagettftext(
                $this->image,
                $this->textSettings["size"],
                0,
                $this->x,
                $this->y,
                imagecolorallocate($this->image,
                    $this->textSettings["color"]["red"],
                    $this->textSettings["color"]["blue"],
                    $this->textSettings["color"]["green"]
                ),
                $this->getResources( )["font"],
                $this->getString()
        );
        return $this->image;
    }

    public function getResources( )
    {
        if(!isset($this->image)){
            $this->image = imagecreatefrompng("./img/".$this->imageName.".png");
        }
	    return [
            'image' => $this->image,
            'font' => "./fonts/".$this->font
        ];
    }
}