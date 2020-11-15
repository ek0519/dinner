<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::where('status', 1)->paginate(5);
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
        $user = User::findOrFail($id);
        return response()->json([
            'status' => 200,
            'data'   => $user
        ], 200);
    }

    public function destroy(Request $request, int $id)
    {
        return response()->json([
            'id' => $id
        ], 200);
    }
}
