<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with('permissions')->get();
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $permissions = Permission::all();
                    return view('roles._option', compact('data', 'permissions'))->render();
                })
                ->editColumn('permission', function ($data) {
                    $permissions = '';
                    $permissionCount = count($data->permissions);

                    foreach ($data->permissions as $key => $permission) {
                        $permissions .= '<span class="text-start fw-bold text-teal">' . $permission->name . '</span>';
                        // Tambahkan tanda koma jika bukan elemen terakhir
                        if ($key < $permissionCount - 1) {
                            $permissions .= '<br/>';
                        }
                    }
                    return $permissions;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'permission'])
                ->make(true);
        }
        $datas = [
            'title' => 'Roles',
            'permissions' => Permission::all(),

        ];
        return view('roles.index', $datas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $role = Role::create(['name' => $request->name]);

            if ($role) {
                $role->syncPermissions($request->permissions);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Permission Created',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Permission Not Created',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        if ($role) {
            $permissions = Permission::all();
            return view('roles.edit', compact('role', 'permissions'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $role = Role::find($id);
            if ($role) {
                $role->name = $request->name;
                $role->save();
                $role->syncPermissions($request->permissions);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Role Updated',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Role Not Updated',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $role = Role::find($id);
            if ($role) {
                $role->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Role Deleted',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Role Not Deleted',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
