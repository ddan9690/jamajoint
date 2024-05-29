<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VisualsAndInsights;
use App\Http\Controllers\ExamSchoolController;
use App\Http\Controllers\PdfDownloadController;
use App\Http\Controllers\ExcelDownloadController;
use App\Http\Controllers\PaperAnalysisController;



Route::get('/', function () {
    return view('index');
});

Route::get('/features', function () {
    return view('features');
});

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/pricing', function () {
    return view('pricing');
});

Route::get('/contact-us', function () {
    return view('contact-us');
});

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');






// social  authentication
Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('password/update', [UserController::class, 'passwordUpdateForm'])->name('password.change');
Route::post('password/update', [UserController::class, 'updatePassword'])->name('password.modify');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth'])->group(function () {


    // Authenticated routes
    Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
    Route::get('/schools/{id}/{slug}', [SchoolController::class, 'show'])->name('schools.show');

    // Route::get('/schools/{id}', [SchoolController::class, 'show'])->name('schools.show');
    Route::post('/form/index', [FormController::class, 'store'])->name('forms.index');
    Route::get('/forms/{schoolId}/show/{form}', [FormController::class, 'show'])->name('forms.show');

    Route::post('/streams/store', [StreamController::class, 'store'])->name('streams.store');
    Route::delete('/streams/{id}', [StreamController::class, 'destroy'])->name('streams.destroy');
    Route::get('/streams/{id}/edit', [StreamController::class, 'edit'])->name('streams.edit');
    Route::put('/streams/{id}', [StreamController::class, 'update'])->name('streams.update');
    Route::get('/schools/{schoolId}/streams/{streamId}/{form}', [StreamController::class, 'show'])->name('streams.show');

    Route::get('/schools/{schoolId}/{form}/streams/{streamId}/students/import', [StudentController::class, 'importForm'])->name('students.import');
    Route::post('/schools/{schoolId}/streams/{streamId}/{form}/students/import', [StudentController::class, 'import'])->name('students.imports');
    Route::get('/schools/{schoolId}/streams/{streamId}/{form}/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/schools/{schoolId}/streams/{streamId}{form}/students', [StudentController::class, 'store'])->name('students.store');
    Route::delete('/schools/{schoolId}/streams/{streamId}/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::delete('/schools/{schoolId}/streams/{streamId}/{form}/students/delete-selected', [StudentController::class, 'deleteSelected'])->name('students.deleteSelected');


    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    // Show exam by ID
    Route::get('/exams/{id}', [ExamController::class, 'show'])->name('exams.show');

    Route::get('/results/{exam}', [ResultController::class, 'view'])->name('results.view');


    Route::get('/marks/check-registration/{exam}', [MarkController::class, 'checkRegistrationStatus'])
        ->name('checkRegistrationStatus');

    Route::get('/marks/index/{exam}', [MarkController::class, 'index'])->name('marks.index');

    Route::get('/marks/{exam}/stream/{stream}', [MarkController::class, 'streamMarksView'])->name('marks.streamMarksView');
    Route::get('/marks/{exam}/stream/{stream}/subject/{subject}/submit', [MarkController::class, 'submitMarks'])->name('marks.submit');
    Route::post('/marks/{exam}/stream/{stream}/subject/{subject}/submit', [MarkController::class, 'store'])->name('marks.store');
    Route::get('/marks/{exam}/stream/{stream}/subject/{subject}', [MarkController::class, 'show'])->name('marks.show');
    Route::get('/marks/{exam}/stream/{stream}/subject/{subject}/add-result', [MarkController::class, 'addResultView'])->name('marks.addResult');
    Route::post('/marks/{exam}/stream/{stream}/subject/{subject}/submit', [MarkController::class, 'storeAddedMark'])->name('marks.storeAddedMark');
    Route::get('/marks/{mark}/edit', [MarkController::class, 'edit'])->name('marks.edit');
    Route::put('/marks/{mark}', [MarkController::class, 'update'])->name('marks.update');
    Route::delete('/marks/{mark}', [MarkController::class, 'destroy'])->name('marks.destroy');
    Route::get('/marks/{exam}/stream/{stream}/subject/{subject}/delete-all', [MarkController::class, 'deleteAllMarks'])->name('marks.deleteAll');

    Route::get('/mark-submission-status', [MarkController::class, 'markSubmissionStatus'])->name('markSubmissionStatus');
    Route::get('/marks/schools-registered/{exam}', [MarkController::class, 'displaySchoolsRegistered'])->name('marks.schoolsRegistered');
    Route::get('/streams-for-school/{examId}/{schoolId}', [MarkController::class, 'displayStreamsForSchool'])
        ->name('streamsForSchool');

    Route::get('/results/{id}/{slug}', [ResultController::class, 'index'])->name('results.index');

    Route::get('/results/myschool/{exam_id}/{form_id}/{slug}', [ResultController::class, 'mySchoolResults'])
        ->name('results.myschool');


    Route::get('/results/all-school/{id}/{slug}', [ResultController::class, 'schoolRanking'])->name('results.all-school');

    Route::get('/overall-student-ranking/{id}/{slug}/{form_id}', [ResultController::class, 'overallStudentRanking'])
        ->name('results.overall-students-results');

    Route::get('/results/school/{exam_id}/{school_id}/{exam_slug}/{slug}', [ResultController::class, 'schoolResult'])->name('results.school');

    Route::get('/results/top-performances/{exam_id}/{form_id}/{slug}', [ResultController::class, 'topPerformances'])->name('results.top-performances');


    Route::get('/results/stream-ranking/{id}/{form_id}/{slug}', [ResultController::class, 'streamRanking'])->name('results.stream-ranking');





    Route::get('/results/paper_1/home/{exam_id}/{form_id}/{slug}', [PaperAnalysisController::class, 'subject1Analysis'])->name('results.paper1Analysis');

    Route::get('/results/paper_2/home/{exam_id}/{form_id}/{slug}', [PaperAnalysisController::class, 'myschoolResultsPaper2'])->name('results.paper2Analysis');


    Route::get('/results/paper_1/{exam_id}/{form_id}/{slug}', [PaperAnalysisController::class, 'myschoolResultsPaper1'])
        ->name('results.paper1.myschoolResults');


    Route::get('/results/paper_2/{exam_id}/{form_id}/{slug}', [PaperAnalysisController::class, 'myschoolResultsPaper2'])
        ->name('results.paper2.myschoolResults');


    // pdf


    Route::get('/download-pdf-student-results/{id}/{form_id}/{slug}', [PdfDownloadController::class, 'downloadStudentResultsPdf'])
        ->name('pdf-download.student-results');

    Route::get('/download-pdf-grade-analysis/{id}/{form_id}/{slug}', [PdfDownloadController::class, 'downloadGradeAnalysisPdf'])
        ->name('pdf-download.grade-analysis');

    Route::get('/download-excel-my-school-results/{id}/{form_id}/{slug}', [ExcelDownloadController::class, 'mySchoolResultsExport'])
        ->name('excel-download.my-school-results');

    Route::get('/download-pdf-all-school-results/{id}/{slug}', [PdfDownloadController::class, 'schoolRankingPdf'])
        ->name('pdf-download.school-ranking');

    Route::get('/download-pdf/{id}/{slug}', [PdfDownloadController::class, 'overallStudentRanking'])
        ->name('pdf-download.overall-student-ranking');



    Route::get('/download-pdf-stream-ranking/{id}/{form_id}/{slug}', [PdfDownloadController::class, 'streamRanking'])
        ->name('pdf-download.stream-ranking');


    Route::get('/download-pdf-top-performers/{id}/{form_id}/{slug}', [PdfDownloadController::class, 'topPerformancesPdf'])
        ->name('pdf-download.top-performers');

        Route::get('/download-paper1-pdf/{exam_id}/{form_id}/{slug}', [PdfDownloadController::class, 'downloadPaper1Pdf'])
    ->name('pdf-download.paper1');

    Route::get('/download-paper2-pdf/{exam_id}/{form_id}/{slug}', [PdfDownloadController::class, 'downloadPaper2Pdf'])
    ->name('downloadPaper2Pdf');


    Route::get('/download/{id}/{form_id}/{slug}', [ExcelDownloadController::class, 'overallStudentRanking'])
        ->name('excel.overall-student-ranking');

        Route::get('/excel-download/stream-ranking/{id}/{form_id}/{slug}', [ExcelDownloadController::class, 'streamRanking'])
        ->name('excel-download.stream-ranking');




});

