<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Property;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller {

    public function get_county(Request $request) {
        $city = !empty($request->city) ? $request->city : '';
        if ($city == '') {
            echo '0';
            exit();
        }
        //$city = Input::get('city');
        $sql = "SELECT LIST_41
                FROM `rets_property_listing_test`
                WHERE LIST_39 != '' AND LIST_41 != '' AND LIST_39 = '" . $city . "' 
                LIMIT 1";
        $result = DB::select($sql);

        if ($result !== false && count($result)) {
            echo $result[0]->LIST_41;
        } else {
            echo '0';
        }
    }

    public function get_cities_by_county(Request $request) {
        $county = !empty($request->county) ? $request->county : '0';

        if ($county == '0') {
            $results = Property::orderby('LIST_39', 'asc')->distinct()->get(['LIST_39']);
        } else {
            $results = Property::where('LIST_41', $county)->distinct()->orderby('LIST_39', 'asc')->get(['LIST_39']);
        }

        $cities = [];
        foreach ($results as $city) {
            $cities[] = $city->LIST_39;
        }

        echo json_encode($cities);
    }

    public function get_zipcode(Request $request) {

        if (!isset($request->zipcode)) {
            echo '{}';
            return;
        }

        $zipcode = $request->zipcode;
        $clientCode = 'JRYe6hLBIOrfRkfweFQa79tTKUPIVy1Fq0TwhE80tzflTvS8bJjjTMcDG1lCznhZ';

        if (strlen($zipcode) == 0) {
            echo '{}';
            return;
        }

        $url = "https://www.zipcodeapi.com/rest/" . $clientCode . "/info.json/" . $zipcode . "/radians";

        $result = file_get_contents($url, true);

        echo $result;
    }

}
