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



class CveAlumnosController extends Controller
{

    public function index()
    {
        //
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
            'escuela' => 'present|nullable',
            'carrera' => 'present|nullable',
            'semestre' => 'present|nullable',
            'grupo' => 'present|nullable',
            'ubicacion' => 'present|string',
        ]);

        if ($validator->fails())
        {
            return DB::select("call procAppEmptyData()");
        }

        /*
        $elGrupo = $request->grupo;
        if (isset($request->grupo))
        {

        }*/

        //if ( ($request->carrera) && ($request->grado) && ($request->grupo) && ($request->ubicacion)  )
        //{
            $elSemestre = $request->grado;
            if (empty($elSemestre))
            {
                $elSemestre = "0";
            }

            return DB::select("call procAppAlumnos('" . $request->escuela .
                "','" . $request->carrera . "'" .
                "," . $elSemestre .
                ",'" . $request->grupo . "'" .
                ",'" . $request->ubicacion . "')" );
        //}
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

        //return DB::select("call procAppAsignaturas(".$id.")");
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
        return redirect()->away('http://modelo.edu.mx/');
    }

}
