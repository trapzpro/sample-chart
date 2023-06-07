<?php

namespace App\Http\Controllers\Api;

use App\Services\CmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;


class CmsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function states(Request $request)
    {
        $states = Cache::rememberForever('states', function () {
            $cmsService = new CmsService();
            return $cmsService->getStates();
        });
        //return a json respons of the array
        return  $states;
    }

    public function chartForState(Request $request)
    {
        $state = $request->input('state');
        $chart = Cache::rememberForever('chart'.$state, function () use ( $state ) {
            $cmsService = new CmsService();
            return $cmsService->chartForState( $state );
        });
        return $chart;
    }

    public function combinedChartForState(Request $request)
    {
        $state = $request->input('state');
        $chart = Cache::rememberForever('combinedchart'.$state, function () use ( $state ) {
            $cmsService = new CmsService();
            return $cmsService->combinedChartForState( $state );
        });
        return $chart;
    }




}
