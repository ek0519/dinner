<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return 'index';
    }

    public function store(Request $request)
    {
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => $request->all()
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'data' => $request->all(),
            'edit_id' => $id
        ]);
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
