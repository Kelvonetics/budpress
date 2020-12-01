<?php

use App\Expense;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/', function () 
{
    return view('auth.login');
});



Route::post('/authenticate','Auth\Login@authenticate')->name('authenticate');

Auth::routes();

Route::get('/', function () 
{
    return view('welcome');
});

Route::middleware('auth:api')->get('/user', function (Request $request) 
{
    return $request->user();
});








//dashboard
Route::get('get_exams', 'HomeController@getExams');
Route::get('completed_exams', 'HomeController@completedExams');
Route::get('total_live_exams', 'HomeController@totalLiveExams');
Route::get('total_exam_users', 'HomeController@totalExamUsers');
Route::get('users_finished', 'HomeController@finishedUsers');
Route::get('total_live_users', 'HomeController@totalLiveUsers');






//User
//List Users
Route::get('users', 'UserController@index', function() { return User::with(['state', 'department'])->get(); });
Route::get('user/{id}', 'UserController@show');
Route::post('user', 'UserController@store');
Route::put('user', 'UserController@store');
Route::delete('user/{id}', 'UserController@destroy');

//List Departments
Route::get('departments', 'DepartmentController@index');
Route::get('department/{id}', 'DepartmentController@show');
Route::post('department', 'DepartmentController@store');
Route::put('department', 'DepartmentController@store');
Route::delete('department/{id}', 'DepartmentController@destroy');

//List Roles
Route::get('roles', 'RoleController@index');
Route::get('role/{id}', 'RoleController@show');
Route::post('role', 'RoleController@store');
Route::put('role', 'RoleController@store');
Route::delete('role/{id}', 'RoleController@destroy');


//List Permissions
Route::get('permissions', 'PermissionController@index', function() { return Permission::with('department')->get(); });
Route::get('permission/{id}', 'PermissionController@show');
Route::post('permission', 'PermissionController@store');
Route::put('permission', 'PermissionController@store');
Route::delete('permission/{id}', 'PermissionController@destroy');




//List Permissions
Route::get('assignPermissions', 'AssignPermissionController@index');
Route::get('assignPermission/{id}', 'AssignPermissionController@show');
Route::post('assignPermission', 'AssignPermissionController@store');
Route::put('assignPermission', 'AssignPermissionController@store');
Route::delete('assignPermission/{id}', 'AssignPermissionController@destroy');
Route::put('/assign/permissions/{id}', 'DepartmentController@update_assign_permissions');


//List Budgets
Route::get('budgets', 'BudgetController@index', function() { return Budget::with(['workflow', 'department', 'action'])->get(); });
Route::get('budget/{id}', 'BudgetController@show');
Route::post('budget', 'BudgetController@store');
Route::put('budget', 'BudgetController@store');
Route::delete('budget/{id}', 'BudgetController@destroy');
Route::get('budget-imprests/{id}', 'BudgetController@budgetImprests', function() { return Imprest::with(['budget', 'workflow', 'department', 'action'])->get(); });

Route::get('get-budget-balances', 'BudgetController@getBalance');


//List Imprests
Route::get('imprests', 'ImprestController@index', function() { return Imprest::with(['budget', 'workflow', 'department', 'action'])->get(); });
Route::get('imprest/{id}', 'ImprestController@show');
Route::post('imprest', 'ImprestController@store');
Route::put('imprest', 'ImprestController@store');
Route::delete('imprest/{id}', 'ImprestController@destroy');
Route::get('budget-imprest-expenses/{id}', 'ImprestController@budgetImprestExpenses', function() { return Expense::with(['imprest', 'action'])->get(); });


//List Expeses
Route::get('expenses', 'ExpenseController@index', function() { return Expense::with(['imprest', 'action'])->get(); });
Route::get('expense/{id}', 'ExpenseController@show');
Route::post('expense', 'ExpenseController@store');
Route::put('expense', 'ExpenseController@store');
Route::delete('expense/{id}', 'ExpenseController@destroy');






//List Workflows
Route::get('workflows', 'WorkflowController@index');
Route::get('workflow/{id}', 'WorkflowController@show');
Route::post('workflow', 'WorkflowController@store');
Route::put('workflow', 'WorkflowController@store');
Route::delete('workflow/{id}', 'WorkflowController@destroy');


//List Flows
Route::get('flows', 'FlowController@index', function() { return Flow::with(['workflow', 'user'])->get(); });
Route::get('flow/{id}', 'FlowController@show');
Route::post('flow', 'FlowController@store');
Route::put('flow', 'FlowController@store');
Route::delete('flow/{id}', 'FlowController@destroy');



//Designation
Route::get('states', 'GeneralController@states');
Route::get('actions', 'GeneralController@actions', function() { return Action::with(['workflow', 'user', 'action'])->get(); });
// Route::get('departments', 'DepartmentController@index');
Route::post('track-history', 'TrackHistoryController@store');
