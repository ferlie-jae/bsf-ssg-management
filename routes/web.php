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
	return redirect()->route('website.index');
});

Route::get('home', function () {
	return redirect()->route('dashboard');
})->name('home');

Auth::routes();

Route::get('/pages/vision_mission', 'PageController@visionMission')->name('pages.vision_mission');
Route::get('/pages/achievements', 'PageController@achievements')->name('pages.achievements');
Route::get('/pages/officers', 'PageController@officers')->name('pages.officers');

Route::get('homepage', 'WebsiteController@index')->name('website.index');
Route::get('vision-mission', 'WebsiteController@visionMission')->name('website.vision_mission');
Route::get('bsf-hmn', 'WebsiteController@bsfHymn')->name('website.bsf_hymn');
Route::get('history', 'WebsiteController@history')->name('website.history');
Route::get('bsf-achievements', 'WebsiteController@achievements')->name('website.achievements');
Route::get('contact-us', 'WebsiteController@contactUs')->name('website.contact_us');
Route::post('contact-us/submit', 'WebsiteController@submitContactUs')->name('website.submit_contact_us');
Route::get('campus-officials', 'WebsiteController@campusOfficials')->name('website.campus_officials');
Route::get('ssg-officials', 'WebsiteController@ssgOfficials')->name('website.ssg_officials');
Route::get('campus-news', 'WebsiteController@campusNews')->name('website.campus_news');
Route::get('courses-offered', 'WebsiteController@coursesOffered')->name('website.courses');
Route::get('enrollment-procedure', 'WebsiteController@enrollmentProcedure')->name('website.enrollment_procedure');


