<?php

namespace App\Http\Controllers;

use App\User;
use App\Realtor;
use Carbon\Carbon;
use Facades\App\Feature;
use Facades\App\Property;
use Facades\App\OpenHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Facades\KeriganSolutions\Drone\Mothership;

class PropertySearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $realtor    = (new Realtor())->getProfile();
        $properties = Mothership::search($request);

        return view('properties.index', compact('properties', 'realtor'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($mlsNumber)
    {
        $property   = Mothership::listing($mlsNumber);
        $address    = Property::fullAddress($property); // used for lead generation
        $features   = Feature::list($property);
        $openHouses = OpenHouse::extract($property->open_houses);
        $realtor    = (new Realtor())->getProfile();

        return view(
            'properties.show',
            compact(
                'address',
                'realtor',
                'features',
                'property',
                'openHouses',
                'featuresCount'
            )
        );
    }

}
