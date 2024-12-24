<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PatientAccountActivationNotification;

class PatientAuthController extends Controller {
  public function register(Request $request) {

    // Data Validation
    $validatedData = $request->validate([
      'name'  		=> 'required',
      'email' 		=> 'required|email',
      'mobile'		=> 'required',
      'pass'  	    => 'required|confirmed',
    ]);

    // create a token
    $token = md5(time().rand());

    // Data Store
    $patient = Patient::create([
      'name'        => $request -> name,
      'email'       => $request -> email,
      'mobile'        => $request -> mobile,
      'access_token'    => $token,
      'password'        => password_hash($request -> pass, PASSWORD_DEFAULT),
    ]);

    // send account activation link to patient email
    $patient -> notify(new PatientAccountActivationNotification($patient));

    return redirect() -> route('patient.reg.page') -> with('success', "Hi " . $request -> name . ", your account created successfully");
  }

  public function login(Request $request) {

    // Data Validation
    $validatedData = $request->validate([
      'email' 		=> 'required',
      'password'  	    => 'required',
    ]);

    // Athentication process
    if ( Auth::guard('patient') -> attempt([ 'email' => $request -> email, 'password' => $request -> password ]) ||
         Auth::guard('patient') -> attempt([ 'mobile' => $request -> email, 'password' => $request -> password ]) )  {
      if ( (Auth::guard('patient') -> user() -> access_token == null) && (Auth::guard('patient') -> user() -> status == true) ) {
        return redirect() -> route('patient.dash.page');
      } else {
        Auth::guard('patient') -> logout();
        return redirect() -> route('login.page') -> with('warning', 'Account is not activate yet');
      }
    } else {
      return redirect() -> route('login.page') -> with('danger', 'wrong Email/password');
    }
  }

  public function logout() {
    Auth::guard('patient') -> logout();

    return redirect() -> route('login.page');
  }

  public function patientAccountActivation($token=null) {
    if (!$token) {
      return redirect() -> route('login.page') -> with('danger', 'Access Token is not found!');
    }
    // chek if it is a NULL token
    if ( $token ) {

      $patient_date = Patient::where('access_token', $token) -> first();

      if ( $patient_date ) {

        $patient_date -> update([
          'access_token' => null,
          'status'       => true
        ]);

        return redirect() -> route('login.page') -> with('success', 'Hi ' . $patient_date -> name . ', your account is created. Now you can Login.');
      } else {
        return redirect() -> route('login.page') -> with('warning', 'Access Token does not match!');
      }
    }
  }
}
