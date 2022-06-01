<?php

namespace App\Http\Controllers\Kepegawaian;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\Kepegawaian\UraianTugas;
use App\Http\Resources\Kepegawaian\UraianTugasResource;
use App\Http\Requests\Kepegawaian\UraianTugasRequest;
use App\Http\Resources\Kepegawaian\UraianTugasCollection;

class UraianTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UraianTugasCollection
     */
    public function index(Request $request)
    {
        $uraianTuga = QueryBuilder::for(UraianTugas::class)
            // ->allowedIncludes(['pegawai.unit', 'permissions', 'roles.permissions'])
            ->defaultSort('-updated_at')
            ->allowedFilters([
               AllowedFilter::exact('id'),
            ])
            ->cursorPaginate($request->perPage ?? 10, $columns = ['*']);
        return new UraianTugasCollection($uraianTuga);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return UraianTugasResource
     */
    public function store(UraianTugasRequest $request)
    {
        $validated = $request->safe()->all();
        try {
            $uraianTuga = UraianTugas::create($validated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new UraianTugasResource($uraianTuga))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param UraianTugas $uraianTuga
     * @return UraianTugasResource
     */
    public function show(UraianTugas $uraianTuga)
    {
        return new UraianTugasResource($uraianTuga);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UraianTugas $uraianTuga
     * @return UraianTugasResource
     */
    public function update(UraianTugasRequest $request, UraianTugas $uraianTuga)
    {
        try {
            $uraianTuga->update($request->safe()->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new UraianTugasResource($uraianTuga))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UraianTugas $uraianTuga
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(UraianTugas $uraianTuga)
    {
        try {
            $uraianTuga->delete();
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

    // public function restore(UraianTugas $uraianTuga)
    // {
    //     try {
    //        uraianTugas->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new UraianTugasResource($uraianTuga))->setMessage('Restored!');
    // }


    // public function forceDelete(UraianTugas $uraianTuga)
    // {
    //     try {
    //        uraianTugas->forceDelete();
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
