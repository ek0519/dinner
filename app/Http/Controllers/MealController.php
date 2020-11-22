<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $query = Meal::query();

        if ($price = $request->input('price')) {
            $query->where('price', $price);
        }

        if ($meal_name = $request->input('meal_name')) {
            $query->where('meal_name', 'like', '%' . $meal_name . '%');
        }

        $perPage = $request->input('per_page') ?? 15;
        $custom = collect(['status' => Response::HTTP_OK]);
        $data = $custom->merge($query->paginate($perPage)->withQueryString());

        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $meal = Meal::create([
            'meal_name' => $request->input('meal_name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
        ]);
        return $this->successResponse($meal, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        abort(404);

        $meal = Meal::findOrFail($id);

        return $this->successResponse($meal);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        Meal::find($id)->update([
            'meal_name' => $request->input('meal_name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
        ]);
        return $this->successResponse(null, Response::HTTP_OK, 'updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id)
    {
        Meal::find($id)->delete();
        return $this->successResponse(null, Response::HTTP_OK, 'deleted.');
    }
}
