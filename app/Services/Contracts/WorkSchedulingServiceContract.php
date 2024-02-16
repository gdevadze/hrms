<?php

namespace App\Services\Contracts;

use App\Models\User;

interface WorkSchedulingServiceContract
{
    public function init($userId, $month = null, $year = null);

    public function calculateEmployeeLateIncomes($userId = null, $month = null, $year = null);
    public function calculateEmployeeGoEarly($userId = null, $month = null, $year = null);


    public function calculateEmployeeWorkingAndMissedDays($userId = null, $month = null, $year = null);

    public function calculateTotalWorkingTime($userId = null, $month = null, $year = null);

    public function getUser():User;

    public function fetchUserMovements($userId = null, $month = null, $year = null);
}
