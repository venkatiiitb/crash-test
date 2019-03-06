<?php
/**
 * Created by PhpStorm.
 * User: Venkat-Engg
 * Date: 05-03-2019
 * Time: 21:08
 */

namespace App\Contracts;


class VehiclesContract
{
    public $Description;
    public $VehicleId;

    /**
     * @param mixed $VehicleDescription
     */
    public function setVehicleDescription($VehicleDescription): void
    {
        $this->Description = $VehicleDescription;
    }

    /**
     * @param mixed $VehicleId
     */
    public function setVehicleId($VehicleId): void
    {
        $this->VehicleId = $VehicleId;
    }
}
