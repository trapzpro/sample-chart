<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CmsService
{


    public function retrieveProcedureDataForState($state, bool $useCache = true): array
    {
        // Started a helper to build these just like using eloquent query builder, its in helpers folder
        // for now is hardcoded:
        /* OpenData API JSON:API style filter query string for
            filter[root-group][group][conjunction]: AND
            filter[group-0][group][conjunction]: AND
            filter[group-0][group][memberOf]: root-group
            filter[filter-0-0][condition][path]: Rndrng_Prvdr_Geo_Lvl
            filter[filter-0-0][condition][operator]: =
            filter[filter-0-0][condition][value]: State
            filter[filter-0-0][condition][memberOf]: group-0
            filter[filter-0-1][condition][path]: Rndrng_Prvdr_Geo_Desc
            filter[filter-0-1][condition][operator]: =
            filter[filter-0-1][condition][value]: $state
            filter[filter-0-1][condition][memberOf]: group-0
            filter[filter-0-2][condition][path]: HCPCS_Cd
            filter[filter-0-2][condition][value][0]: 11043
            filter[filter-0-2][condition][value][1]: 11043
            filter[filter-0-2][condition][value][2]: 11044
            filter[filter-0-2][condition][value][3]: 11045
            filter[filter-0-2][condition][value][4]: 11046
            filter[filter-0-2][condition][value][4]: 11047
            filter[filter-0-2][condition][memberOf]: group-0
                    */
        $filterByGeoLevelProcedures = 'filter[root-group][group][conjunction]=AND&filter[group-0][group][conjunction]=AND&filter[group-0][group][memberOf]=root-group&filter[filter-0-0][condition][path]=Rndrng_Prvdr_Geo_Lvl&filter[filter-0-0][condition][operator]==&filter[filter-0-0][condition][value]=State&filter[filter-0-0][condition][memberOf]=group-0&filter[filter-0-1][condition][path]=Rndrng_Prvdr_Geo_Desc&filter[filter-0-1][condition][operator]==&filter[filter-0-1][condition][value]='.$state.'&filter[filter-0-1][condition][memberOf]=group-0&filter[filter-0-2][condition][path]=HCPCS_Cd&filter[filter-0-2][condition][value][0]=11043&filter[filter-0-2][condition][value][1]=11043&filter[filter-0-2][condition][value][2]=11044&filter[filter-0-2][condition][value][3]=11045&filter[filter-0-2][condition][value][4]=11046&filter[filter-0-2][condition][value][5]=11047&filter[filter-0-2][condition][operator]=IN&filter[filter-0-2][condition][memberOf]=group-0';


        // Build the URL
        $url = 'https://data.cms.gov/data-api/v1/dataset/6fea9d79-0129-4e4c-b1b8-23cd86a4f435/data?'.$filterByGeoLevelProcedures;

        $response =  Http::get($url)->json();


        return $response;
    }

    public function getPrefilteredChartData($state): array
    {
        $data = [];

        // cache for 24 hrs
        $data = Cache::remember('procedure_data_'.$state, 60 * 60 * 24, function () use ($state) {
            // Retrieve the data from the API
            $jsonResponse = $this->retrieveProcedureDataForState($state);


            // filter by procedure
            $jsonResponse = array_filter($jsonResponse, function ($item) {
                return in_array($item['HCPCS_Cd'], array('11043', '11044', '11045', '11046', '11047'));
            });

            // Return the data
            return $jsonResponse;
        });

        return $data;
    }


    // Define a function to return distinct states from the JSON response, optionally limiting to only US states - would need to query api for this distinct list, normal response limits to 1000 records
    public function getStates($includeAll = true)
    {

        // $jsonResponse = $this->getPrefilteredChartData();
        // // Initialize an empty array to store the states
        // $states = array();

        // // Loop through each record in the response
        // foreach ($jsonResponse as $record) {
        //     if ($includeAll || $record['Rndrng_Prvdr_Geo_Cd'] < 57) {
        //         $states[$record['Rndrng_Prvdr_Geo_Desc']] = $record['Rndrng_Prvdr_Geo_Desc'];
        //     }
        // }
        // return $states;


            $states = [
                'Alabama',
                'Alaska',
                'Arizona',
                'Arkansas',
                'California',
                'Colorado',
                'Connecticut',
                'Delaware',
                'District of Columbia',
                'Florida',
                'Georgia',
                'Hawaii',
                'Idaho',
                'Illinois',
                'Indiana',
                'Iowa',
                'Kansas',
                'Kentucky',
                'Louisiana',
                'Maine',
                'Maryland',
                'Massachusetts',
                'Michigan',
                'Minnesota',
                'Mississippi',
                'Missouri',
                'Montana',
                'Nebraska',
                'Nevada',
                'New Hampshire',
                'New Jersey',
                'New Mexico',
                'New York',
                'North Carolina',
                'North Dakota',
                'Ohio',
                'Oklahoma',
                'Oregon',
                'Pennsylvania',
                'Rhode Island',
                'South Carolina',
                'South Dakota',
                'Tennessee',
                'Texas',
                'Utah',
                'Vermont',
                'Virginia',
                'Washington',
                'West Virginia',
                'Wisconsin',
                'Wyoming'
            ];

            return $states;

    }


    // define a funtion to extract data shaped to be compatible with the chart.js library's bar chart dataset and lables
    /*{
    "Rndrng_Prvdr_Geo_Lvl": "National",
    "Rndrng_Prvdr_Geo_Cd": "",
    "Rndrng_Prvdr_Geo_Desc": "National",
    "HCPCS_Cd": "0001A",
    "HCPCS_Desc": "Adm sarscov2 30mcg\/0.3ml 1st",
    "HCPCS_Drug_Ind": "N",
    "Place_Of_Srvc": "F",
    "Tot_Rndrng_Prvdrs": "279",
    "Tot_Benes": "25735",
    "Tot_Srvcs": "26341",
    "Tot_Bene_Day_Srvcs": "26341",
    "Avg_Sbmtd_Chrg": "42.415087886",
    "Avg_Mdcr_Alowd_Amt": "20.884537793",
    "Avg_Mdcr_Pymt_Amt": "20.884537793",
    "Avg_Mdcr_Stdzd_Amt": "20.815809574"
},*/
public function combinedChartForState($state)
{

    // cache for 24 hrs with state as party of key
    $preparedData = Cache::remember('prepared_amt_chart_' . $state, 60 * 60 * 24, function () use ($state) {
        $data= $this->retrieveProcedureDataForState($state);

        // Initialize an empty array to store the data in the format needed for the chart
        $chartData = array(
            'labels' => array(),
            'datasets' => array(

                array(
                    'label' => 'Avg Charge Submitted',
                    'backgroundColor' => '#7d7df8',
                    'data' => array()
                ),
                array(
                    'label' => 'Avg Payment Amount',
                    'backgroundColor' => '#7df8b4',
                    'data' => array()
                ),
                array(
                    'label' => 'Service Count',
                    'backgroundColor' => '#f87979',
                    'data' => array()
                ),

            )
        );

        // Loop through each state in the data
        foreach ($data as $item) {
            // Add the state to the labels array
            $chartData['labels'][] = $item['HCPCS_Cd'];

            // Add the data to the datasets
            $chartData['datasets'][0]['data'][] = $item['Avg_Sbmtd_Chrg'];
            $chartData['datasets'][1]['data'][] = $item['Avg_Mdcr_Pymt_Amt'];
            $chartData['datasets'][2]['data'][] = $item['Tot_Srvcs'];

        }

        $chartData['datasets'][2]['type'] = 'line'; // doesn't make sense as a line, and need to scale differently, but just to show combo type charts

        // Return the chart data
        return $chartData;
    });

    return $preparedData;

}

public function chartForState($state)
{

    // cache for 24 hrs with state as party of key
    $preparedData = Cache::remember('prepared_countchart_' . $state, 60 * 60 * 24, function () use ($state) {
        $data= $this->retrieveProcedureDataForState($state);

        // Initialize an empty array to store the data in the format needed for the chart
        $chartData = array(
            'labels' => array(),
            'datasets' => array(
                array(
                    'label' => 'Service Count',
                    'backgroundColor' => '#f87979',
                    'data' => array()
                ),
            )
        );

        // Loop through each state in the data
        foreach ($data as $item) {
            // Add the state to the labels array
            $chartData['labels'][] = $item['HCPCS_Cd'];

            $chartData['datasets'][0]['data'][] = $item['Tot_Srvcs'];
            Log::info($item);
        }


        // Return the chart data
        return $chartData;
    });

    return $preparedData;

}


    // Define a function to return distinct HCPCS codes from the JSON response
    public function getHCPCSCodes($jsonResponse)
    {
        // Initialize an empty array to store the codes
        $codes = array();

        // Loop through each record in the response
        foreach ($jsonResponse as $record) {
            $codes[$record['HCPCS_Cd']] = $record['HCPCS_Cd'];
        }
        return $codes;
    }

    // Define a function to return the data for a given state
    public function getStateSummaryData($jsonResponse, $state)
    {
        // Initialize an empty array to store the data
        $data = array();

        // Loop through each record in the response
        foreach ($jsonResponse as $record) {
            // Check if the record is for the given state
            if ($record['Rndrng_Prvdr_Geo_Desc'] == $state) {
                // Extract the relevant data for our chart
                $hcpcsCode = $record['HCPCS_Cd'];
                $services = $record['Bene_Day_Serv_Cnt'];
                $avgCharges = $record['Avg_Mdcr_Pymt_Amt'];

                // If we haven't seen this HCPCS code yet, initialize an array for it
                if (!array_key_exists($hcpcsCode, $data)) {
                    $data[$hcpcsCode] = array(
                        'services' => 0,
                        'charges' => 0
                    );
                }

                // Add the data for this record to the HCPCS code's totals
                $data[$hcpcsCode]['services'] += $services;
                $data[$hcpcsCode]['charges'] += $avgCharges;
            }
        }

        return $data;
    }
}
