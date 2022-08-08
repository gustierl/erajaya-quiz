<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return view('auth.login');});

Route::get('/register', [RegisterController::class,'showRegistrationForm'])->name('register');
Auth::routes();
Route::group(['middleware' => ['auth','prevent-back-history']], function() {
    Route::get('/home', [HomeController::class,'index'])->name('home');
    Route::get('/home/data/score', [HomeController::class,'homeScore'])->name('home.score');
    Route::get('/home/admin', [HomeController::class,'homeAdmin'])->name('home.admin');
});
Route::group(['middleware' => ['auth','prevent-back-history','role:Admin']], function() {
    Route::get('/quiestion',[QuestionController::class, 'index'])->name('question');
    Route::get('/quiestion/data',[QuestionController::class, 'data'])->name('question.data');
    Route::get('/quiestion/edit/{question_code}',[QuestionController::class, 'edit'])->name('question.edit');
    Route::post('/quiestion/upload/excel',[QuestionController::class, 'uploadExcel'])->name('question.upload');
    Route::post('/quiestion',[QuestionController::class, 'store'])->name('question.store');
    Route::get('/quiz-user',[QuizController::class, 'index'])->name('quiz.list');
    Route::get('/quiz-user/{id}',[QuizController::class, 'show'])->name('quiz.detail');
    Route::resource('user', 'App\Http\Controllers\UserController');
    Route::post('/user/changePassword',[UserController::class,'changePassword'])->name('user.changePassword');
});

Route::group(['middleware' => ['auth','prevent-back-history','role:User']], function() {
    Route::get('/show/quiz/{id}',[QuizUserController::class,'index'])->name('quiz.index');
    Route::post('/quiz/createQuiz',[QuizUserController::class,'createNewQuiz'])->name('quiz.create');
    Route::post('/quiz/store',[QuizUserController::class,'store'])->name('quiz.store');
    Route::get('/quiz/load/question/',[QuizUserController::class,'load'])->name('quiz.load');
});
