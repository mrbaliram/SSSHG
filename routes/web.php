<?php
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberTypeController;
use App\Http\Controllers\SocietyRuleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SocietyMembersController;
use App\Http\Controllers\ContributionPaymentController;

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

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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


});

require __DIR__.'/auth.php';
