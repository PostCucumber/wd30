<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Facades\KeriganSolutions\Drone\Mothership;

class FrontPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $realtor = User::realtor();
        $realtor->listings = Mothership::agentListings($realtor->mls_id);
        return view('StaticPages.front', compact('realtor'));
    }
}
