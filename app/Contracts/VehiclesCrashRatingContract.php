<?php
/**
 * Created by PhpStorm.
 * User: Venkat-Engg
 * Date: 06-03-2019
 * Time: 11:24
 */

namespace App\Contracts;


class VehiclesCrashRatingContract
{
    public $crashRating;

    /**
     * @param mixed $overallRating
     */
    public function setOverallRating($overallRating): void
    {
        $this->crashRating = $overallRating;
    }
}
