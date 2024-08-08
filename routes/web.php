<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homecontroller;
use App\Http\Controllers\admincontroller;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

*/
Route::get('/', function () {
    return view('index');
});

use App\Http\Controllers\PaymentController;



//pagesin webpage
//Route::get('/',[homecontroller::class,'index'])->name('index');
Route::get('/about',[homecontroller::class,'about'])->name('about');
Route::get('/courses',[homecontroller::class,'courses'])->name('courses');
Route::get('/howto',[homecontroller::class,'howto'])->name('howto');
Route::get('/signup',[homecontroller::class,'signup'])->name('signup');
Route::get('/login',[homecontroller::class,'login'])->name('login');

//admin registering
Route::get('/insertdata', [admincontroller::class, 'insertData']);


Route::get('/loginadmin', [admincontroller::class, 'loginadmin'])->name('loginadmin');
Route::post('/loginadmin', [admincontroller::class, 'login']);
Route::post('/logoutadmin', [admincontroller::class, 'logout'])->name('admin.logout');


//adminauthetication
Route::middleware(['admin'])->group(function () {
    
    Route::prefix('admin')->group(function () {
        Route::get('/staff', function () {
            return view('admin.staff');
        });
        //  other admin routes
        Route::get('/admin/view', [admincontroller::class, 'adminview'])->name('adminview');
        Route::post('/admin/list', [admincontroller::class, 'addadmin'])->name('addadmin');
        Route::put('/admin/adminupdate/{id}', [adminController::class, 'adminupdate'])->name('adminupdate');
        Route::delete('/admin/delete/{id}', [admincontroller::class, 'destroyadmin'])->name('destroyadmin');
        
        Route::get('/admin/view-all-students-marks', [admincontroller::class,'viewAllStudentsMarks'])->name('admin.view-all-students-marks');
        Route::get('/admin/students/{userId}/edit-results', [admincontroller::class, 'editStudentResults'])->name('admin.students.edit-results');
        //Route::put('/admin/students/{userId}/update-results', [admincontroller::class, 'bulkUpdateStudentResults'])->name('admin.students.update-results');
        Route::put('/admin/students/update-results', [admincontroller::class, 'bulkUpdateStudentResults'])->name('admin.students.update-results');
        Route::post('/add-announcement', [admincontroller::class, 'addAnnouncement'])->name('addannouncement');
        Route::get('/admin/meeting-links', [admincontroller::class, 'meetingpage'])->name('meetingpage');
        Route::post('/admin/meeting-links', [admincontroller::class, 'meeting'])->name('meeting');
        Route::put('/admin/meeting-links/{id}', [admincontroller::class, 'updatelink'])->name('admin.meeting-links.update');
        Route::delete('/admin/meeting-links/{id}', [admincontroller::class, 'destroylink'])->name('admin.meeting-links.destroy');
        Route::get('/students', [admincontroller::class, 'staff'])->name('students');
        Route::get('/admin/summary', [admincontroller::class, 'summary'])->name('summary');
        Route::get('/admin/students/{id}/edit', [admincontroller::class, 'edit'])->name('admin.edit');
        Route::put('/admin/students/{id}', [admincontroller::class, 'update'])->name('admin.update');
        Route::delete('/admin/students/{id}', [admincontroller::class, 'destroy'])->name('admin.destroy');
        Route::get('/admin/dresults', [admincontroller::class, 'downloadResults'])->name('dresults');
        
        Route::get('/courses', [admincontroller::class, 'courses'])->name('courses.courses');
        Route::get('/courses/create', [admincontroller::class, 'create'])->name('courses.create');
        Route::post('/courses/add', [admincontroller::class, 'addCourse'])->name('courses.store');
        Route::get('/admin/courses/{course}/edit', [admincontroller::class, 'editCourse'])->name('courses.edit');
        Route::put('/admin/courses/{course}/update', [admincontroller::class, 'updateCourse'])->name('courses.update');
        Route::delete('/courses/{course}', [admincontroller::class, 'deleteCourse'])->name('courses.delete');
        
        Route::get('/notes', [admincontroller::class, 'notes'])->name('notes.notes');
        Route::get('/notes/add', [admincontroller::class, 'addNote'])->name('notes.add');
        Route::post('/notes/store', [admincontroller::class, 'storeNote'])->name('notes.store');
        Route::get('/notes/view/{note}', [admincontroller::class, 'viewNote'])->name('adnotes.view');
        Route::get('/notes/{note}/edit', [admincontroller::class, 'editNote'])->name('notes.edit');
        Route::put('/notes/{note}', [admincontroller::class, 'updateNote'])->name('notes.update');
        Route::delete('/notes/{note}', [admincontroller::class, 'deleteNote'])->name('notes.delete');
        //Route::get('notes/{course}/course', [admincontroller::class, 'notesByCourse'])->name('notes.bycourse');
        //Route::get('/admin/notes/{course}/course', [admincontroller::class, 'notesByCourse'])->name('notes.bycourse');
        
        
        

    });
});










//studentauthetication
Route::get('/dashboard', [homecontroller::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/student/anncouncement', [ProfileController::class, 'announcements'])->name('anncouncements');
    Route::get('/student/view-marks', [ProfileController::class, 'viewmarks'])->name('student.view-marks');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'pass'])->name('profile.update');
    Route::get('/student/profile', [ProfileController::class, 'prof'])->name('prof');
    Route::patch('/student/profile', [ProfileController::class, 'updateprof'])->name('updateprof');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
    
    Route::get('/profile/confirmation', [PaymentController::class, 'showConfirmation'])->name('profile.confirmation');
    
     Route::get('/profile/waiting', [PaymentController::class, 'showWaitingPage'])->name('profile.waiting');
    Route::get('/profile/check-status/{CheckoutRequestID}', [PaymentController::class, 'checkPaymentStatus'])->name('profile.checkStatus');
    Route::get('/profile/timeout/{CheckoutRequestID}', [PaymentController::class, 'handlePaymentTimeout'])->name('profile.timeout');
    
    Route::get('/feespayments', [PaymentController::class, 'showPayments'])->name('payments');
    
    
    Route::get('/student/notes', [ProfileController::class, 'listNotes'])->name('notes.list');
    Route::get('/student/notes/{note}', [ProfileController::class, 'viewNote'])->name('notes.view');
    
});

require __DIR__.'/auth.php';
