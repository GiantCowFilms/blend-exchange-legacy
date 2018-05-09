<?php

//Not strictly speaking part of the blend-exchange functionality, added by request. Still services blender.stackexchange.

//Step one: get data
require_once("../parts/DynamicAd.php");

$communityAdTwo = new DynamicAd(
        0,
        436.7,
       'center',
       [
        'size' => 32,
        'color' => [
            'red' => 255,
            'blue' => 255,
            'green' => 255,
        ]
       ],
       "AnimationNodesAdOne",
       function ( )
       {
           $json = file_get_contents("https://api.stackexchange.com/2.2/tags/animation-nodes/info?order=desc&sort=popular&site=blender");
           $json = gzinflate(substr($json,10,-8));
           $count = json_decode($json)->items[0]->count;

           return $count . " Questions Asked";
       },
       true,
       "RobotoCondensed-Light.ttf"
    );

header('Content-Type: image/png');

echo imagepng($communityAdTwo->drawAdd());

?>