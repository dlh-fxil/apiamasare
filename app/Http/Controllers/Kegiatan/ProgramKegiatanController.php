<?php

namespace App\Http\Controllers\Kegiatan;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Models\Kegiatan\ProgramKegiatan;
use App\Http\Requests\Kegiatan\ProgramKegiatanRequest;
use App\Http\Resources\Kegiatan\ProgramKegiatanResource;
use App\Http\Resources\Kegiatan\ProgramKegiatanCollection;

class ProgramKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProgramKegiatanCollection
     */
    public function index()
    {
        $programKegiatan = QueryBuilder::for(ProgramKegiatan::class)
            ->defaultSorts([
                'id',
            ])
            ->allowedIncludes(['unit', 'program', 'kegiatan'])
            ->allowedFilters(
                [
                    'nomenklatur',
                    'kinerja',
                    'indikator',
                    'tahun_anggaran',
                    'biaya',
                    'target_waktu_pelaksanaan',
                    'target_jumlah_hasil',
                    'satuan',
                    'target_waktu_pelaksanaan',
                    'progress',
                    'type',
                    'selesai',
                    AllowedFilter::callback('onlyKegiatanProgram', function ($query, $value) {
                        $query->where(function ($query) use ($value) {
                            $query->where([['kode_sub_kegiatan', null], ['kode_kegiatan', '!=', null], ['kode_program', $value]]);
                        });
                    }),
                    AllowedFilter::callback('onlyProgram', function ($query, $value) {
                        $query->where(function ($query) use ($value) {
                            $query->where('kode_kegiatan',  null);
                        });
                    }),
                    AllowedFilter::exact('type'),
                    AllowedFilter::exact('id_program'),
                    AllowedFilter::exact('id_kegiatan'),
                    AllowedFilter::exact('unit_id'),
                ]
            )
            ->allowedSorts('nomenklatur', 'kinerja', 'indikator', 'tahun_anggaran', 'biaya', 'target_waktu_pelaksanaan', 'target_jumlah_hasil', 'satuan', 'target_waktu_pelaksanaan', 'progress', 'unit_id', 'created_by', 'selesai', 'id', 'kode_urusan', 'kode_bidang_urusan', 'kode_program', 'kode_kegiatan', 'kode_sub_kegiatan', 'updated_at')
            ->cursorPaginate(request()->perPage ?? 10, $columns = ['*'])
            ->withPath(request()->path())
            ->withQueryString()
            ->appends(['sort' => ['id']]);
        return new ProgramKegiatanCollection($programKegiatan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return ProgramKegiatanResource
     */
    public function store(ProgramKegiatanRequest $request)
    {
        $validated = $request->safe()->all();
        $programKegiatan = ProgramKegiatan::create($validated);
        try {
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new ProgramKegiatanResource($programKegiatan))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param ProgramKegiatan $programKegiatan
     * @return ProgramKegiatanResource
     */
    public function show(ProgramKegiatan $programKegiatan)
    {
        return new ProgramKegiatanResource($programKegiatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ProgramKegiatan $programKegiatan
     * @return ProgramKegiatanResource
     */
    public function update(ProgramKegiatanRequest $request, ProgramKegiatan $programKegiatan)
    {
        $validated = $request->safe()->all();
        try {
            $programKegiatan->update($validated);
            if ($validated['type'] === 'program') {
                $data_program = $request->safe()->only('kode_program', 'unit_id');
                ProgramKegiatan::where('id_program', $programKegiatan->id)->update($data_program);
            } elseif ($validated['type'] === 'kegiatan') {
                $kode_kegiatan = $request->safe()->only('kode_kegiatan');
                ProgramKegiatan::where('id_kegiatan', $programKegiatan->id)->update($kode_kegiatan);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new ProgramKegiatanResource($programKegiatan))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProgramKegiatan $programKegiatan
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ProgramKegiatan $programKegiatan)
    {
        try {
            if ($programKegiatan->type == 'program') {
                $total = ProgramKegiatan::where('id_program', $programKegiatan->id)->count();
                if ($total > 0) {
                    return response()->json(['message' => 'Program yang memiliki Kegiatan tidak bisa dihapus'], 403);
                }
            }
            if ($programKegiatan->type == 'kegiatan') {
                $total = ProgramKegiatan::where('id_kegiatan', $programKegiatan->id)->count();
                if ($total > 0) {
                    return response()->json(['message' => 'Kegiatan yang memiliki Sub Kegiatan tidak bisa dihapus'], 403);
                }
            }
            $programKegiatan->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Hapus:Internal Server Error'], 500);
        }
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }

    // public function restore(ProgramKegiatan $programKegiatan)
    // {
    //     try {
    //        programKegiatan->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new ProgramKegiatanResource($programKegiatan))->setMessage('Restored!');
    // }


    // public function forceDelete(ProgramKegiatan $programKegiatan)
    // {
    //     try {
    //        programKegiatan->forceDelete();
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
