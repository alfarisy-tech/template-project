<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::all();
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    return view('permissions._option', compact('data'))->render();
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        $datas = [
            'title' => 'Permissions',
            'permissions' => Permission::all(),

        ];
        return view('permissions.index', $datas);
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
            $permission = Permission::create(['name' => $request->name]);

            if ($permission) {
                DB::commit();

                activity()
                    ->causedBy(1)
                    ->performedOn($permission)
                    ->createdAt(now())
                    ->log('<span class="text-green text-capitalize">created permission </span> <span class="text-black fw-bold text-capitalize">"' . $permission->name . '"</span>');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->save();

            if ($permission) {
                DB::commit();
                activity()
                    ->causedBy(1)
                    ->performedOn($permission)
                    ->createdAt(now())
                    ->log('<span class="text-blue text-capitalize">updated permission </span> <span class="text-black fw-bold text-capitalize">"' . $permission->name . '"</span>');
                return response()->json([
                    'success' => true,
                    'message' => 'Permission Updated',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Permission Not Updated',
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
            $permission = Permission::find($id);
            $permission->delete();

            if ($permission) {
                DB::commit();
                activity()
                    ->causedBy(1)
                    ->performedOn($permission)
                    ->createdAt(now())
                    ->log('<span class="text-red text-capitalize">deleted permission </span> <span class="text-black fw-bold text-capitalize">"' . $permission->name . '"</span>');
                return response()->json([
                    'success' => true,
                    'message' => 'Permission Deleted',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Permission Not Deleted',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
