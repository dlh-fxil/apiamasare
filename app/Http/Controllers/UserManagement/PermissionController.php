<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\PermissionRequest;
use App\Models\UserManagement\Permission;
use App\Http\Resources\UserManagement\PermissionResource;
use App\Http\Resources\UserManagement\PermissionCollection;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PermissionCollection
     */
    public function index()
    {
        $permission = QueryBuilder::for(Permission::class)
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
            ->get();
        return new PermissionCollection($permission);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return PermissionResource
     */
    public function store(PermissionRequest $request)
    {
        $validated = $request->safe()->all();
        try {
            $permission = Permission::create($validated);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        }
        return (new PermissionResource($permission))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     * @return PermissionResource
     */
    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Permission $permission
     * @return PermissionResource
     */
    public function update(PermissionRequest $request, Permission $permission)
    {

        try {
            $permission->update($request->safe()->all());
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        }
        return (new PermissionResource($permission))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
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

    // public function restore(Permission $permission)
    // {
    //     try {
    //        permission->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new PermissionResource($permission))->setMessage('Restored!');
    // }


    // public function forceDelete(Permission $permission)
    // {
    //     try {
    //        permission->forceDelete();
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
