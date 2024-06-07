<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Traits\HttpResponses;

class ServiceController extends Controller
{
    use HttpResponses;

    public function getAllServices()
{
    $services = Service::all()->map(function ($service) {
        $service->photo = asset('storage/' . $service->photo);
        return $service;
    });

    return $this->success($services);
}
}