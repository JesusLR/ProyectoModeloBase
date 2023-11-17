<?php

namespace App\Http\Controllers;

use URL;
use Auth;
use Debugbar;
use Validator;
use Carbon\Carbon;
use App\Http\Helpers\Utils;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;


use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CuentaController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
{
    $this->middleware('auth');
  }


  public function index(){
    return view('auth.login');
  }


  public function cambiarPassword()
  {
    return view("miCuenta.cuenta");
  }


  public function passwordUpdate(Request $request)
  {
    $user = DB::table("users")->where("id", "=", Auth::id())->first();
    $validator = Validator::make($request->all(), [
          'password'          =>  'required|min:8|max:20|regex:/^.*?(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$/',
          'confirmPassword'   =>  'required|same:password',
      ], [
          'confirmPassword.same'     => 'Ambos campos de contraseña deben coincidir.',
          'password.required'        => 'La contraseña nueva es requerida.',
          'confirmPassword.required' => 'La contraseña de verificación es requerida.',
          'password.regex' => 'La contraseña debe tener al menos una Mayúscula, una minúscula y un número.',
      ]);
      


    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator);
    }


    if (!Hash::check($request->oldPassword, $user->password)) {
      alert('Escuela Modelo', 'Tu contraseña actual no coincide', 'warning')->showConfirmButton();
      return redirect()->back();
    }


    $user = DB::table("users")->where("id", "=", Auth::id())->update([
      "password" => Hash::make($request->password)
    ]);

    alert('Escuela Modelo', 'Contraseña guardada correctamente', 'success')->showConfirmButton();
    return redirect()->back();
  }
}