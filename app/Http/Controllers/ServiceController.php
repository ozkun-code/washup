<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use App\Models\Service;
use App\Traits\HttpResponses;

class ServiceController extends Controller
{
    use HttpResponses;

    public function getAllServices()
    {
        // Tentukan kunci cache
        $cacheKey = 'services_all';

        // Cek apakah data sudah ada di cache
        $services = Redis::get($cacheKey);

        if (!$services) {
            // Data tidak ditemukan di cache, ambil dari database
            $services = Service::all()->map(function ($service) {
                $service->photo = asset('storage/' . $service->photo);
                return $service;
            });

            // Simpan data ke cache
            Redis::set($cacheKey, $services->toJson(), 'EX', 3600); // Cache selama 1 jam
        } else {
            // Data ditemukan di cache, decode JSON ke array/object
            $services = json_decode($services);
        }

        return $this->success($services);
    }
}