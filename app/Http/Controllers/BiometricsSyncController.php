<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BioSyncService;

class BiometricsSyncController extends Controller
{
    public function syncBiomtricsDB(Request $request, BioSyncService $bioSyncService) {
        $bioSyncService->init($request->type, $request->userid, $request->datefrom, $request->dateto);
    }
}
