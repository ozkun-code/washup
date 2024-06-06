<?php

namespace App\Http\Controllers;

use App\Models\StatusLog;
use App\Traits\HttpResponses;

use Illuminate\Http\Request;

class ResiController extends Controller
{
    use HttpResponses;

    public function getResi($transaksiId)
    {
        $resi = StatusLog::where('transaksi_id', $transaksiId)->get();



        return $this->success($resi);
}
}