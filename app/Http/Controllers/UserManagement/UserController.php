<?php

namespace App\Http\Controllers\UserManagement;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Media\ImageResource;
use App\Http\Requests\UserManagement\UserRequest;
use App\Http\Resources\UserManagement\UserResource;
use App\Http\Resources\UserManagement\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        $user = QueryBuilder::for(User::class)
            ->allowedIncludes(['unit', 'permissions', 'jabatan', 'pangkat'])
            ->allowedFilters([
                'name', 'email',
                AllowedFilter::callback('cari', function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('name', 'LIKE', "%{$value}%")->orWhere('nip', 'LIKE', "%{$value}%");
                    });
                }),
                AllowedFilter::callback('jabatan', function ($query, $value) {
                    $query->whereHas('jabatan', function ($query) use ($value) {
                        $query->where('nama', 'LIKE', "%{$value}%")->orWhere('jenis', 'LIKE', "%{$value}%");
                    });
                }),
                AllowedFilter::exact('unit_id'),
                AllowedFilter::exact('jabatan_id'),
                AllowedFilter::exact('pangkat_id'),
                AllowedFilter::trashed()->default('none')
                // AllowedFilter::scope('deleted')->default(true),
            ])->allowedSorts('name', 'unit_id',)
            ->cursorPaginate(request()->perPage ?? 10, $columns = ['*'])
            ->withPath(request()->path())
            ->withQueryString();
        return new UserCollection($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return UserResource
     */
    public function store(UserRequest $request)
    {
        $validated = $request->safe()->all();
        try {
            $user = User::create($validated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new UserResource($user))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user->load(['pangkat', 'jabatan', 'unit']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserRequest $request, User $user)
    {

        try {
            $user->update($request->safe()->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new UserResource($user))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
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
    public function addFotoProfile(Request $request)
    {
        // $user = Auth::user();
        $request->validate([
            'foto_profile' => 'required|image|max:2048',

        ]);
        // $media = $user->getFirstMedia();
        // $user->clearMediaCollection();
        // return $media;
        // $publicFullUrl = $mediaItems->getUrl(); //url including domain
        $image = $request->file('foto_profile');

        $user = $request->user();

        // $user->media()->delete();
        $fileName = Str::of($user->name)->slug('-');
        $fullFileName = $fileName . "-" . time() . "." . $image->getClientOriginalExtension();
        $image_saved = $request->user()->addMedia($image)
            ->usingFileName($fullFileName)
            ->toMediaCollection('avatar', 'avatar');
        return new ImageResource($image_saved);
        try {
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return response()->json([
            'success' => true,
            'message' => 'Permanent Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }
    // public function restore(User $user)
    // {
    //     try {
    //        user->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new UserResource($user))->setMessage('Restored!');
    // }


    // public function forceDelete(User $user)
    // {
    //     try {
    //        user->forceDelete();
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
