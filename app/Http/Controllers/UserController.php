<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        $search_fields = ['name', 'mobile', 'email', 'status'];

        foreach ($search_fields as $item) {
            if ($field = $request->input($item)) {
                $query->where($item, $field);
            }
        }

        $perPage = $request->input('per_page') ?? 15;

        return $query->paginate($perPage)->withQueryString();

    }

    public function store(AddUser $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        return $this->successResponse($user);
    }

    public function update(UpdateUser $request, int $id)
    {
        $validated = $request->validated();
        $status = User::findOrFail($id)->update($validated);
        if ($status) {
            return $this->successResponse(null, Response::HTTP_OK, 'updated');
        }
        return $this->errorResponse(Response::HTTP_SERVICE_UNAVAILABLE, 'update fail');
    }

    public function show(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        dd($user);
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
