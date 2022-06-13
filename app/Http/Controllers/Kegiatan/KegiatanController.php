<?php

namespace App\Http\Controllers\Kegiatan;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Kegiatan\ItemKegiatan;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\Kegiatan\KegiatanRequest;
use App\Http\Resources\Kegiatan\KegiatanResource;
use App\Http\Resources\Kegiatan\KegiatanCollection;
use App\Http\Requests\Kegiatan\FollowKegiatanRequest;
use App\Models\Kegiatan\UserHasUraianTugas;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return KegiatanCollection
     */
    public function index()
    {
        $kegiatan = QueryBuilder::for(ItemKegiatan::class)->with('unit')
            ->defaultSort('-id')
            ->allowedIncludes(['users', 'userHasUraianTugas','uraianTugas', 'unit', 'units', 'createdBy.jabatan', 'createdBy.unit', 'createdBy.pangkat', 'createdBy.subUnit', 'programKegiatan.unit', 'programKegiatan.program', 'programKegiatan.kegiatan'])
            ->allowedFilters([
                AllowedFilter::callback(
                    'has_user',
                    fn ($query) => $query->whereHas('user')
                ),
                AllowedFilter::callback('user_id', function ($query, $value) {
                    $query->whereHas('users', function ($query) use ($value) {
                        $query->where('id', $value);
                    });
                }),
                AllowedFilter::callback('start', function ($query, $value) {
                    $query->where('mulai', '>=', Carbon::parse($value))->orWhere('selesai', null);
                }),
                AllowedFilter::callback('finish', function ($query, $value) {
                    $query->where('selesai', '<=', Carbon::parse($value))->orWhere('selesai', null);
                }),
                AllowedFilter::callback('unit_id', function ($query, $value) {
                    $query->whereHas('programKegiatan', function ($query) use ($value) {
                        $query->whereHas('unit', function ($query) use ($value) {
                            $query->where('id', $value);
                        });
                    });
                }),

                AllowedFilter::exact('program_kegiatan_id'),
                AllowedFilter::exact('tanggal'),
                AllowedFilter::exact('tahun'),
            ])
            ->allowedSorts('created_at', 'updated_at', 'id', 'judul', 'uraian')
            ->cursorPaginate(request()->perPage ?? 10, $columns = ['*'])
            ->withPath(request()->path())
            ->withQueryString()
            ->appends(['sort' => ['id']]);
        return new KegiatanCollection($kegiatan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return KegiatanResource
     */
    public function store(KegiatanRequest $request)
    {
        $validated = $request->safe()->all();
        $user = $request->user()->id;
        $date =  $validated['mulai'];
        DB::beginTransaction();
        $validated['created_by'] = $user;
        $validated['tanggal'] = date('Y-m-d', strtotime($date));
        $validated['tahun'] = date('Y', strtotime($date));
        $kegiatan = ItemKegiatan::create($validated);
        $userHasUraianTugas = UserHasUraianTugas::create([
            'uraian_tugas_id' => $validated['uraian_tugas_id'],
            'user_id' => $user
        ]);
        $kegiatan->userHasUraianTugas()->attach($userHasUraianTugas->id);
        try {
           
            $kegiatan_user = $kegiatan->users()->where('kegiatanable_id', $user)->first();
           

            if (Arr::exists($validated, 'uraian_tugas_id')) {
              
                $kegiatan_UT = $kegiatan->uraianTugas()->where('kegiatanable_id', $validated['uraian_tugas_id'])->first();
                if (!$kegiatan_UT) {
                    $kegiatan->uraianTugas()->attach($validated['uraian_tugas_id']);
                }
                
            }

            if (!$kegiatan_user) {
                $kegiatan->users()->attach($user);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        } finally {
            DB::commit();
        }
        return (new KegiatanResource($kegiatan->load(['users', 'units', 'uraianTugas', 'createdBy.jabatan'])))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Kegiatan $kegiatan
     * @return KegiatanResource
     */
    public function show(ItemKegiatan $kegiatan)
    {
        return new KegiatanResource($kegiatan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Kegiatan $kegiatan
     * @return KegiatanResource
     */

    public function update(KegiatanRequest $request, ItemKegiatan $kegiatan)
    {
        $validated = $request->safe()->all();
        $user = $request->user()->id;
        DB::beginTransaction();
        try {

            $kegiatan_user = $kegiatan->users()->where('kegiatanable_id', $user)->first();
            if (!$kegiatan_user) {
                $kegiatan->users()->attach($user);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal COpy:Internal Server Error'], 500);
        } finally {
            DB::commit();
        }

        return (new KegiatanResource($kegiatan->load(['users', 'units', 'uraianTugas', 'createdBy.jabatan'])))->setMessage('Copyed!');
    }

    public function follow(FollowKegiatanRequest $request, ItemKegiatan $kegiatan)
    {
        $validated = $request->safe()->only('uraian_tugas_id');
        DB::beginTransaction();
        try {
            $user = $request->user()->id;
            $kegiatan_user = $kegiatan->users()->where('kegiatanable_id', $user)->first();
            if (!$kegiatan_user) {
                $kegiatan->users()->attach($user);
            }
            if (Arr::exists($validated, 'uraian_tugas_id')) {
                $kegiatan_UT = $kegiatan->uraianTugas()->where('kegiatanable_id', $validated['uraian_tugas_id'])->first();
                if (!$kegiatan_UT) {
                    $kegiatan->uraianTugas()->attach($validated['uraian_tugas_id']);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Diikuti:Internal Server Error'], 500);
        } finally {
            DB::commit();
        }
        return (new KegiatanResource($kegiatan->load(['users', 'units', 'uraianTugas', 'createdBy.jabatan'])))->setMessage('Followed');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Kegiatan $kegiatan
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, ItemKegiatan $kegiatan)
    {
        DB::beginTransaction();

        try {
            $user = $request->user()->id;
            if ($kegiatan->users()->count() > 1) {
                $kegiatan_user = $kegiatan->users()->where('kegiatanable_id', $user)->first();
                if ($kegiatan_user) {
                    $kegiatan->users()->detach($user);
                }
            } else {
                $kegiatan->delete();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Hapus:Internal Server Error'], 500);
        } finally {
            DB::commit();
        }
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }

    public function end(ItemKegiatan $kegiatan)
    {

        try {
            $kegiatan->selesai = date('Y-m-d H:i:s', strtotime(now()));
            $kegiatan->update();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new KegiatanResource($kegiatan))->setMessage('Restored!');
    }

    public function cancelEnd(ItemKegiatan $kegiatan)
    {

        try {
            $kegiatan->selesai = null;
            $kegiatan->update();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new KegiatanResource($kegiatan))->setMessage('Restored!');
    }

    // public function restore(Kegiatan $kegiatan)
    // {
    //     try {
    //        kegiatan->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new KegiatanResource($kegiatan))->setMessage('Restored!');
    // }


    // public function forceDelete(Kegiatan $kegiatan)
    // {
    //     try {
    //        kegiatan->forceDelete();
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
