<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Society;
use App\Models\Member;
use App\Models\SocietyMembers;
use App\Models\ContributionPayment;
use App\Models\LoanAccount;
use App\Models\LoanPayment;


use Illuminate\Support\Facades\DB;     

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        
        $userCount = User::where('is_delete', '0')->count();
        $societiesCount = Society::where('is_delete', '0')->count();
        $memberCount = Member::where('is_delete', '0')->count();
        $societiesMemberCount = SocietyMembers::where('is_delete', '0')->count();
        $contribution_payment = ContributionPayment::where('is_delete', '0')->sum('amount');

        $loanAccountCount = LoanAccount::where('parent_id', '0')->where('is_delete', '0')->count();
        $loanAmountOutStanding = LoanAccount::where('parent_id', '0')->where('is_delete', '0')->sum('full_amount');
        
        $loanPaid = LoanPayment::where('is_delete', '0')->sum('paid_amount');
        $loanIntrestPaind = LoanPayment::where('is_delete', '0')->sum('intrest_amount');

        $contactUsCount = SocietyMembers::where('is_delete', '0')->count();



        return view('dashboard', compact('userCount','societiesCount','memberCount','societiesMemberCount','contribution_payment', 'loanAccountCount', 'loanAmountOutStanding','loanPaid','loanIntrestPaind','contactUsCount'));
        
    }

}