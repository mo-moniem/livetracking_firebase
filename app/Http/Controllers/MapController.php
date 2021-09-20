<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function mapMarkers(){
        $branches = [
            ["title"=>"Bondi Beach", "lat"=>33.890542, "lng"=>100.274856, "index"=>4],
            ["title"=>"Cronulla Beach", "lat"=>34.028249, "lng"=>101.157507, "index"=>3],
            ["title"=>"Manly Beach", "lat"=>33.80010128657071, "lng"=>121.28747820854187, "index"=>2],
            ["title"=>"Maroubra Beach", "lat"=>33.950198, "lng"=>131.259302, "index"=>1],
        ];
//        $branches = json_encode($branches);
        return view('map',compact('branches'));
    }
}
