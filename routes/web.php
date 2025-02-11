<?php

use App\Http\Controllers\ClassCatController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ClassSessionsController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\MyClassesController;
use App\Http\Controllers\MyScheduleController;
use App\Http\Controllers\MySchedulesController;
use App\Http\Controllers\MyTeachesController;
use App\Http\Controllers\MyTeachesScheduleController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\StudyCatController;
use App\Http\Controllers\StudyDetController;
use App\Http\Controllers\StudyMatController;
use App\Http\Controllers\StudySessionsController;
use App\Http\Controllers\TestCatController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\TestSessionsController;
use App\Http\Controllers\TrainCtsController;
use App\Http\Controllers\TrainerSchedulesController;
use App\Http\Controllers\TrainersController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('notifications', [NotificationsController::class, 'usernotifications'])->name('user.notifications');
    Route::get('readnotifications', [NotificationsController::class, 'readnotifications'])->name('user.readnotifications');

    Route::controller(DashboardsController::class)->group(function () {
        Route::get('dashboard/{year?}', 'index')->middleware(['auth', 'verified'])->name('dashboard');
    });

    // Employees
    Route::controller(EmployeesController::class)->group(function () {
        Route::get('employees/index/{employees_kywd?}', 'index')->middleware(['permission:list pegawai'])->name('employees');
    });

    // Participants
    Route::controller(ParticipantsController::class)->group(function () {
        Route::get('participants/index/{participants_kywd?}', 'index')->middleware(['permission:list peserta'])->name('participants');
        Route::get('participants/cancelledStudents/{cancelledStudents_kywd?}', 'cancelledStudents')->middleware(['permission:list peserta'])->name('participants.cancelledStudents');
        Route::get('participants/create', 'create')->middleware(['permission:create peserta'])->name('participants.create');
        Route::post('participants/store', 'store')->middleware(['permission:create peserta'])->name('participants.store');
        Route::get('participants/edit/{id}', 'edit')->middleware(['permission:edit peserta'])->name('participants.edit');
        Route::post('participants/update/{id}', 'update')->middleware(['permission:edit peserta'])->name('participants.update');
        Route::post('participants/delete', 'delete')->middleware(['permission:delete peserta'])->name('participants.delete');
        Route::post('participants/recover', 'recover')->middleware(['permission:delete peserta'])->name('participants.recover');
    });
    // Training Centers
    Route::controller(TrainCtsController::class)->group(function () {
        Route::get('traincts/index/{traincts_kywd?}', 'index')->middleware(['permission:list pusat pelatihan'])->name('traincts');
        Route::get('traincts/create', 'create')->middleware(['permission:create pusat pelatihan'])->name('traincts.create');
        Route::post('traincts/store', 'store')->middleware(['permission:create pusat pelatihan'])->name('traincts.store');
        Route::get('traincts/edit/{id}', 'edit')->middleware(['permission:edit pusat pelatihan'])->name('traincts.edit');
        Route::post('traincts/update/{id}', 'update')->middleware(['permission:edit pusat pelatihan'])->name('traincts.update');
        Route::post('traincts/delete', 'delete')->middleware(['permission:delete pusat pelatihan'])->name('traincts.delete');
        Route::post('traincts/recover', 'recover')->middleware(['permission:delete pusat pelatihan'])->name('traincts.recover');
    });
    // Instruktur / Pelatih
    Route::controller(TrainersController::class)->group(function () {
        Route::get('trainers/index/{trainers_kywd?}', 'index')->middleware(['permission:list pelatih'])->name('trainers');
        Route::get('trainers/create', 'create')->middleware(['permission:create pelatih'])->name('trainers.create');
        Route::post('trainers/selectpicker', 'trainers_selectpicker')->middleware(['permission:create pelatih|edit pelatih'])->name('trainers.selectpicker');
        Route::post('trainers/store', 'store')->middleware(['permission:create pelatih'])->name('trainers.store');
        Route::get('trainers/edit/{id}', 'edit')->middleware(['permission:edit pelatih'])->name('trainers.edit');
        Route::post('trainers/update/{id}', 'update')->middleware(['permission:edit pelatih'])->name('trainers.update');
        Route::post('trainers/delete', 'delete')->middleware(['permission:delete pelatih'])->name('trainers.delete');
        Route::post('trainers/recover', 'recover')->middleware(['permission:delete pelatih'])->name('trainers.recover');
    });
    // Jadwal Instruktur / Pelatih
    Route::controller(TrainerSchedulesController::class)->group(function () {
        Route::get('trainerschedules/index/{trainerschedules_kywd?}', 'index')->middleware(['permission:list jadwal pelatih'])->name('trainerschedules');
    });
    // Classes Category
    Route::controller(ClassCatController::class)->group(function () {
        Route::get('classcat/index/{classcat_kywd?}', 'index')->middleware(['permission:list kategori kelas'])->name('classcat');
        Route::get('classcat/create', 'create')->middleware(['permission:create kategori kelas'])->name('classcat.create');
        Route::post('classcat/store', 'store')->middleware(['permission:create kategori kelas'])->name('classcat.store');
        Route::get('classcat/edit/{id}', 'edit')->middleware(['permission:edit kategori kelas'])->name('classcat.edit');
        Route::post('classcat/update/{id}', 'update')->middleware(['permission:edit kategori kelas'])->name('classcat.update');
        Route::post('classcat/delete', 'delete')->middleware(['permission:delete kategori kelas'])->name('classcat.delete');
        Route::post('classcat/recover', 'recover')->middleware(['permission:delete kategori kelas'])->name('classcat.recover');
    });
    // Classes
    Route::controller(ClassesController::class)->group(function () {
        Route::get('classes/index/{classes_kywd?}', 'index')->middleware(['permission:list master kelas'])->name('classes');
        Route::get('classes/create', 'create')->middleware(['permission:create master kelas'])->name('classes.create');
        Route::post('classes/studies_selectpicker', 'studies_selectpicker')->middleware(['permission:create master kelas|edit master kelas'])->name('classes.studies_selectpicker');
        Route::get('classes/all_studies', 'all_studies')->middleware(['permission:create master kelas|edit master kelas'])->name('classes.all_studies');
        Route::post('classes/check_studies', 'check_studies')->middleware(['permission:create master kelas|edit master kelas'])->name('classes.check_studies');
        Route::get('classes/all_trainers', 'all_trainers')->middleware(['permission:create master kelas|edit master kelas'])->name('classes.all_trainers');
        Route::post('classes/pretests_selectpicker', 'pretests_selectpicker')->middleware(['permission:create master kelas|edit master kelas'])->name('classes.pretests_selectpicker');
        Route::post('classes/store', 'store')->middleware(['permission:create master kelas'])->name('classes.store');
        Route::get('classes/edit/{id}', 'edit')->middleware(['permission:edit master kelas'])->name('classes.edit');
        Route::post('classes/cancel_student', 'cancel_student')->middleware(['permission:edit master kelas'])->name('classes.cancel_student');
        Route::post('classes/update/{id}', 'update')->middleware(['permission:edit master kelas'])->name('classes.update');
        Route::post('classes/delete', 'delete')->middleware(['permission:delete master kelas'])->name('classes.delete');
        Route::post('classes/recover', 'recover')->middleware(['permission:delete master kelas'])->name('classes.recover');
        Route::post('classes/release', 'release')->middleware(['permission:edit master kelas'])->name('classes.release');
        Route::post('classes/updateMaterialPercentage', 'updateMaterialPercentage')->middleware(['permission:edit master kelas'])->name('classes.updateMaterialPercentage');
        Route::get('classes/getStudentByNip/{nip}/{index}', 'getStudentByNip')->middleware(['permission:edit master kelas'])->name('classes.getStudentByNip');
    });
    // Class Sessions
    Route::controller(ClassSessionsController::class)->group(function () {
        Route::get('class_sessions/index/{class_sessions_kywd?}', 'index')->middleware(['permission:list sesi kelas'])->name('class_sessions');
        Route::get('class_sessions/create/{classId}', 'create')->middleware(['permission:create sesi kelas'])->name('class_sessions.create');
        Route::post('class_sessions/participant_selectpicker', 'participant_selectpicker')->middleware(['permission:create sesi kelas|edit sesi kelas'])->name('class_sessions.participant_selectpicker');
        Route::post('class_sessions/store', 'store')->middleware(['permission:create sesi kelas'])->name('class_sessions.store');
        Route::get('class_sessions/edit/{id}', 'edit')->middleware(['permission:edit sesi kelas'])->name('class_sessions.edit');
        Route::get('class_sessions/getScheduleDetail/{scheduleId}', 'getScheduleDetail')->middleware(['permission:edit sesi kelas'])->name('class_sessions.getScheduleDetail');
        Route::post('class_sessions/updateSchedule', 'updateSchedule')->middleware(['permission:edit sesi kelas'])->name('class_sessions.updateSchedule');
        Route::post('class_sessions/cancel_student', 'cancel_student')->middleware(['permission:edit sesi kelas'])->name('class_sessions.cancel_student');
        Route::post('class_sessions/update/{id}', 'update')->middleware(['permission:edit sesi kelas'])->name('class_sessions.update');
        Route::post('class_sessions/delete', 'delete')->middleware(['permission:delete sesi kelas'])->name('class_sessions.delete');
        Route::post('class_sessions/deleteSchedule', 'deleteSchedule')->middleware(['permission:delete sesi kelas'])->name('class_sessions.deleteSchedule');
        Route::post('class_sessions/recover', 'recover')->middleware(['permission:delete sesi kelas'])->name('class_sessions.recover');
    });
    // Studies Category
    Route::controller(StudyCatController::class)->group(function () {
        Route::get('studycat/index/{studycat_kywd?}', 'index')->middleware(['permission:list kategori materi'])->name('studycat');
        Route::get('studycat/create', 'create')->middleware(['permission:create kategori materi'])->name('studycat.create');
        Route::post('studycat/store', 'store')->middleware(['permission:create kategori materi'])->name('studycat.store');
        Route::get('studycat/edit/{id}', 'edit')->middleware(['permission:edit kategori materi'])->name('studycat.edit');
        Route::post('studycat/update/{id}', 'update')->middleware(['permission:edit kategori materi'])->name('studycat.update');
        Route::post('studycat/delete', 'delete')->middleware(['permission:delete kategori materi'])->name('studycat.delete');
        Route::post('studycat/recover', 'recover')->middleware(['permission:delete kategori materi'])->name('studycat.recover');
    });
    // Studies
    Route::controller(StudiesController::class)->group(function () {
        Route::get('studies/index/{studies_kywd?}', 'index')->middleware(['permission:list bank materi'])->name('studies');
        Route::get('studies/create', 'create')->middleware(['permission:create bank materi'])->name('studies.create');
        Route::post('studies/store', 'store')->middleware(['permission:create bank materi'])->name('studies.store');
        Route::get('studies/edit/{id}', 'edit')->middleware(['permission:edit bank materi'])->name('studies.edit');
        Route::post('studies/update/{id}', 'update')->middleware(['permission:edit bank materi'])->name('studies.update');
        Route::post('studies/delete', 'delete')->middleware(['permission:delete bank materi'])->name('studies.delete');
        Route::post('studies/recover', 'recover')->middleware(['permission:delete bank materi'])->name('studies.recover');
    });
    // Studies Detail (permission is same as bank materi)
    Route::controller(StudyDetController::class)->group(function () {
        Route::get('studydet/create', 'create')->middleware(['permission:create bank materi'])->name('studydet.create');
        Route::post('studydet/store', 'store')->middleware(['permission:create bank materi'])->name('studydet.store');
        Route::get('studydet/edit/{id}', 'edit')->middleware(['permission:edit bank materi'])->name('studydet.edit');
        Route::post('studydet/update/{id}', 'update')->middleware(['permission:edit bank materi'])->name('studydet.update');
        Route::post('studydet/delete', 'delete')->middleware(['permission:delete bank materi'])->name('studydet.delete');
        Route::post('studydet/recover', 'recover')->middleware(['permission:delete bank materi'])->name('studydet.recover');
        Route::get('studydet/attachment', 'attachment')->name('studydet.attachment');
        Route::get('studydet/getdeleted', 'get_deleted')->name('studydet.getdeleted');
    });
    // Test Category
    Route::controller(TestCatController::class)->group(function () {
        Route::get('testcat/index/{testcat_kywd?}', 'index')->middleware(['permission:list kategori tes'])->name('testcat');
        Route::get('testcat/create', 'create')->middleware(['permission:create kategori tes'])->name('testcat.create');
        Route::post('testcat/store', 'store')->middleware(['permission:create kategori tes'])->name('testcat.store');
        Route::get('testcat/edit/{id}', 'edit')->middleware(['permission:edit kategori tes'])->name('testcat.edit');
        Route::post('testcat/update/{id}', 'update')->middleware(['permission:edit kategori tes'])->name('testcat.update');
        Route::post('testcat/delete', 'delete')->middleware(['permission:delete kategori tes'])->name('testcat.delete');
        Route::post('testcat/recover', 'recover')->middleware(['permission:delete kategori tes'])->name('testcat.recover');
    });
    // Tests
    Route::controller(TestsController::class)->group(function () {
        Route::get('tests/index/{tests_kywd?}', 'index')->middleware(['permission:list tes'])->name('tests');
        Route::get('tests/create', 'create')->middleware(['permission:create tes'])->name('tests.create');
        Route::post('tests/store', 'store')->middleware(['permission:create tes'])->name('tests.store');
        Route::get('tests/edit/{id}', 'edit')->middleware(['permission:edit tes'])->name('tests.edit');
        Route::post('tests/release', 'release')->middleware(['permission:edit tes'])->name('tests.release');
        Route::post('tests/update/{id}', 'update')->middleware(['permission:edit tes'])->name('tests.update');
        Route::post('tests/delete', 'delete')->middleware(['permission:delete tes'])->name('tests.delete');
        Route::post('tests/recover', 'recover')->middleware(['permission:delete tes'])->name('tests.recover');
        Route::get('tests/getTestDetail/{testId}', 'getTestDetail')->middleware(['permission:list tes'])->name('tests.getTestDetail');
    });
    // Questions
    Route::controller(QuestionsController::class)->group(function () {
        Route::get('questions/index/{questions_kywd?}', 'index')->middleware(['permission:list pertanyaan'])->name('questions');
        Route::get('questions/create', 'create')->middleware(['permission:create pertanyaan'])->name('questions.create');
        Route::post('questions/store', 'store')->middleware(['permission:create pertanyaan'])->name('questions.store');
        Route::get('questions/edit/{id}', 'edit')->middleware(['permission:edit pertanyaan'])->name('questions.edit');
        Route::post('questions/update/{id}', 'update')->middleware(['permission:edit pertanyaan'])->name('questions.update');
        Route::post('questions/delete', 'delete')->middleware(['permission:delete pertanyaan'])->name('questions.delete');
        Route::post('questions/recover', 'recover')->middleware(['permission:delete pertanyaan'])->name('questions.recover');
    });
    // File
    Route::controller(FileController::class)->group(function () {
        Route::post('file/uploadatt', 'upload_study_attachment')->name('file.upload_studyatt');
    });
    // File Upload (Excel)
    Route::controller(FileUploadController::class)->group(function () {
        Route::post('fileUpload/uploadEnrollments', 'uploadEnrollments')->name('fileUpload.uploadEnrollments');
        Route::post('fileUpload/uploadQuestions', 'uploadQuestions')->name('fileUpload.uploadQuestions');
    });
    // Users
    Route::controller(UsersController::class)->group(function () {
        Route::get('users/index/{users_kywd?}', 'index')->middleware(['permission:list users'])->name('users');
        Route::get('users/edit/{id}', 'edit')->middleware(['permission:edit users'])->name('users.edit');
        Route::post('users/update/{id}', 'update')->middleware(['permission:edit users'])->name('users.update');
        Route::post('users/delete', 'delete')->name('users.delete');
    });
    // Roles
    Route::controller(RolesController::class)->group(function () {
        Route::get('roles/index/{roles_kywd?}', 'index')->middleware(['permission:list roles'])->name('roles');
        Route::get('roles/create', 'create')->middleware(['permission:create roles'])->name('roles.create');
        Route::post('roles/store', 'store')->middleware(['permission:create roles'])->name('roles.store');
        Route::get('roles/edit/{id}', 'edit')->middleware(['permission:edit roles'])->name('roles.edit');
        Route::post('roles/update/{id}', 'update')->middleware(['permission:edit roles'])->name('roles.update');
        Route::post('roles/delete', 'delete')->middleware(['permission:delete roles'])->name('roles.delete');
    });
    // Permissions
    Route::controller(PermissionController::class)->group(function () {
        Route::get('permissions/index/{permissions_kywd?}', 'index')->middleware(['permission:list permissions'])->name('permissions');
        Route::get('permissions/create/', 'create')->middleware(['permission:create permissions'])->name('permissions.create');
        Route::post('permissions/store/', 'store')->middleware(['permission:create permissions'])->name('permissions.store');
        Route::get('permissions/edit/{id}', 'edit')->middleware(['permission:edit permissions'])->name('permissions.edit');
        Route::post('permissions/update/{id}', 'update')->middleware(['permission:edit permissions'])->name('permissions.update');
        Route::post('permissions/delete', 'delete')->middleware(['permission:delete permissions'])->name('permissions.delete');
    });

    // Kelasku (Student)
    Route::controller(MyClassesController::class)->group(function () {
        Route::get('myclasses/index/{myclasses_kywd?}', 'index')->middleware(['permission:list kelasku'])->name('myclasses');
        Route::get('myclasses/create', 'create')->middleware(['permission:create kelasku'])->name('myclasses.create');
        Route::post('myclasses/store', 'store')->middleware(['permission:create kelasku'])->name('myclasses.store');
        Route::get('myclasses/edit/{id}', 'edit')->middleware(['permission:edit kelasku'])->name('myclasses.edit');
        Route::post('myclasses/update/{id}', 'update')->middleware(['permission:edit kelasku'])->name('myclasses.update');
        Route::post('myclasses/delete', 'delete')->middleware(['permission:delete kelasku'])->name('myclasses.delete');
        Route::post('myclasses/recover', 'recover')->middleware(['permission:delete kelasku'])->name('myclasses.recover');
        Route::get('myclasses/passStatusCheck/{class_sessions}', 'passStatusCheck')->middleware(['permission:list kelasku'])->name('myclasses.passStatusCheck');
    });

    // Jadwalku (Student)
    Route::controller(MySchedulesController::class)->group(function () {
        Route::get('myschedules/index/{myschedules_kywd?}', 'index')->middleware(['permission:list jadwalku'])->name('myschedules');
        Route::get('myschedules/create', 'create')->middleware(['permission:create jadwalku'])->name('myschedules.create');
        Route::post('myschedules/store', 'store')->middleware(['permission:create jadwalku'])->name('myschedules.store');
        Route::get('myschedules/edit/{id}', 'edit')->middleware(['permission:edit jadwalku'])->name('myschedules.edit');
        Route::post('myschedules/update/{id}', 'update')->middleware(['permission:edit jadwalku'])->name('myschedules.update');
        Route::post('myschedules/delete', 'delete')->middleware(['permission:delete jadwalku'])->name('myschedules.delete');
        Route::post('myschedules/recover', 'recover')->middleware(['permission:delete jadwalku'])->name('myschedules.recover');
    });

    // Kelas Diampu (Instructor)
    Route::controller(MyTeachesController::class)->group(function () {
        Route::get('myteaches/index/{myteaches_kywd?}', 'index')->middleware(['permission:list kelas diampu'])->name('myteaches');
        Route::post('myteaches/startClassSession', 'startClassSession')->middleware(['permission:list kelas diampu'])->name('myteaches.startClassSession');
    });

    // Jadwalku (Student)
    Route::controller(MyTeachesScheduleController::class)->group(function () {
        Route::get('myteachesschedule/index/{myteachesschedule_kywd?}', 'index')->middleware(['permission:list jadwal kelas diampu'])->name('myteachesschedule');
        Route::get('myteachesschedule/create', 'create')->middleware(['permission:create jadwal kelas diampu'])->name('myteachesschedule.create');
        Route::post('myteachesschedule/store', 'store')->middleware(['permission:create jadwal kelas diampu'])->name('myteachesschedule.store');
        Route::get('myteachesschedule/edit/{id}', 'edit')->middleware(['permission:edit jadwal kelas diampu'])->name('myteachesschedule.edit');
        Route::post('myteachesschedule/update/{id}', 'update')->middleware(['permission:edit jadwal kelas diampu'])->name('myteachesschedule.update');
        Route::post('myteachesschedule/delete', 'delete')->middleware(['permission:delete jadwal kelas diampu'])->name('myteachesschedule.delete');
        Route::post('myteachesschedule/recover', 'recover')->middleware(['permission:delete jadwal kelas diampu'])->name('myteachesschedule.recover');
    });

    // Classrooms
    Route::controller(ClassroomsController::class)->group(function () {
        Route::get('classrooms/index/{class_id}/{role}', 'index')->middleware(['permission:list ruang kelas'])->name('classrooms');
        Route::post('classrooms/getClassSessions', 'getClassSessions')->middleware(['permission:list ruang kelas'])->name('classrooms.getClassSessions');
        Route::get('classrooms/getSessionSchedule/{sessionId}/{role}', 'getSessionSchedule')->middleware(['permission:list ruang kelas'])->name('classrooms.getSessionSchedule');
    });

    // Study Sessions
    Route::controller(StudySessionsController::class)->group(function () {
        Route::get('studySessions/index/{studyId}/{scheduleId}', 'index')->middleware(['permission:list ruang kelas'])->name('studySessions');
        Route::post('studySessions/getClassSessions', 'getClassSessions')->middleware(['permission:list ruang kelas'])->name('studySessions.getClassSessions');
        Route::get('studySessions/getSessionSchedule/{sessionId}', 'getSessionSchedule')->middleware(['permission:list ruang kelas'])->name('studySessions.getSessionSchedule');
        Route::get('studySessions/studyMaterialPlayback/{scheduleId}/{attachmentId}', 'studyMaterialPlayback')->middleware(['permission:list ruang kelas'])->name('studySessions.studyMaterialPlayback');
        Route::get('studySessions/studyMaterialFile/{scheduleId}/{attachmentId}', 'studyMaterialFile')->middleware(['permission:list ruang kelas'])->name('studySessions.studyMaterialFile');
    });

    // Test Sessions
    Route::controller(TestSessionsController::class)->group(function () {
        Route::get('testSessions/index/{testId}/{scheduleId}', 'index')->middleware(['permission:list ruang kelas'])->name('testSessions');
        Route::get('testSessions/questions/{testScheduleId}/{testId}', 'questions')->middleware(['permission:list ruang kelas'])->name('testSessions.questions');
        Route::post('testSessions/startStudentTest', 'startStudentTest')->middleware(['permission:list ruang kelas'])->name('testSessions.startStudentTest');
        Route::get('testSessions/getCountdown/{scheduleId}', 'getCountdown')->middleware(['permission:list ruang kelas'])->name('testSessions.getCountdown');
        Route::post('testSessions/submitTest', 'submitTest')->middleware(['permission:list ruang kelas'])->name('testSessions.submitTest');
        Route::get('testSessions/testResult/{nip}/{studentTestId}/{role}', 'testResult')->middleware(['permission:list ruang kelas'])->name('testSessions.testResult');
    });

    // Reports
    Route::controller(ReportsController::class)->group(function () {
        // Route::get('reports/graduation_rate/{report_kywd?}/{year?}', 'graduationRate')->middleware(['permission:list graduation rate'])->name('reports.graduationRate');
        Route::get('reports/class_performance/{report_kywd?}/{class_category?}/{startPeriod?}/{endPeriod?}', 'classPerformance')->middleware(['permission:list performa kelas'])->name('reports.classPerformance');
        Route::get('reports/export_class_performance/{report_kywd?}/{year?}', 'exportClassPerformance')->middleware(['permission:list performa kelas'])->name('reports.exportClassPerforance');
        Route::get('reports/mortality_rate/{report_kywd?}/{year?}', 'mortalityRate')->middleware(['permission:list mortality'])->name('reports.mortalityRate');
        Route::get('reports/student_graduation_rate/{report_kywd?}/{branch_selected?}', 'studentGraduationRate')->middleware(['permission:list student graduation rate'])->name('reports.studentGraduationRate');
        Route::get('reports/class_performance_detail/{class_id}', 'classPerformanceDetail')->middleware(['permission:list performa kelas'])->name('reports.class_performance_detail');
    });

    // Exports
    Route::controller(ExportController::class)->group(function () {
        Route::get('/export/class_performance', 'classPerformance')->name('export.classPerformance');
        Route::get('/export/class_performance_detail/{class_id}', 'classPerformanceDetail')->name('export.classPerformanceDetail');
        Route::get('/export/mortality_rate', 'mortalityRate')->name('export.mortalityRate');
        Route::get('/export/student_performance', 'studentPerformance')->name('export.studentPerformance');
        Route::get('/export/tests/{classId}', 'tests')->name('export.tests');
        // Route::get('/export_mortality_rate', 'exportMortalityRate')->name('exportMortalityRate');
    });
});

require __DIR__ . '/auth.php';
