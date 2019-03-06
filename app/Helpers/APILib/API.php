<?php
/**
 * Created by PhpStorm.
 * User: Venkat-Engg
 * Date: 05-03-2019
 * Time: 17:20
 */

namespace App\Helpers\APILib;


use App\AppLogger;
use GuzzleHttp\Exception\RequestException;

class API implements APIInterface
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client = null;

    /**
     * @var AppLogger
     */
    protected $log;

    /**
     * @var
     */
    private $method ;

    /**
     * @var
     */
    private $payload ;

    /**
     * @var null
     */
    private $url = null ;

    /**
     * @var
     */
    private $headers = [];

    /**
     * API constructor.
     * @param AppLogger $log
     */
    public function __construct(AppLogger &$log)
    {
        $this->client = new \GuzzleHttp\Client();
        $this->log = $log;
    }

    /**
     * @param $url
     * @param $headers
     * @return \stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url, $headers)
    {
        $this->method = "GET" ;
        $this->url = $url ;
        $this->headers = (count($headers) > 0) ? array_values($headers): [];

        return $this->makeRequest() ;
    }

    /**
     * @param $url
     * @param $payload
     * @param $headers
     * @return \stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($url, $payload, $headers)
    {
        $this->method = "POST" ;
        $this->url = $url ;
        $this->payload = $payload ;
        $this->headers = (count($headers) > 0) ? array_values($headers): [];

        return $this->makeRequest() ;
    }

    /**
     * @return \stdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeRequest()
    {
        $this->log->addLogInfo("HTTP Request: URL", [$this->url]) ;
        $this->log->addLogInfo("HTTP Request: METHOD", [$this->method]) ;
        $this->log->addLogInfo("HTTP Request: PAYLOAD", [$this->payload]) ;
        $this->log->addLogInfo("HTTP Request: HEADERS", [$this->headers]) ;

        $obj = new \stdClass() ;

        try{

            if( $this->method == 'GET')
            {
                $responseObj =
                    $this->client->request($this->method, $this->url) ;
            }
            else if($this->method == 'POST')
            {
                $responseObj = $this->client->request(
                    $this->method,
                    $this->url,
                    [
                        'json' => $this->payload,
                        'headers' => $this->headers,
                    ]
                );
            }

            $responseCode = $responseObj->getStatusCode() ;
            $responseBody = json_decode($responseObj->getBody()->getContents()) ;

            $obj->statusCode = $responseCode ;
            $obj->body = $responseBody ;

            $this->log->addLogInfo("HTTP Response: CODE", [$responseCode]) ;
            $this->log->addLogInfo( "Http Response: BODY", [$responseBody] ) ;
        }catch(RequestException $e){

            $this->log->addLogCritical( "Http exception ***", [
                "Payload" => $this->payload,
                "Message" => $e->getMessage(),
                "File" => $e->getFile(),
                "Line" => $e->getLine()]) ;

            $obj->statusCode = 500 ;
            $obj->body = new \stdClass() ;

        }

        return $obj ;
    }
}
