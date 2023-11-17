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
use Debugbar;

use App\Models\User;



class TutoriasCampusController extends Controller
{

    public function index()
    {
        return redirect()->away('http://modelo.edu.mx/');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->away('http://modelo.edu.mx/');
        //
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
            'tokenModelo' => 'required|string',
        ]);

        if ($validator->fails())
        {
            return DB::select("call procAppEmptyData()");
        }
        else
        {
            if (empty($request->tokenModelo))
            {
                return DB::select("call procAppEmptyData()");
            }
            else
            {
                if (!$request->tokenModelo)
                {
                    return DB::select("call procAppEmptyData()");
                }
                else
                {
                    return DB::select("call procExUniCampus()");
                }
            }

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
        return redirect()->away('http://modelo.edu.mx/');
        //return DB::select("call procAppAsignaturas(".$id.")");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->away('http://modelo.edu.mx/');
        //
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
        return redirect()->away('http://modelo.edu.mx/');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect()->away('http://modelo.edu.mx/');
        //
    }

}

