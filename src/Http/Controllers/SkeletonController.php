<?php

namespace VendorName\Skeleton\Http\Controllers;

use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
// use Inertia\Inertia;

class SkeletonController extends Controller
{
    //
    public function add($a, $b)
    {
        return $a + $b;
    }
    // {
    //     return view('skeleton::index');
    // }

    public function index($a, $b)
    // public function index()
    {
        return $a + $b;
        // return Inertia::render(
        //     'Index',
        //     ['posts' => Post::all()]
        // );
    }
}