Route::get('dashboard', 'HomeController@index')->name('dashboard');
Route::group(array('middleware'=>['auth']), function() {

	if(config('app.permissions') == true){
		/**
		 * Roles and Permissions
		 */
		Route::resource('roles', 'Configuration\RolePermission\RoleController');
		// Route::get('/roles_get_data', 'Configuration\RolePermission\RoleController@get_data')->name('roles.get_data');
		// restore
		Route::post('roles/restore/{department}', [
			'as' => 'roles.restore',
			'uses' => 'Configuration\RolePermission\RoleController@restore'
		]);
	}
    
    Route::resource('permissions', 'Configuration\RolePermission\PermissionController');
	// Route::get('/permissions_get_data', 'Configuration\RolePermission\PermissionController@get_data')->name('permissions.get_data');
	// restore
	Route::post('permissions/restore/{department}', [
		'as' => 'permissions.restore',
		'uses' => 'Configuration\RolePermission\PermissionController@restore'
	]);
	
	/**
	 * Positions
	 */
	Route::resource('positions', 'Configuration\PositionController');
	// restore
	Route::post('positions_restore/{position}', [
		'as' => 'positions.restore',
		'uses' => 'Configuration\PositionController@restore'
	]);

	/**
	 * Sections
	 */
	Route::resource('sections', 'Configuration\SectionController');
	// restore
	Route::post('sections_restore/{section}', [
		'as' => 'sections.restore',
		'uses' => 'Configuration\SectionController@restore'
	]);

	/**
	 * Student
	 */
	Route::resource('students', 'StudentController');
	Route::put('students_update_avatar/{student}', 'StudentController@changeAvatar')->name('students.change_avatar');
	// restore
	Route::post('students_restore/{position}', [
		'as' => 'students.restore',
		'uses' => 'StudentController@restore'
	]);

	/**
	 * Faculty
	 */
	/* Route::resource('faculties', 'Configuration\FacultyController')->parameters([
		'faculties' => 'faculty'
	]); */
	Route::resource('faculties', 'FacultyController');
	Route::put('faculties_update_avatar/{faculty}', 'FacultyController@changeAvatar')->name('faculties.change_avatar');
	// restore
	Route::post('faculties_restore/{position}', [
		'as' => 'faculties.restore',
		'uses' => 'FacultyController@restore'
	]);

	/**
	 * Elections
	 */
	Route::resource('partylists', 'PartylistController');
	Route::post('partylists_restore/{partylist}', [
		'as' => 'partylists.restore',
		'uses' => 'PartylistController@restore'
	]);
	/**
	 * Elections
	 */
	Route::resource('elections', 'ElectionController');
	// restore
	Route::get('elections/get_election_data/{election}', 'ElectionController@getElectionData')->name('votes.get_election_data');
	Route::get('elections/end/{election}', 'ElectionController@endElection')->name('elections.end');
	Route::get('election_result', 'ElectionController@results')->name('elections.results');
	Route::get('election/export', 'ElectionController@export')->name('elections.export');
	// Route::post('elections/update_status/{election}', 'ElectionController@updateStatus')->name('elections.update_status');
	Route::post('elections_restore/{election}', [
		'as' => 'elections.restore',
		'uses' => 'ElectionController@restore'
	]);

	/**
	 * Votes
	 */
	Route::resource('votes', 'VoteController');
	Route::post('get_election_data/{election}', [
		'as' => 'votes.get_election_data',
		'uses' => 'VoteController@getElectionData'
	]);
	// restore
	Route::post('votes_restore/{vote}', [
		'as' => 'votes.restore',
		'uses' => 'VoteController@restore'
	]);

	/**
	 * Tasks
	 */
	Route::resource('tasks', 'TaskController');
	// restore
	Route::get('tasks_done/{task}', [
		'as' => 'tasks.mark_as_done',
		'uses' => 'TaskController@markAsDone'
	]);
	Route::post('tasks_restore/{task}', [
		'as' => 'tasks.restore',
		'uses' => 'TaskController@restore'
	]);

	/**
	 * Achievements
	 */
	Route::resource('achievements', 'AchievementController');
	Route::get('achievements_page', [
		'as' => 'achievements.page',
		'uses' => 'AchievementController@page'
	]);
	// restore
	Route::post('achievements_restore/{achievement}', [
		'as' => 'achievements.restore',
		'uses' => 'AchievementController@restore'
	]);

	/**
	 * Announcements
	 */
	Route::resource('announcements', 'AnnouncementController');
	/* Route::get('announcements_page', [
		'as' => 'announcements.page',
		'uses' => 'AnnouncementController@page'
	]); */
	/* Route::get('announcements_notification', [
		'as' => 'announcements.notification',
		'uses' => 'AnnouncementController@notification'
	]); */
	
	// restore
	Route::post('announcements_restore/{announcement}', [
		'as' => 'announcements.restore',
		'uses' => 'AnnouncementController@restore'
	]);


    
    /**
	 * Users
	 */
	Route::resource('users', 'UserController');
	// sidebar collapase
	/* Route::get('user_sidebar_collapse', [
		'as' => 'users.sidebar_collapse',
		'uses' => 'UserController@sidebar_collapse'
	]); */
	Route::get('account/{user}', 'UserController@account')->name('account.index');
	Route::put('change_avatar/{user}', 'UserController@changeAvatar')->name('users.change_avatar');
	Route::put('change_password/{user}', 'UserController@changePassword')->name('users.change_password');
	Route::get('user_activate/{user}', 'UserController@activate')->name('users.activate');
	Route::get('user_deactivate/{user}', 'UserController@deactivate')->name('users.deactivate');
	// restore
	Route::post('users_restore/{user}', [
		'as' => 'users.restore',
		'uses' => 'UserController@restore'
	]);

	
});
/**	
 * Dev
 */
Route::get('announcements_notification', [
	'as' => 'announcements.notification',
	'uses' => 'AnnouncementController@notification'
]);
Route::post('insert_student', ['as' => 'dummy_identity.insert_student', 'uses' => 'RandomIdentityController@insert_student']);
Route::post('insert_faculty', ['as' => 'dummy_identity.insert_faculty', 'uses' => 'RandomIdentityController@insert_faculty']);
Route::post('votes/random_votes', 'VoteController@randomVotes')->name('votes.random_votes');
