<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kepegawaian\PangkatRequest;
use App\Models\Kepegawaian\Pangkat;
use App\Http\Resources\Kepegawaian\PangkatResource;
use App\Http\Resources\Kepegawaian\PangkatCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PangkatCollection
     */
    public function index()
    {
        $pangkat = QueryBuilder::for(Pangkat::class)
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
        return new PangkatCollection($pangkat);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return PangkatResource
     */
    public function store(PangkatRequest $request)
    {
        $validated = $request->safe()->all();
        try {
            $pangkat = Pangkat::create($validated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new PangkatResource($pangkat))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Pangkat $pangkat
     * @return PangkatResource
     */
    public function show(Pangkat $pangkat)
    {
        return new PangkatResource($pangkat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Pangkat $pangkat
     * @return PangkatResource
     */
    public function update(PangkatRequest $request, Pangkat $pangkat)
    {

        try {
            $pangkat->update($request->safe()->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new PangkatResource($pangkat))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Pangkat $pangkat
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Pangkat $pangkat)
    {
        try {
            $pangkat->delete();
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

    // public function restore(Pangkat $pangkat)
    // {
    //     try {
    //        pangkat->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new PangkatResource($pangkat))->setMessage('Restored!');
    // }


    // public function forceDelete(Pangkat $pangkat)
    // {
    //     try {
    //        pangkat->forceDelete();
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
