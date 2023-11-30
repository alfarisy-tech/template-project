<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('roles')->get();
            return datatables()->of($data)
                ->addColumn('action', function ($data) {
                    $roles = Role::all();
                    return view('users._option', compact('data', 'roles'))->render();
                })
                ->editColumn('roles', function ($data) {
                    $roles = '';
                    $roleCount = count($data->roles);

                    foreach ($data->roles as $key => $role) {
                        $roles .= '<span class="text-start fw-bold text-teal">' . $role->name . '</span>';
                        // Tambahkan tanda koma jika bukan elemen terakhir
                        if ($key < $roleCount - 1) {
                            $roles .= '<br/>';
                        }
                    }
                    return $roles;
                })
                ->addIndexColumn()
                ->rawColumns(['action', 'roles'])
                ->make(true);
        }
        $datas = [
            'title' => 'Users',
            'roles' => Role::all(),

        ];
        return view('users.index', $datas);
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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(12345678),
            ]);

            if ($user) {
                $user->syncRoles($request->roles);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'User Created',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'User Not Created',
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            if ($user) {
                $user->syncRoles($request->roles);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'User Created',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'User Not Created',
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
            $user = User::find($id);
            if ($user) {
                $user->delete();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'User Deleted',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'User Not Deleted',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Reset Password
     */
    public function resetPassword(string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            if ($user) {
                $user->update([
                    'password' => bcrypt(12345678),
                ]);
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Password Reset Success',
                ]);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Password Not Reset ',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
