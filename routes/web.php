<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\PatientProfileController;

// Frontend Controller
Route::get('/', [ FrontendController::class, 'showHomePage' ]) -> name('home.page');
Route::get('/login', [ FrontendController::class, 'showLoginPage' ]) -> name('login.page') -> middleware('patient.redirect');

// Patient Pages
Route::get('/patient-register', [ FrontendController::class, 'showPatientRegisterPage' ]) -> name('patient.reg.page') -> middleware('patient.redirect');
Route::get('/patient-dashboard', [FrontendController::class, 'showPatientDashPage'])
     ->name('patient.dash.page')
     ->middleware('patient');
Route::get('/patient-settings', [PatientProfileController::class, 'showPatientSettingsPage'])
     ->name('patient.settings.page')
     ->middleware('patient');
Route::get('/patient-password', [PatientProfileController::class, 'showPatientPasswordPage'])
     ->name('patient.password.page')
     ->middleware('patient');
Route::post('/patient-password', [PatientProfileController::class, 'patientPasswordChange'])
     ->name('patient.password.change')
     ->middleware('patient');
// Patient Authentication Routes
Route::post('/patient-register', [ PatientAuthController::class, 'register' ]) -> name('patient.register');
Route::post('/patient-login', [ PatientAuthController::class, 'login' ]) -> name('patient.login');
Route::get('/patient-logout', [ PatientAuthController::class, 'logout' ]) -> name('patient.logout');
Route::get('/patient_account_activation/{token?}', [ PatientAuthController::class, 'patientAccountActivation' ]) -> name('patient.account.activation');

// Doctor Pages
Route::get('/doctor-register', [ FrontendController::class, 'showDoctorRegisterPage' ]) -> name('doctor.reg.page');
Route::get('/doctor-dashboard', [ FrontendController::class, 'showDoctorDashPage' ]) -> name('doctor.dash.page');
