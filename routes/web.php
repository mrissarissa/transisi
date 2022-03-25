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

Route::get('/', function () {
    if (Auth::check()) {
    	return redirect()->route('home.index');
    }

    return redirect('/login');
});

Route::get('/auth', 'Auth\LoginController@showLogin')->name('auth.showLogin');
Route::post('/auth/loginaction', 'Auth\LoginController@loginAction')->name('auth.loginAction');
Route::post('/auth/logoutaction', 'Auth\LoginController@logoutAction')->name('auth.logoutAction');

Auth::routes();

Route::middleware('auth')->group(function(){
	Route::prefix('/dashboard')->group(function(){
		Route::get('', 'DashboardController@index')->name('home.index');
	});
	

	//account setting
	Route::prefix('/user')->group(function(){
		Route::get('/myAccount', 'User\AccountController@myAccount')->name('account.myAccount');
		Route::post('/myAccount/edit', 'User\AccountController@editPassword')->name('account.editPassword');
	});

	Route::prefix('/admin')->middleware(['permission:menu-user-management'])->group(function(){
		//user account
		Route::get('/user-account', 'Admin\AdminController@user_account')->name('admin.user_account');
		Route::get('/user-account/get-data', 'Admin\AdminController@getDataUser')->name('admin.getDataUser');
		Route::get('/user-account/ajaxGetRole', 'Admin\AdminController@ajaxGetRole')->name('admin.ajaxGetRole');
		Route::get('/user-account/add-user', 'Admin\AdminController@addUser')->name('admin.addUser');
		Route::get('/user-account/edit', 'Admin\AdminController@formEditUser')->name('admin.formEditUser');
		Route::get('/user-account/edit/edit-user', 'Admin\AdminController@editAccount')->name('admin.editAccount');
		Route::get('/user-account/edit/reset-password', 'Admin\AdminController@passwordReset')->name('admin.passwordReset');
		Route::get('/user-account/innactive', 'Admin\AdminController@innactiveUser')->name('admin.innactiveUser');
		Route::get('/user-account/factory', 'Admin\AdminController@getFactory')->name('admin.getFactory');

		//role
		Route::get('/role', 'Admin\AdminController@formRole')->name('admin.formRole');
		Route::get('/role/get-data', 'Admin\AdminController@ajaxRoleData')->name('admin.ajaxRoleData');
		Route::get('/role/new-role', 'Admin\AdminController@newRole')->name('admin.newRole');
		Route::post('/role/add-role', 'Admin\AdminController@addRole')->name('admin.addRole');
		Route::get('/role/edit', 'Admin\AdminController@editRoleUser')->name('admin.editRoleUser');
		Route::post('/role/update-role', 'Admin\AdminController@updateRole')->name('admin.updateRole');
	});

	
	


});


