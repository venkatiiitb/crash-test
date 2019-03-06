<?php

namespace App\Http\Controllers;

use App\AppLogger;
use App\Helpers\GenericResponseTemplate;
use App\Helpers\StatusCode;
use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{

    /**
     * @var VehicleService
     */
    protected $vehicleService;

    protected $log;

    /**
     * VehiclesController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->log = new AppLogger('VehicleController');
        $this->vehicleService = new VehicleService($this->log);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVehicles(Request $request)
    {
        $modelYear = $request->input('modelYear');
        $manufacturer = $request->input('manufacturer');
        $model = $request->input('model');
        $this->log->addLogDebug('In getVehicles | Input', [
            'modelYear' => $modelYear,
            'manufacturer' => $manufacturer,
            'model' => $model
        ]);

        $response = new GenericResponseTemplate();
        try{
            $vehicles = $this->vehicleService->getVehicles($modelYear, $manufacturer, $model);
            $this->log->addLogDebug('In getVehiclesWithFilters | Vehicles', [$vehicles]);

            $response->Count = count($vehicles);
            $response->Results = $vehicles;

            return response()->json($response, StatusCode::success);
        }catch (\Exception $e)
        {
            return response()->json($response, StatusCode::internalServerError);
        }
    }

    /**
     * @param $modelYear
     * @param $manufacturer
     * @param $model
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVehiclesWithFilters($modelYear, $manufacturer, $model, Request $request)
    {
        $withRating = $request->query('withRating');

        $this->log->addLogDebug('In getVehiclesWithFilters | Input', [
            'modelYear' => $modelYear,
            'manufacturer' => $manufacturer,
            'model' => $model,
            'withRating' => $withRating
        ]);
        $response = new GenericResponseTemplate();

        try{
            $vehicles = $this->vehicleService->getVehicles($modelYear, $manufacturer, $model, $withRating);
            $this->log->addLogDebug('In getVehiclesWithFilters | Response', [$response]);

            $response->Count = count($vehicles);
            $response->Results = $vehicles;

            return response()->json($response, StatusCode::success);
        }catch (\Exception $e)
        {
            return response()->json($response, StatusCode::internalServerError);
        }
    }
}
