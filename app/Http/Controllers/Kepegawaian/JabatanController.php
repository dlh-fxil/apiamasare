<?php

namespace App\Http\Controllers\Kepegawaian;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kepegawaian\JabatanRequest;
use App\Models\Kepegawaian\Jabatan;
use App\Http\Resources\Kepegawaian\JabatanResource;
use App\Http\Resources\Kepegawaian\JabatanCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JabatanCollection
     */
    public function index()
    {
        $jabatan = QueryBuilder::for(Jabatan::class)
          
            ->cursorPaginate(request()->perPage ?? 10, $columns = ['*'])
            ->withPath(request()->path())
            ->withQueryString();
        return new JabatanCollection($jabatan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JabatanResource
     */
    public function store(JabatanRequest $request)
    {
       
        try {
            $validated = $request->safe()->all();
            $jabatan = Jabatan::create($validated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new JabatanResource($jabatan))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Jabatan $jabatan
     * @return JabatanResource
     */
    public function show(Jabatan $jabatan)
    {
        return new JabatanResource($jabatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Jabatan $jabatan
     * @return JabatanResource
     */
    public function update(JabatanRequest $request, Jabatan $jabatan)
    {

        try {
            $jabatan->update($request->safe()->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new JabatanResource($jabatan))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Jabatan $jabatan
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Jabatan $jabatan)
    {
        try {
            $jabatan->delete();
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

    // public function restore(Jabatan $jabatan)
    // {
    //     try {
    //        jabatan->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new JabatanResource($jabatan))->setMessage('Restored!');
    // }


    // public function forceDelete(Jabatan $jabatan)
    // {
    //     try {
    //        jabatan->forceDelete();
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
