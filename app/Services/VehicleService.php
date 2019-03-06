<?php
/**
 * Created by PhpStorm.
 * User: Venkat-Engg
 * Date: 05-03-2019
 * Time: 16:43
 */

namespace App\Services;


use App\AppLogger;
use App\Contracts\VehiclesCrashRatingContract;
use App\Helpers\APILib\API;
use Illuminate\Support\Facades\Config;

class VehicleService
{
    /**
     * @var AppLogger
     */
    protected $log;

    /**
     * @var API
     */
    protected $api;

    /**
     * @var \JsonMapper
     */
    protected $mapper;

    /**
     * VehicleService constructor.
     * @param AppLogger $log
     */
    public function __construct(AppLogger $log)
    {
        $this->log = $log;
        $this->api = new API($this->log);
        $this->mapper = new \JsonMapper();
    }

    /**
     * @param $modelYear
     * @param $manufacturer
     * @param $model
     * @param $withRating
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVehicles($modelYear, $manufacturer, $model, $withRating = false)
    {
        $this->log->addLogDebug('In getVehicles | Input', ['modelYear' => $modelYear, 'manufacturer' => $manufacturer, 'model' => $model]);
        try{
            $url = Config::get('api_urls.GET_VEHICLES');
            $parameters  = ['{MODEL_YEAR}', '{MANUFACTURER}', '{MODEL}'];
            $values  = [$modelYear, $manufacturer, $model];
            $url = str_replace($parameters, $values, $url);
            $apiResponse = $this->api->get($url, []);

            $vehicles = $this->mapper->mapArray($apiResponse->body->Results, [],'App\Contracts\VehiclesContract');
            $this->log->addLogInfo('In getVehicles | vehicles', [$vehicles]);

            if(count($vehicles) > 0 && $withRating == "true")
            {
                foreach ($vehicles as $vehicle)
                {
                    $vehicle->CrashRating = $this->getVehicleCrashRating($vehicle->VehicleId);
                }
            }

            return $vehicles;
        }catch(\Exception $e) {
            $this->log->addLogCritical('In getVehicles | Exception occurred',[$e->getLine(), $e->getMessage(), $e->getFile()]);
            $this->log->addLogDebug('In getVehicles | Exiting', []);

            throw $e;
        }
    }

    /**
     * @param $vehicleId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getVehicleCrashRating($vehicleId)
    {
        try{
            $url = Config::get('api_urls.GET_VEHICLE_CRASH_RATING');
            $url = str_replace("{VEHICLE_ID}", $vehicleId, $url);

            $apiResponse = $this->api->get($url, []);

            return $this->mapper->map($apiResponse->body->Results[0],new VehiclesCrashRatingContract())->crashRating;
        }catch(\Exception $e) {
            $this->log->addLogCritical('In getVehicleCrashRating | Exception occurred',[$e->getLine(), $e->getMessage(), $e->getFile()]);
            $this->log->addLogDebug('In getVehicleCrashRating | Exiting', []);

            throw $e;
        }

    }
}