Route::middleware(['auth', 'admin'])->prefix('manage')->group(function () {

    // users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/updateRole', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
        ->name('users.reset-password');





    // Admin routes
    Route::get('/schools/create', [SchoolController::class, 'create'])->name('schools.create');
    Route::post('/schools', [SchoolController::class, 'store'])->name('schools.store');
    Route::get('/schools/{id}/edit', [SchoolController::class, 'edit'])->name('schools.edit');
    Route::put('/schools/{id}', [SchoolController::class, 'update'])->name('schools.update');
    Route::delete('/schools/{id}', [SchoolController::class, 'destroy'])->name('schools.destroy');



    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams/{id}/{slug}/edit', [ExamController::class, 'edit'])->name('exams.edit');
    Route::put('/exams/{id}/{slug}', [ExamController::class, 'update'])->name('exams.update');
    Route::patch('/exams/updateStatus/{id}', [ExamController::class, 'updateStatus'])->name('exams.updatePublished');
    Route::delete('/exams/{id}', [ExamController::class, 'destroy'])->name('exams.destroy');

    // register schools for an exam
    // Route::get('/exams/{id}/register', [ExamController::class, 'registerSchools'])->name('exams.register');
    // Route::post('/exams/{id}/store-schools', [ExamController::class, 'storeSchools'])->name('exams.storeSchools');
    // Route::get('/exams/{id}/unregister/{schoolId}', [ExamController::class, 'unregisterSchool'])->name('exams.unregister');

    Route::get('/exams/{exam}/register-schools', [ExamSchoolController::class, 'register'])->name('exams.register');
    Route::post('/exams/{exam}/register-schools', [ExamSchoolController::class, 'store'])->name('exams.storeSchools');
    Route::get('/exams/{exam}/unregister/{schoolId}', [ExamSchoolController::class, 'unregisterSchool'])->name('exams.unregister');



    Route::get('/gradings', [GradingController::class, 'index'])->name('gradings.index');
    Route::get('/gradings/{id}', [GradingController::class, 'show'])->name('gradings.show');
    Route::get('/gradings/create', [GradingController::class, 'create'])->name('gradings.create');
    Route::post('/gradings', [GradingController::class, 'store'])->name('gradings.store');
    Route::get('/gradings/{id}/edit', [GradingController::class, 'edit'])->name('gradings.edit');
    Route::put('/gradings/{id}', [GradingController::class, 'update'])->name('gradings.update');
    Route::delete('/gradings/{id}', [GradingController::class, 'destroy'])->name('gradings.destroy');

    Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::get('invoices/{id}/download-pdf', [PdfDownloadController::class, 'downloadInvoice'])
        ->name('invoice.pdf');


});
