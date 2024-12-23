<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
class PatientAuthController extends Controller {
  public function register(Request $request) {

    // Data Validation
    $validatedData = $request->validate([
      'name'  		=> 'required',
      'email' 		=> 'required|email',
      'mobile'		=> 'required',
      'pass'  	    => 'required|confirmed',
    ]);

    // Data Store
    Patient::create([
      'name'        => $request -> name,
      'email'       => $request -> email,
      'mobile'        => $request -> mobile,
      'password'        => password_hash($request -> pass, PASSWORD_DEFAULT),
    ]);

    return redirect() -> route('patient.reg.page') -> with('success', "Hi " . $request -> name . ", your account created successfully");
  }

  public function login(Request $request) {

    // Data Validation
    $validatedData = $request->validate([
      'email' 		=> 'required|email',
      'password'  	    => 'required',
    ]);

    return $request -> all();
  }
}
