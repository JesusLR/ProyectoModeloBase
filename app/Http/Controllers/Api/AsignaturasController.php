<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use URL;
use Validator;
//use Debugbar;
use App\Models\User;



class AsignaturasController extends Controller
{

    public function index()
    {
        //
        //return response()->json(['errors'=>array(['code'=>404])],404);
        return redirect()->away('http://modelo.edu.mx/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //return response()->json(['errors'=>array(['code'=>404])],404);
        return redirect()->away('http://modelo.edu.mx/');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cve_pago' => 'required|int',
        ]);

        if ($validator->fails())
        {
            return DB::select("call procAppEmptyData()");
        }

        if (!$request->cve_pago) {

            return DB::select("call procAppEmptyData()");
        }
        else {
            return DB::select("call procAppAsignaturas(" . $request->cve_pago . ")");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //return response()->json(['errors'=>array(['code'=>404])],404);
        return redirect()->away('http://modelo.edu.mx/');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //return DB::select("call procAppEmptyData()");
        //return response()->json(['errors'=>array(['code'=>404])],404);
        return redirect()->away('http://modelo.edu.mx/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //return response()->json(['errors'=>array(['code'=>404])],404);
        return redirect()->away('http://modelo.edu.mx/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //return response()->json(['errors'=>array(['code'=>404])],404);
        return redirect()->away('http://modelo.edu.mx/');
    }

}
