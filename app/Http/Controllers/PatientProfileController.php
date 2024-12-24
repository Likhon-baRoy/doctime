<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientProfileController extends Controller
{
  public function showPatientSettingsPage() {
    return view('frontend.patient.settings');
  }

  public function showPatientPasswordPage() {
    return view('frontend.patient.password');
  }
}
