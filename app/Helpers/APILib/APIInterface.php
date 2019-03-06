<?php
/**
 * Created by PhpStorm.
 * User: Venkat-Engg
 * Date: 05-03-2019
 * Time: 17:20
 */

namespace App\Helpers\APILib;


interface APIInterface
{
    public function makeRequest() ;
    public function post($url, $payload, $headers) ;
    public function get($url, $headers) ;
}
