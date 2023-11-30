<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            $data = \Spatie\Activitylog\Models\Activity::with('causer')->get();
            return datatables()->of($data)
                ->editColumn('causer_id', function ($data) {
                    return $data->causer->name;
                })
                ->editColumn('description', function ($data) {
                    return $data->description;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('d F Y H:i:s');
                })
                ->rawColumns(['description'])
                ->addIndexColumn()
                ->make(true);
        }
        $datas = [
            'title' => 'Logs',

        ];
        return view('logs.index', $datas);
    }
}
