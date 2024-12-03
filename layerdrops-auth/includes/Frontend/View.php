<?php
namespace Layerdrops\Auth\Frontend;
use Google\Client;

class View{

    function __construct(){
        $client = new Client();
        
        var_dump( $client);
    }
}