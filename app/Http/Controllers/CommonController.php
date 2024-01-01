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
        
        $userCount = User::count();
        $societiesCount = Society::count();
        $memberCount = Member::count();
        $societiesMemberCount = SocietyMembers::count();
        $contribution_payment = ContributionPayment::sum('amount');

        $loanAccountCount = LoanAccount::where('parent_id', '0')->count();
        $loanAmountOutStanding = LoanAccount::where('parent_id', '0')->sum('full_amount');
        
        $loanPaid = LoanPayment::sum('paid_amount');
        $loanIntrestPaind = LoanPayment::sum('intrest_amount');



        return view('dashboard', compact('userCount','societiesCount','memberCount','societiesMemberCount','contribution_payment', 'loanAccountCount', 'loanAmountOutStanding','loanPaid','loanIntrestPaind'));
        
    }

}