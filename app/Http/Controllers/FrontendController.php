<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
  // show Homepage
  public function showHomePage() {
    return view('frontend.home');
  }

  // show Login Page
  public function showLoginPage() {
    return view('frontend.login');
  }

  // show Patient Register Page
  public function showPatientRegisterPage() {
    return view('frontend.patient.register');
  }

  // show Patient Dashboard Page
  public function showPatientDashPage() {
    return view('frontend.patient.dashboard');
  }

  // show Doctor Register Page
  public function showDoctorRegisterPage() {
    return view('frontend.doctor.register');
  }

  // show Doctor Dashboard Page
  public function showDoctorDashPage() {
    return view('frontend.doctor.dashboard');
  }
}
