<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Society;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;    
//use Illuminate\Database\Query\Builder;


class ReportController extends Controller
{
    
    public function getMemberReportMontrly(Request $request)
    {

        $cocietyIdList = Society::pluck('id')->toArray();
        $searchVal_society_id = 0;
        $searchVal_year = 0;
        $searchVal_month = 0;

        $dateValue = date('Y-m-d');
        $dateArr = explode("-", $dateValue);
        $currentYear = $dateArr[0];
        $currentMoth = $dateArr[1];  
        $searchVal = $currentMoth.'-'.$currentYear; // eg 01-2024

        if($request['pay_for_year'] != null){
            // $searchVal_year = $request['pay_for_year'];
            // $searchVal_month = $request['pay_for_month'];

            $currentYear = $request['pay_for_year'];
            $currentMoth = $request['pay_for_month']; 

            $searchVal_society_id = $request['society_id'];
            $searchVal = $currentMoth.'-'.$currentYear; // eg 01-2024

            if($searchVal_society_id != 0){
            $cocietyIdList = array();
                array_push($cocietyIdList, $searchVal_society_id);
            }
           
            $results = DB::table('society_members')
                ->select(
                    'society_members.*', 
                    'societies.code as societyCode',
                    'contribution_payments.pay_for_month_year as pay_month_year',
                    'contribution_payments.amount as contributionAmount',
                    'members.name as memberName',
                    DB::raw('(SELECT sum(amount) FROM contribution_payments WHERE contribution_payments.society_member_id = society_members.id) as totalContributionAmount'),
                    DB::raw('(SELECT count(society_member_reference_id) FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanRefered'),
                    DB::raw('(SELECT parent_id FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanReferedAccountId'),
                    DB::raw('(SELECT sum(full_amount) FROM loan_accounts WHERE loan_accounts.society_member_id = society_members.id) as totalLoanAmount')
                )
                //pay_for_month_year
                ->join('contribution_payments','contribution_payments.society_member_id','=','society_members.id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where(function($query) use ($searchVal) {
                    $query->where('contribution_payments.pay_for_month_year', 'like', '%' . $searchVal . '%');
                    //->orWhere('societies.code', 'like', '%' . $searchVal . '%');
                })
                ->where('society_members.is_delete', 0)
                //if($searchVal_society_id != 0){
                    ->whereIn('society_members.society_id', $cocietyIdList)
                    //->whereIn('book_returns.volunteer_id', $userIds)
                //}              
                ->orderBy('society_members.account_nummber', 'DESC')
                ->get();

            

        }else{

            $results = DB::table('society_members')
                ->select('society_members.*', 'societies.code as societyCode','members.name as memberName','contribution_payments.pay_for_month_year as pay_month_year', 'contribution_payments.amount as contributionAmount',
                    DB::raw('(SELECT sum(amount) FROM contribution_payments WHERE contribution_payments.society_member_id = society_members.id) as totalContributionAmount'),
                    DB::raw('(SELECT count(society_member_reference_id) FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanRefered'),
                    DB::raw('(SELECT parent_id FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanReferedAccountId'),
                    DB::raw('(SELECT sum(full_amount) FROM loan_accounts WHERE loan_accounts.society_member_id = society_members.id) as totalLoanAmount')
                )
                //pay_for_month_year
                ->join('contribution_payments','contribution_payments.society_member_id','=','society_members.id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where(function($query) use ($searchVal) {
                    $query->where('contribution_payments.pay_for_month_year', 'like', '%' . $searchVal . '%');
                    //->orWhere('societies.code', 'like', '%' . $searchVal . '%');
                })
                ->where('society_members.is_delete', 0)
                ->orderBy('society_members.account_nummber', 'DESC')
                ->get();
            
        }

        

            //dd($results);
            // get loan payment and intrest paymnet

            $memberLoanPayment = DB::table('loan_payments')
                ->select('loan_payments.loan_account_id', DB::raw('SUM(loan_payments.paid_amount) as total_paid_amount'), DB::raw('SUM(loan_payments.intrest_amount) as total_intrest_amount'))
                
                ->groupBy('loan_payments.loan_account_id')
                ->where('loan_payments.is_delete', 0)
                ->get();
            

            $memberLoanAccount = DB::table('loan_accounts')
                ->select('loan_accounts.full_amount','loan_accounts.society_member_id','loan_accounts.id')
                ->where('loan_accounts.is_delete', 0)
                ->where('loan_accounts.parent_id', 0)
                ->get();

                $laon_account_id_arr = array();
                $laonPay_member_arr = array();
                $laonIntPay_member_arr = array();

                $memberLoanAccount_arr = array();

                foreach ($memberLoanAccount as $value) {
                    $memberLoanAccount_arr[$value->society_member_id] = $value->full_amount;
                    $laon_account_id_arr[$value->society_member_id] = $value->id;
                    foreach ($memberLoanPayment as $payValue) {
                        //print_r($payValue);
                        if($value->id == $payValue->loan_account_id){
                            $laonPay_member_arr[$value->society_member_id] = $payValue->total_paid_amount;
                            $laonIntPay_member_arr[$value->society_member_id] = $payValue->total_intrest_amount;
                        }
                    }
                }

                $societyResults = DB::table('societies')
                ->select('societies.id', 'societies.name', 'societies.code')
                ->where('societies.is_delete', 0)
                ->get();


        return view('report.member_monthly', [
            'results' => $results,
            'laonPay_member_arr' => $laonPay_member_arr,
            'laonIntPay_member_arr' => $laonIntPay_member_arr, 
            'societyResults' => $societyResults,
            'memberLoanAccount_arr' => $memberLoanAccount_arr,
            'laon_account_id_arr' => $laon_account_id_arr,
            'searchVal_society_id' => $searchVal_society_id,
            'currentYear' => $currentYear,
            'currentMoth' => $currentMoth

        ]);

    }

    public function getMemberReport(Request $request)
    {
        //totalContributionAmount totalIntPayments totalLoanPayment
        // DB::raw('(SELECT sum(paid_amount) FROM loan_payments WHERE loan_payments.society_member_id = society_members.id) as totalLoanPayment'),
        // DB::raw('(SELECT sum(intrest_amount) FROM loan_payments WHERE loan_payments.society_member_id = society_members.id) as totalIntPayments'),
        $cocietyIdList = Society::pluck('id')->toArray();
        $searchVal_society_id = 0;
        if($request['society_id'] != null){
            $searchVal_society_id = $request['society_id'];
            if($searchVal_society_id != 0){
                $cocietyIdList = array();
                array_push($cocietyIdList, $searchVal_society_id);
            }
        }

        
        $results = DB::table('society_members')
                ->select('society_members.*', 'societies.code as societyCode','members.name as memberName',
                    DB::raw('(SELECT sum(amount) FROM contribution_payments WHERE contribution_payments.society_member_id = society_members.id) as totalContributionAmount'),
                    DB::raw('(SELECT sum(late_fine) FROM contribution_payments WHERE contribution_payments.society_member_id = society_members.id) as total_late_fine_amount'),   
                    DB::raw('(SELECT count(society_member_reference_id) FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id  and loan_accounts.is_delete = 0) as loanRefered'),

                    DB::raw('(SELECT parent_id FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id  and loan_accounts.is_delete = 0) as loanReferedAccountId'),

                    DB::raw('(SELECT count(society_member_reference_id) FROM loan_accounts WHERE loan_accounts.society_member_id = society_members.id AND loan_accounts.parent_id <> 0  and loan_accounts.is_delete = 0) as loanReferedCount'),

                    DB::raw('(SELECT sum(full_amount) FROM loan_accounts WHERE loan_accounts.society_member_id = society_members.id and loan_accounts.is_delete = 0) as totalLoanAmount')
                )
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->whereIn('society_members.society_id', $cocietyIdList)
                ->orderBy('society_members.account_nummber', 'asc')
                ->get();

           // dd($results);
            // get loan payment and intrest paymnet

            $memberLoanPayment = DB::table('loan_payments')
                ->select('loan_payments.loan_account_id', DB::raw('SUM(loan_payments.paid_amount) as total_paid_amount'), DB::raw('SUM(loan_payments.intrest_amount) as total_intrest_amount'))
                
                ->groupBy('loan_payments.loan_account_id')
                ->where('loan_payments.is_delete', 0)
                ->get();
            

            $memberLoanAccount = DB::table('loan_accounts')
                ->select('loan_accounts.full_amount','loan_accounts.society_member_id','loan_accounts.id')
                ->where('loan_accounts.is_delete', 0)
                ->where('loan_accounts.parent_id', 0)
                ->get();

                $laon_account_id_arr = array();
                $laonPay_member_arr = array();
                $laonIntPay_member_arr = array();

                $memberLoanAccount_arr = array();

                foreach ($memberLoanAccount as $value) {
                    $memberLoanAccount_arr[$value->society_member_id] = $value->full_amount;
                    $laon_account_id_arr[$value->society_member_id] = $value->id;
                    foreach ($memberLoanPayment as $payValue) {
                        //print_r($payValue);
                        if($value->id == $payValue->loan_account_id){
                            $laonPay_member_arr[$value->society_member_id] = $payValue->total_paid_amount;
                            $laonIntPay_member_arr[$value->society_member_id] = $payValue->total_intrest_amount;
                        }
                    }
                }

            $societyResults = DB::table('societies')
                ->select('societies.id', 'societies.name', 'societies.code')
                ->where('societies.is_delete', 0)
                ->get();

        return view('report.member', [
            'results' => $results,
            'laonPay_member_arr' => $laonPay_member_arr,
            'laonIntPay_member_arr' => $laonIntPay_member_arr, 
            'societyResults' => $societyResults,
            'searchVal_society_id' => $searchVal_society_id,
            'memberLoanAccount_arr' => $memberLoanAccount_arr,
            'laon_account_id_arr' => $laon_account_id_arr
        ]);

    }

    public function getContributionReport(Request $request)
    {
        $results = null;
        $results = DB::table('contribution_payments')
                ->select('contribution_payments.*', 'societies.name as societyName','members.name as memberName')
                ->join('society_members','society_members.id','=','contribution_payments.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('contribution_payments.is_delete', 0)
                ->orderBy('contribution_payments.created_at', 'Desc')
                ->get();

        $societyMembersLoan = DB::table('loan_accounts')
                ->select('loan_accounts.society_member_id', DB::raw('SUM(full_amount) as total_loan_taken'))
                ->groupBy('society_member_id')
                ->where('is_delete', 0)
                ->where('society_member_reference_id', 0)
                ->get();

        return view('report.contribution', ['results' => $results, 'societyMembersLoan' => $societyMembersLoan]);

    }

    public function getLoanReport(Request $request)
    {
        $cocietyIdList = Society::pluck('id')->toArray();
        $searchVal_society_id = 0;
        if($request['society_id'] != null){
            $searchVal_society_id = $request['society_id'];
            if($searchVal_society_id != 0){
                $cocietyIdList = array();
                array_push($cocietyIdList, $searchVal_society_id);
            }
        }

        // seavh based on month year
        $dateValue = date('Y-m-d');
        $dateArr = explode("-", $dateValue);
        $currentYear = $dateArr[0];
        $currentMoth = $dateArr[1];  
        $searchVal = $currentMoth.'-'.$currentYear; // eg 01-2024
        
        if($request['pay_for_year'] != null){
            $currentYear = $request['pay_for_year'];
            $currentMoth = $request['pay_for_month']; 
        }
       
        $loan_paymentsTotal = DB::table('loan_payments')
                ->select('loan_payments.loan_account_id', DB::raw('SUM(paid_amount) as total_paid_amount'), DB::raw('SUM(intrest_amount) as total_intrest_amount'))
                ->groupBy('loan_account_id')
                ->where('is_delete', 0)
                ->get();

        $results = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.code as societyCode','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.is_delete', 0)
                ->whereIn('society_members.society_id', $cocietyIdList)
                ->orderBy('loan_accounts.created_at', 'DESC')
                ->get();
                
        $societyResults = DB::table('societies')
                ->select('societies.id', 'societies.name', 'societies.code')
                ->where('societies.is_delete', 0)
                ->get();

        return view('report.loan', [
            'results' => $results,
            'societyResults' => $societyResults,            
            'loan_paymentsTotal' => $loan_paymentsTotal,
            'searchVal_society_id' => $searchVal_society_id,
            'currentYear' => $currentYear,
            'currentMoth' => $currentMoth
        ]);

    }

}
