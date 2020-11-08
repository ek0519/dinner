<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index(Request $request)
    {
        return 'index';
    }

    public function store(Request $request)
    {
        return 'store';
    }

    public function update(Request $request)
    {
        return 'update';
    }

    public function show(Request $request, int $id)
    {
        return response()->json([
            'id'=> $id
    ], 200);
    }

    public  function destroy(Request $request, int $id)
    {
        return response()->json([
            'id'=> $id
        ], 200);
    }
}
