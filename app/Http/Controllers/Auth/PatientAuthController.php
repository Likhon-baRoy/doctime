<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

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
      'email' 		=> 'required',
      'password'  	    => 'required',
    ]);

    // Athentication process
    if ( Auth::guard('patient') -> attempt([ 'email' => $request -> email, 'password' => $request -> password ]) || Auth::guard('patient') -> attempt([ 'mobile' => $request -> email, 'password' => $request -> password ]) )  {
      return redirect() -> route('patient.dash.page');
    } else {
      return redirect() -> route('login.page') -> with('danger', 'wrong Email/password');
    }
  }

  public function logout() {
    Auth::guard('patient') -> logout();

    return redirect() -> route('login.page');
  }
}
