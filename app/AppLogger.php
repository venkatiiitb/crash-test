<?php
/**
 * Created by PhpStorm.
 * User: Venkat-Engg
 * Date: 05-03-2019
 * Time: 16:56
 */

namespace App;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppLogger
{
    /**
     * @var Logger
     */
    private $log ;

    /**
     * AppLogger constructor.
     * @param $loggerName
     * @throws \Exception
     */
    public function __construct($loggerName)
    {

        $loggingLevel = 'DEBUG';
        switch($loggingLevel){
            case "DEBUG" : $loggingLevel = Logger::DEBUG;
                break;
            case "INFO" : $loggingLevel = Logger::INFO;
                break;
            case "NOTICE" : $loggingLevel = Logger::NOTICE;
                break;
            case "WARNING" : $loggingLevel = Logger::WARNING;
                break;
            case "ERROR" : $loggingLevel = Logger::ERROR;
                break;
            case "CRITICAL" : $loggingLevel = Logger::CRITICAL;
                break;
            case "ALERT" : $loggingLevel = Logger::ALERT;
                break;
            case "EMERGENCY" : $loggingLevel = Logger::EMERGENCY;
                break;
            default : $loggingLevel = Logger::INFO;
        }

        $fileName = $loggerName."-".date('Y-m-d').'.log' ;
        $this->log = new Logger($loggerName);
        $this->log->pushHandler(new StreamHandler(storage_path('logs/'.$fileName), $loggingLevel,$bubble = true, $filePermission = 0777));
        $this->log->addInfo('New Instance=========================================================>');
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogInfo($note, $arrayMessage = array())
    {
        $this->log->info($note, $arrayMessage) ;
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogError($note, $arrayMessage = array())
    {
        $this->log->error($note, $arrayMessage) ;
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogCritical($note, $arrayMessage = array())
    {
        $this->log->critical($note, $arrayMessage) ;
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogDebug($note, $arrayMessage = array())
    {
        $this->log->critical($note, $arrayMessage) ;
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogNotice($note, $arrayMessage =  array())
    {
        $this->log->notice($note, $arrayMessage) ;
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogWarning($note, $arrayMessage =  array())
    {
        $this->log->warning($note, $arrayMessage) ;
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogAlert($note, $arrayMessage =  array())
    {
        $this->log->alert($note, $arrayMessage) ;
    }

    /**
     * @param $note
     * @param array $arrayMessage
     */
    public function addLogEmergency($note, $arrayMessage =  array())
    {
        $this->log->emergency($note, $arrayMessage) ;
    }
}
