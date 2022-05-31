<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Kepegawaian\SubUnit;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\Kepegawaian\SubUnitResource;
use App\Http\Requests\Kepegawaian\SubUnitRequest;
use App\Http\Resources\Kepegawaian\SubUnitCollection;

class SubUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return SubUnitCollection
     */
    public function index(Request $request)
    {
        $subUnit = QueryBuilder::for(SubUnit::class)
            // ->allowedIncludes(['pegawai.unit', 'permissions', 'roles.permissions'])
            ->allowedFilters([
                'name', 'email',
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('name', 'LIKE', "%{$value}%")->orWhere('email', 'LIKE', "%{$value}%");
                    });
                }),
                // AllowedFilter::trashed()->default('none')
                AllowedFilter::exact('unit_id')
                // AllowedFilter::scope('deleted')->default(true),
            ])->allowedSorts('name', 'email')
            ->cursorPaginate($request->perPage ?? 10, $columns = ['*']);
        return new SubUnitCollection($subUnit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return SubUnitResource
     */
    public function store(SubUnitRequest $request)
    {
        $validated = $request->safe()->all();
        try {
            $subUnit = SubUnit::create($validated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new SubUnitResource($subUnit))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param SubUnit $subUnit
     * @return SubUnitResource
     */
    public function show(SubUnit $subUnit)
    {
        return new SubUnitResource($subUnit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SubUnit $subUnit
     * @return SubUnitResource
     */
    public function update(SubUnitRequest $request, SubUnit $subUnit)
    {

        try {
            $subUnit->update($request->safe()->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new SubUnitResource($subUnit))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SubUnit $subUnit
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(SubUnit $subUnit)
    {
        try {
            $subUnit->delete();
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

    // public function restore(SubUnit $subUnit)
    // {
    //     try {
    //        subUnit->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new SubUnitResource($subUnit))->setMessage('Restored!');
    // }


    // public function forceDelete(SubUnit $subUnit)
    // {
    //     try {
    //        subUnit->forceDelete();
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
