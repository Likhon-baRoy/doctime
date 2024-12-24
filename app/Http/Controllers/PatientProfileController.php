<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientProfileController extends Controller
{
  public function showPatientSettingsPage() {
    return view('frontend.patient.settings');
  }

  public function showPatientPasswordPage() {
    return view('frontend.patient.password');
  }

  public function patientPasswordChange(Request $request) {
    // check old password
    if ( !(password_verify($request -> old_pass, Auth::guard('patient') -> user() -> password)) ) {
      return back() -> with('danger', 'User old password didn\'t match');
    }

    //new password confirmation
    if ( $request -> pass != $request -> pass_confirmation) {
      return back() -> with('warning', 'Password confirmation failed');
    }

    // find the user data
    $data = Patient::findOrFail(Auth::guard('patient') -> user() -> id);

    // Update new password
    $data -> update([
      'password' => Hash::make($request -> pass)
    ]);

    Auth::guard('patient') -> logout();

    return redirect() -> route('login.page') -> with('success', 'Patient password changed successfully');
  }
}
