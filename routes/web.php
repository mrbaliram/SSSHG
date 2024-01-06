<?php
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberTypeController;
use App\Http\Controllers\SocietyRuleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SocietyMembersController;
use App\Http\Controllers\ContributionPaymentController;
use App\Http\Controllers\LoanPaymentController;

use App\Http\Controllers\LoanAccountController;
use App\Http\Controllers\CommonController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

// dashboard
Route::get('/dashboard', [CommonController::class, 'dashboard'])->name('dashboard.dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /// user/user list view suer_profile
    Route::get('/user', [ProfileController::class, 'index'])->name('user.index');
    Route::get('/user/add', [ProfileController::class, 'add'])->name('user.add');
    Route::post('/user', [ProfileController::class, 'store'])->name('user.store');
    Route::get('/user/{user}/edit', [ProfileController::class, 'edit_user'])->name('user.edit');
    Route::put('/user/{user}', [ProfileController::class, 'update_user'])->name('user.update');

    Route::put('/user/{user}', [ProfileController::class, 'update_user'])->name('user.update');
    Route::delete('/user/{user}', [ProfileController::class, 'delete_user'])->name('user.delete');
    
    // society adde edit delete show 
    Route::get('/society', [SocietyController::class, 'index'])->name('society.index');
    Route::delete('/society/{id}', [SocietyController::class, 'destroy'])->name('society.destroy');
    Route::get('/society/{id}/show', [SocietyController::class, 'show'])->name('society.show');

    Route::get('/society/create', [SocietyController::class, 'create'])->name('society.create');
    Route::post('/society/store', [SocietyController::class, 'store'])->name('society.store');

    Route::get('/society/{id}/edit', [SocietyController::class, 'edit'])->name('society.edit');
    Route::put('/society/{id}', [SocietyController::class, 'update'])->name('society.update');

    // member_type.index
    Route::get('/member_type', [MemberTypeController::class, 'index'])->name('member_type.index');
    Route::get('/member_type/create', [MemberTypeController::class, 'create'])->name('member_type.create');
    Route::post('/member_type/store', [MemberTypeController::class, 'store'])->name('member_type.store');
    Route::get('/member_type/{id}/edit', [MemberTypeController::class, 'edit'])->name('member_type.edit');
    Route::put('/member_type/{id}', [MemberTypeController::class, 'update'])->name('member_type.update');
    Route::delete('/member_type/{id}', [MemberTypeController::class, 'destroy'])->name('member_type.destroy');

    //society_rule C:\Projects\bitBucket\sssgh\app\Http\Controllers\SocietyRuleController.php
    Route::get('/society_rule', [SocietyRuleController::class, 'index'])->name('society_rule.index');
    Route::get('/society_rule/create', [SocietyRuleController::class, 'create'])->name('society_rule.create');
    Route::post('/society_rule/store', [SocietyRuleController::class, 'store'])->name('society_rule.store');
    Route::get('/society_rule/{id}/edit', [SocietyRuleController::class, 'edit'])->name('society_rule.edit');
    Route::put('/society_rule/{id}', [SocietyRuleController::class, 'update'])->name('society_rule.update');
    Route::delete('/society_rule/{id}', [SocietyRuleController::class, 'destroy'])->name('society_rule.destroy');
    Route::get('/society_rule/{id}/show', [SocietyRuleController::class, 'show'])->name('society_rule.show');

    // C:\Projects\bitBucket\sssgh\app\Http\Controllers\MemberController.php
    //member add edit delete and show 
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::delete('/member/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
    Route::get('/member/{id}/show', [MemberController::class, 'show'])->name('member.show');

    Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');

    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');

    // society_member add edit and delete
    Route::get('/society_member', [SocietyMembersController::class, 'index'])->name('society_member.index');
    Route::delete('/society_member/{id}', [SocietyMembersController::class, 'destroy'])->name('society_member.destroy');
    Route::get('/society_member/{id}/show', [SocietyMembersController::class, 'show'])->name('society_member.show');

    Route::get('/society_member/create', [SocietyMembersController::class, 'create'])->name('society_member.create');
    Route::post('/society_member/store', [SocietyMembersController::class, 'store'])->name('society_member.store');

    Route::get('/society_member/{id}/edit', [SocietyMembersController::class, 'edit'])->name('society_member.edit');
    Route::put('/society_member/{id}', [SocietyMembersController::class, 'update'])->name('society_member.update');

    // contribution_payment - ContributionPaymentController
    Route::get('/contribution_payment', [ContributionPaymentController::class, 'index'])->name('contribution_payment.index');
    Route::delete('/contribution_payment/{id}', [ContributionPaymentController::class, 'destroy'])->name('contribution_payment.destroy');
    Route::get('/contribution_payment/{id}/show', [ContributionPaymentController::class, 'show'])->name('contribution_payment.show');

    Route::get('/contribution_payment/create', [ContributionPaymentController::class, 'create'])->name('contribution_payment.create');
    Route::post('/contribution_payment/store', [ContributionPaymentController::class, 'store'])->name('contribution_payment.store');

    Route::get('/contribution_payment/{id}/edit', [ContributionPaymentController::class, 'edit'])->name('contribution_payment.edit');
    Route::put('/contribution_payment/{id}', [ContributionPaymentController::class, 'update'])->name('contribution_payment.update');

    // loan_account - LoanAccountController
    Route::get('/loan_account', [LoanAccountController::class, 'index'])->name('loan_account.index');
    Route::delete('/loan_account/{id}', [LoanAccountController::class, 'destroy'])->name('loan_account.destroy');
    Route::get('/loan_account/{id}/show', [LoanAccountController::class, 'show'])->name('loan_account.show');

    Route::get('/loan_account/create', [LoanAccountController::class, 'create'])->name('loan_account.create');
    Route::post('/loan_account/store', [LoanAccountController::class, 'store'])->name('loan_account.store');

    Route::get('/loan_account/{id}/edit', [LoanAccountController::class, 'edit'])->name('loan_account.edit');
    Route::put('/loan_account/{id}', [LoanAccountController::class, 'update'])->name('loan_account.update');

    Route::get('/loan_account/{id}/refrence', [LoanAccountController::class, 'refrence'])->name('loan_account.refrence');
    //loan_account_refrence
    Route::put('/loan_account/{id}/loan_account_refrence', [LoanAccountController::class, 'loan_account_refrence'])->name('loan_account.loan_account_refrence');


    // loan_payment - Controllers\LoanPaymentController.php
    Route::get('/loan_payment', [LoanPaymentController::class, 'index'])->name('loan_payment.index');
    Route::delete('/loan_payment/{id}', [LoanPaymentController::class, 'destroy'])->name('loan_payment.destroy');
    Route::get('/loan_payment/{id}/show', [LoanPaymentController::class, 'show'])->name('loan_payment.show');
    Route::get('/loan_payment/create', [LoanPaymentController::class, 'create'])->name('loan_payment.create');
    Route::post('/loan_payment/store', [LoanPaymentController::class, 'store'])->name('loan_payment.store');
    Route::get('/loan_payment/{id}/edit', [LoanPaymentController::class, 'edit'])->name('loan_payment.edit');
    Route::put('/loan_payment/{id}', [LoanPaymentController::class, 'update'])->name('loan_payment.update');


});

require __DIR__.'/auth.php';
