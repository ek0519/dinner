<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMeal;
use App\Http\Requests\UpdateMeal;
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
     * @param AddMeal $request
     * @return JsonResponse
     */
    public function store(AddMeal $request): JsonResponse
    {
        $validated = $request->validated();
        $extension = $request->file('meal_img')->extension();
        $filename = hash_file('sha256', $request->file('meal_img')->getRealPath());
        $path = $request->file('meal_img')->storePubliclyAs('meals', "{$filename}.{$extension}", 'public');
        $validated['meal_img'] = $path;
        $meal = Meal::create($validated);
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
        $meal = Meal::findOrFail($id);
        return $this->successResponse($meal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMeal $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateMeal $request, int $id)
    {
        $validated = $request->validated();

        Meal::find($id)->update($validated);
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
