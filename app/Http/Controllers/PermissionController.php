<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                    $btn =  '<a class="btn btn-primary btn-sm fw-bold" type="button" data-bs-toggle="modal"
                    data-bs-target="#edit' . $data->id . '">Manage</a>
                    ';
                    return $btn;
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
        $permission = Permission::create(['name' => $request->name]);

        if ($permission) {
            return response()->json([
                'success' => true,
                'message' => 'Permission Created',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Permission Not Created',
            ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
