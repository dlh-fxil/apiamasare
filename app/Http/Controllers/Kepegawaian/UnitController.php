<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use App\Models\Kepegawaian\Unit;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\Kepegawaian\UnitResource;
use App\Http\Requests\Kepegawaian\UnitRequest;
use App\Http\Resources\Kepegawaian\UnitCollection;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UnitCollection
     */
    public function index(Request $request)
    {
        $unit = QueryBuilder::for(Unit::class)
            // ->allowedIncludes(['pegawai.unit', 'permissions', 'roles.permissions'])
            // ->allowedFilters([
            //     'name', 'email',
            //     AllowedFilter::callback('search', function ($query, $value) {
            //         $query->where(function ($query) use ($value) {
            //             $query->where('name', 'LIKE', "%{$value}%")->orWhere('email', 'LIKE', "%{$value}%");
            //         });
            //     }),
            //     AllowedFilter::trashed()->default('none')
            //     // AllowedFilter::scope('deleted')->default(true),
            // ])->allowedSorts('name', 'email')
            ->cursorPaginate(request()->perPage ?? 10, $columns = ['*'])
            ->withPath(request()->path())
            ->withQueryString();
        return new UnitCollection($unit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return UnitResource
     */
    public function store(UnitRequest $request)
    {
        $validated = $request->safe()->all();
        try {
            $unit = Unit::create($validated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new UnitResource($unit))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Unit $unit
     * @return UnitResource
     */
    public function show(Unit $unit)
    {
        return new UnitResource($unit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Unit $unit
     * @return UnitResource
     */
    public function update(UnitRequest $request, Unit $unit)
    {

        try {
            $unit->update($request->safe()->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new UnitResource($unit))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Unit $unit
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }

    // public function restore(Unit $unit)
    // {
    //     try {
    //        unit->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new UnitResource($unit))->setMessage('Restored!');
    // }


    // public function forceDelete(Unit $unit)
    // {
    //     try {
    //        unit->forceDelete();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Permanent Deleted!',
    //         'meta' => null,
    //         'errors' => null
    //     ], 200);
    // }

}
