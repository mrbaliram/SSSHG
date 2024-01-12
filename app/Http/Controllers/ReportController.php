<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;    

class ReportController extends Controller
{
    
    public function getMemberReportMontrly(Request $request)
    {
        $results = DB::table('society_members')
                ->select('society_members.*', 'societies.code as societyCode','members.name as memberName',
                    DB::raw('(SELECT sum(amount) FROM contribution_payments WHERE contribution_payments.society_member_id = society_members.id) as totalContributionAmount'),
                    DB::raw('(SELECT count(society_member_reference_id) FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanRefered'),

                    DB::raw('(SELECT parent_id FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanReferedAccountId'),

                    DB::raw('(SELECT sum(full_amount) FROM loan_accounts WHERE loan_accounts.society_member_id = society_members.id) as totalLoanAmount')
                )
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->orderBy('society_members.account_nummber', 'DESC')
                ->get();

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



        return view('report.member_monthly', [
            'results' => $results,
            'laonPay_member_arr' => $laonPay_member_arr,
            'laonIntPay_member_arr' => $laonIntPay_member_arr, 
            
            'memberLoanAccount_arr' => $memberLoanAccount_arr,
            'laon_account_id_arr' => $laon_account_id_arr
        ]);

    }

    public function getMemberReport(Request $request)
    {
        //totalContributionAmount totalIntPayments totalLoanPayment
        // DB::raw('(SELECT sum(paid_amount) FROM loan_payments WHERE loan_payments.society_member_id = society_members.id) as totalLoanPayment'),
        // DB::raw('(SELECT sum(intrest_amount) FROM loan_payments WHERE loan_payments.society_member_id = society_members.id) as totalIntPayments'),

         $results = DB::table('society_members')
                ->select('society_members.*', 'societies.code as societyCode','members.name as memberName',
                    DB::raw('(SELECT sum(amount) FROM contribution_payments WHERE contribution_payments.society_member_id = society_members.id) as totalContributionAmount'),
                    DB::raw('(SELECT count(society_member_reference_id) FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanRefered'),

                    DB::raw('(SELECT parent_id FROM loan_accounts WHERE loan_accounts.society_member_reference_id = society_members.id) as loanReferedAccountId'),

                    DB::raw('(SELECT sum(full_amount) FROM loan_accounts WHERE loan_accounts.society_member_id = society_members.id) as totalLoanAmount')
                )
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->orderBy('society_members.account_nummber', 'DESC')
                ->get();

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



        return view('report.member', [
            'results' => $results,
            'laonPay_member_arr' => $laonPay_member_arr,
            'laonIntPay_member_arr' => $laonIntPay_member_arr, 
            
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
        $results = null;
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
                ->orderBy('loan_accounts.created_at', 'DESC')
                ->get();
        return view('report.loan', ['results' => $results, 'loan_paymentsTotal' => $loan_paymentsTotal]);

    }

}
