<?php

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

use App\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackendLogController;
use App\Http\Controllers\BackendUsersController;
use App\Http\Controllers\RebrandingSettingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Setting\SettingController;

Route::match(['get', 'post'], '/', [AdminController::class,'login'])->middleware('guest'); //admin login
Route::group(['prefix' => 'admin'], function () {

    /**
     *Admin Login
     */
    Route::match(['get', 'post'], '/login', [AdminController::class,'login'])->name('admin.login')->middleware('guest'); //admin login
    Route::match(['get', 'post'], '/login/otp', [AdminController::class,'loginOTP'])->name('admin.login.otp')->middleware('guest');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', [AdminController::class,'logout'])->name('admin.logout'); //admin logout

        Route::get('/dashboard', [AdminController::class,'index'])->name('admin.dashboard'); //admin dashboard
        // Route::post('/dashboard/yearly-graph-paypoint', "AdminController@payPointYearly")->name('admin.dashboard.paypoint.yearly'); //admin yearly graph
        // Route::post('/dashboard/yearly-graph-npay', "AdminController@nPayYearly")->name('admin.dashboard.npay.yearly'); //admin yearly graphStat Dashboard KYC

        /**
         * Backend users
         */
        Route::get('/backend-user', [BackendUsersController::class,'view'])->name('backendUser.view')->middleware('permission:Backend users view');
        Route::match(['get', 'post'], '/backend-user/create', [BackendUsersController::class,'create'])->name('backendUser.create')->middleware('permission:Backend user create');
        Route::match(['get', 'post'], '/permission/{user_id}', [BackendUsersController::class,'permission'])->name('backendUser.permission')->middleware('permission:Backend user update permission');
        Route::match(['get', 'post'], '/role/{user_id}', [BackendUsersController::class,'role'])->name('backendUser.role')->middleware('permission:Backend user update role');

        Route::match(['get', 'post'], '/backend-user/profile', 'BackendUsersController@profile')->name('backendUser.profile')->middleware('permission:Backend user update profile');
        Route::match(['get', 'post'], '/backend-user/change-password', 'BackendUsersController@changePassword')->name('backendUser.changePassword')->middleware('permission:Backend user change password');
        Route::post('/backend-user/reset-password', 'BackendUsersController@resetPassword')->name('backendUser.resetPassword')->middleware('permission:Backend user reset password');
        // Route::match(['get', 'post'], '/deactivate-User/{user_id}', 'BackendUsersController@deactivateUser')->name('backendUser.deactivate')->middleware('permission:Backend user deactivate');

        // Route::get('backend-user-changed-kyc', 'BackendUsersController@kycList')->name('backendUser.kycList')->middleware('permission:KYC list changed by backend user view');

        Route::get('/roles', [RoleController::class,'view'])->name('role.view')->middleware('permission:Roles view');
        Route::match(['get', 'post'], '/roles/create', [RoleController::class,'create'])->name('role.create')->middleware('permission:Role create');
        Route::match(['get', 'post'], '/role/edit/{role_id}', [RoleController::class,'edit'])->name('role.edit')->middleware('permission:Role edit');

        // /**
        //  * Backend log
        //  */
        Route::get('/backend-log/all', [BackendLogController::class,'all'])->name('backendLog.all')->middleware('permission:Backend user log view');
        // /**
        //  * API log
        //  */
        // Route::get('/api-log', 'APILogController@all')->name('apiLog.all')->middleware('permission:Api log');

        // /**
        //  * Force password change
        //  */
        // Route::post('/force-password-change', 'Auth\ForcePasswordChangeController@forcePasswordChange')->name('user.forcePasswordChange');
        // Route::match(['get', 'post'], '/force-group-password-change', 'Auth\ForcePasswordChangeController@groupForcePasswordChange')->name('group.forcePasswordChange')->middleware('permission:Group force password change');

        // /**
        //  * Logs
        //  */
        // Route::get('/logs/user-session', 'LogController@userSession')->name('admin.log.userSession')->middleware('permission:User session log view');
        // Route::get('/logs/merchant-session', 'LogController@merchantSession')->name('admin.log.merchantSession');
        // Route::get('/logs/auditing', 'LogController@auditing')->name('admin.log.auditing')->middleware('permission:Auditing log view');
        // Route::get('/logs/profiling', 'LogController@profiling')->name('admin.log.profiling')->middleware('permission:Profiling log view');
        // Route::get('/logs/statistics', 'LogController@statistics')->name('admin.log.statistics')->middleware('permission:Statistics log view');
        // Route::get('/logs/development', 'LogController@development')->name('admin.log.development')->middleware('permission:Development log view');

        

        /**
         * General Settings
         */
        Route::match(['get', 'post'], '/settings/general', [SettingController::class,'generalSetting'])->name('settings.general')->middleware('permission:General setting view|General setting update');

        Route::match(['get','post'], 'settings/rebranding', [SettingController::class,'rebrandingSetting'])->name('settings.rebranding')->middleware('permission:Rebranding setting|Rebranding setting update');

        Route::match(['get','post'], 'settings/rebranding-update', [RebrandingSettingController::class,'rebrandingSettingUpdate'])->name('settings.rebrandingUpdate')->middleware('permission:Rebranding setting update');
        // // Route::get('general-setting', 'GeneralSettingController@index')->name('general.setting.index')->middleware('permission:General page setting view');
        // // Route::match(['get', 'post'], 'general-setting/create', 'GeneralSettingController@create')->name('general.setting.create')->middleware('permission:General page setting create');
        // Route::match(['get', 'post'], 'general-setting/update/{id}', 'GeneralSettingController@update')->name('general.setting.update')->middleware('permission:General page setting update');
        // Route::post('general-setting/delete/', 'GeneralSettingController@delete')->name('general.setting.delete')->middleware('permission:General page setting delete');

        // /**
        //  * Frontend
        //  */
        // //header
        // // Route::match(['get', 'post'], 'frontend/header', 'Frontend\HeaderController@index')->name('frontend.header')->middleware('permission:Frontend header view');
        // // Route::get('frontend/multiple-headers', 'Frontend\HeaderController@MultipleHeadersIndex')->name('frontend.multipleHeader')->middleware('permission:Frontend header view');
        // Route::get('frontend/create/header', 'Frontend\HeaderController@create')->name('frontend.header.create')->middleware('permission:Frontend header create');
        // Route::post('frontend/create/header', 'Frontend\HeaderController@store')->name('frontend.header.store')->middleware('permission:Frontend header create');
        // Route::get('frontend/edit/header{id}', 'Frontend\HeaderController@edit')->name('frontend.header.edit')->middleware('permission:Frontend header update');
        // Route::post('frontend/edit/header{id}', 'Frontend\HeaderController@update')->name('frontend.header.update')->middleware('permission:Frontend header update');
        // Route::post('frontend/delete/header', 'Frontend\HeaderController@delete')->name('frontend.header.delete')->middleware('permission:Frontend header delete');

        // //NeWS
        // //todo: create permission
        // // Route::get('frontend/news', 'Frontend\NewsController@index')->name('frontend.news.index')->middleware('permission:Frontend news view');
        // Route::match(['get', 'post'], 'frontend/create/news', 'Frontend\NewsController@create')->name('frontend.news.create')->middleware('permission:Frontend news create');
        // Route::match(['get', 'post'], 'frontend/update/news/{id}', 'Frontend\NewsController@update')->name('frontend.news.update')->middleware('permission:Frontend news update');
        // Route::post('frontend/delete/news/', 'Frontend\NewsController@delete')->name('frontend.news.delete')->middleware('permission:Frontend news delete');

        // //Solutions
        // //todo: create permission
        // // Route::get('frontend/solutions', 'Frontend\SolutionController@index')->name('frontend.solution.index')->middleware('permission:Frontend solution view');
        // Route::match(['get', 'post'], 'frontend/create/solution', 'Frontend\SolutionController@create')->name('frontend.solution.create')->middleware('permission:Frontend solution create');
        // Route::match(['get', 'post'], 'frontend/update/solution/{id}', 'Frontend\SolutionController@update')->name('frontend.solution.update')->middleware('permission:Frontend solution update');
        // Route::post('frontend/delete/solution/', 'Frontend\SolutionController@delete')->name('frontend.solution.delete')->middleware('permission:Frontend solution delete');

        // //Partners
        // //todo: create permission
        // // Route::get('frontend/partners', 'Frontend\PartnerController@index')->name('frontend.partner.index')->middleware('permission:Frontend partner view');
        // Route::match(['get', 'post'], 'frontend/create/partner', 'Frontend\PartnerController@create')->name('frontend.partner.create')->middleware('permission:Frontend partner create');
        // Route::match(['get', 'post'], 'frontend/update/partner/{id}', 'Frontend\PartnerController@update')->name('frontend.partner.update')->middleware('permission:Frontend partner update');
        // Route::post('frontend/delete/partner/', 'Frontend\PartnerController@delete')->name('frontend.partner.delete')->middleware('permission:Frontend partner delete');

        // //services
        // // Route::get('frontend/services', 'Frontend\ServiceController@index')->name('frontend.service.index')->middleware('permission:Frontend service view');
        // Route::match(['get', 'post'], 'frontend/service/create', 'Frontend\ServiceController@create')->name('frontend.service.create')->middleware('permission:Frontend service create');
        // Route::match(['get', 'post'], 'frontend/service/update/{id}', 'Frontend\ServiceController@update')->name('frontend.service.update')->middleware('permission:Frontend service update');
        // Route::post('frontend/service/delete/', 'Frontend\ServiceController@delete')->name('frontend.service.delete')->middleware('permission:Frontend service delete');

        // //abouts
        // // Route::get('frontend/abouts', 'Frontend\AboutController@index')->name('frontend.about.index')->middleware('permission:Frontend about view');
        // Route::match(['get', 'post'], 'frontend/about/create', 'Frontend\AboutController@create')->name('frontend.about.create')->middleware('permission:Frontend about create');
        // Route::match(['get', 'post'], 'frontend/about/update/{id}', 'Frontend\AboutController@update')->name('frontend.about.update')->middleware('permission:Frontend about update');
        // Route::post('frontend/about/delete/', 'Frontend\AboutController@delete')->name('frontend.about.delete')->middleware('permission:Frontend about delete');

        // //Process
        // // Route::get('frontend/processes', 'Frontend\ProcessController@index')->name('frontend.process.index')->middleware('permission:Frontend process view');
        // Route::match(['get', 'post'], 'frontend/process/create', 'Frontend\ProcessController@create')->name('frontend.process.create')->middleware('permission:Frontend process create');
        // Route::match(['get', 'post'], 'frontend/process/update/{id}', 'Frontend\ProcessController@update')->name('frontend.process.update')->middleware('permission:Frontend process update');
        // Route::post('frontend/process/delete/', 'Frontend\ProcessController@delete')->name('frontend.process.delete')->middleware('permission:Frontend process delete');

        // //Banner
        // // Route::get('frontend/banner', 'Frontend\BannerController@index')->name('frontend.banner.index')->middleware('permission:Frontend banner view');
        // Route::match(['get', 'post'], 'frontend/banner/create', 'Frontend\BannerController@create')->name('frontend.banner.create');
        // Route::match(['get', 'post'], 'frontend/banner/update/{id}', 'Frontend\BannerController@update')->name('frontend.banner.update');
        // Route::post('frontend/banner/delete/', 'Frontend\BannerController@delete')->name('frontend.banner.delete');

        // //Contact Us
        // // Route::match(['get', 'post'], 'frontend/contact-us', 'Frontend\ContactController@index')->name('frontend.contact')->middleware('permission:Frontend contact view');

        // //RequestInfo


        // Route::get('request-info', 'RequestInfoController@index')->name('requestinfo.index')->middleware('permission:View request info');

        // Route::get('/excel/request-info', 'PhpSpreadSheetController@requestInfo')->name('requestinfo.excel')->middleware('permission:View request info');


        // //Run seeder
        // // Route::get('/view-seeder-table', 'SeederController@index')->name('view.seeder')->middleware('permission:View seeder list');
        // Route::post('/view-seeder-table/{className}', 'SeederController@runSeeder')->name('seeder.run')->middleware('permission:Run seeder');

    });
});
