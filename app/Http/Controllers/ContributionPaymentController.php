<?php

namespace App\Http\Controllers;

use App\Models\ContributionPayment;
use App\Http\Requests\StoreContributionPaymentRequest;
use App\Http\Requests\UpdateContributionPaymentRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ContributionPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request['search'] != null){
            $searchVal = $request['search'];
            
            $results = DB::table('contribution_payments')
            ->select('contribution_payments.*', 'societies.name as societyName','members.name as memberName')
            ->join('society_members','society_members.id','=','contribution_payments.society_member_id')
            ->join('societies','societies.id','=','society_members.society_id')
            ->join('members','members.id','=','society_members.member_id')
            ->where(function($query) use ($searchVal) {
                $query->where('societies.name', 'like', '%' . $searchVal . '%')
                ->orWhere('members.name', 'like', '%' . $searchVal . '%');
            })
            ->where('contribution_payments.is_delete', 0)
            ->orderBy('contribution_payments.created_at', 'Desc')
            ->paginate();

        }else{
            $results = DB::table('contribution_payments')
                ->select('contribution_payments.*', 'societies.name as societyName','members.name as memberName')
                ->join('society_members','society_members.id','=','contribution_payments.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('contribution_payments.is_delete', 0)
                ->orderBy('contribution_payments.created_at', 'Desc')
                ->paginate();
        }
        
        $societyMembersLoan = DB::table('loan_accounts')
                ->select('loan_accounts.society_member_id', DB::raw('SUM(full_amount) as total_loan_taken'))
                ->groupBy('society_member_id')
                ->where('is_delete', 0)
                ->where('society_member_reference_id', 0)
                ->get();

        //dd($societyMembersLoan);

        //return view('contribution_payment.index', compact('results'));
        return view('contribution_payment.index', ['results' => $results, 'societyMembersLoan' => $societyMembersLoan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$results = null;
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code', 'societies.maximum_loan_amount', 'societies.intrest_rate')
            ->where('societies.is_delete', 0)
            ->get();

        $societyMembersResults = DB::table('society_members')
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->get();

      
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
                $memberLoanAccount_arr = array();
                foreach ($memberLoanAccount as $value) {
                    $memberLoanAccount_arr[$value->society_member_id] = $value->full_amount;
                    $laon_account_id_arr[$value->society_member_id] = $value->id;
                    foreach ($memberLoanPayment as $payValue) {
                        //print_r($payValue);
                        if($value->id == $payValue->loan_account_id){
                            $laonPay_member_arr[$value->society_member_id] = $payValue->total_paid_amount;
                        }
                    }
                }
               // dd($laonPay_member_arr);

        $results = DB::table('contribution_payments')
                ->select('contribution_payments.*', 'societies.name as societyName','members.name as memberName')
                ->join('society_members','society_members.id','=','contribution_payments.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('contribution_payments.is_delete', 0)
                ->orderBy('contribution_payments.created_at', 'DESC')
                ->limit(10)
                ->get();

        return view('contribution_payment.add', [
            'societyMembersResults' => $societyMembersResults,
            'societyResults' => $societyResults,
            'laonPay_member_arr' => $laonPay_member_arr, 
            'memberLoanAccount_arr' => $memberLoanAccount_arr,
            'laon_account_id_arr' => $laon_account_id_arr,
            'results' => $results
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContributionPaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedFormData = $request->validate([
            'society_member_id' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'late_fine' => 'required|string|max:255',
            'pay_date' => 'required|string|max:255',
            'pay_for_month' => 'required|string|max:255',
            'pay_for_year' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);
        
        $pay4Month = $validatedFormData['pay_for_month'].'-'.$validatedFormData['pay_for_year'];
        $isAlreadyPaid = ContributionPayment::where('society_member_id', $validatedFormData['society_member_id'])
                                ->where('pay_for_month_year', $pay4Month)
                                ->first();
        //dd($isAlreadyPaid);
        if (is_null($isAlreadyPaid)) {
            $sqlQury = new ContributionPayment(); 
            $sqlQury->society_member_id = $validatedFormData['society_member_id'];

            $sqlQury->amount = $validatedFormData['amount'];
            $sqlQury->late_fine = $validatedFormData['late_fine'];
            $sqlQury->pay_date = $validatedFormData['pay_date'];
            $sqlQury->pay_for_month_year = $pay4Month;
            
            $sqlQury->status = $validatedFormData['status'];
            $sqlQury->is_delete = 0;
            $sqlQury->save();

            if($request['saveBtn'] != null){
                return redirect()->route('contribution_payment.index')->with('success', 'Record save successfully');
            }else{

                $results = DB::table('contribution_payments')
                ->select('contribution_payments.*', 'societies.name as societyName','members.name as memberName')
                ->join('society_members','society_members.id','=','contribution_payments.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('contribution_payments.is_delete', 0)
                ->orderBy('contribution_payments.created_at', 'Desc')
                ->limit(10)
                ->get();

                //session_pay_for_year  session_pay_for_month session_pay_date session_amount session_late_fine session_society_id

                return redirect()->route('contribution_payment.create')->with( [
                    'success' => 'Record save successfully',
                    'results' => $results,
                    'session_society_id' => $request['society_id'],
                    'session_amount' => $request['amount'],
                    'session_late_fine' => $request['late_fine'], 
                    'session_pay_for_month' => $request['pay_for_month'], 
                    'session_pay_for_year' => $request['pay_for_year'], 
                    'session_pay_date' => $request['pay_date']
                ]);

            }

        }else{

            return redirect()->route('contribution_payment.create')->with('error', 'Record already exists');

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContributionPayment  $contributionPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ContributionPayment $contributionPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContributionPayment  $contributionPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $results = ContributionPayment::find($id);
        $societyMembersResults = DB::table('society_members')
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->get();

        return view('contribution_payment.edit', ['results' => $results, 'societyMembersResults' => $societyMembersResults]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContributionPaymentRequest  $request
     * @param  \App\Models\ContributionPayment  $contributionPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedFormData = $request->validate([
            'society_member_id' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'late_fine' => 'required|string|max:255',
            'pay_date' => 'required|string|max:255',
            'pay_for_month' => 'required|string|max:255',
            'pay_for_year' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);
        
        $pay4Month = $validatedFormData['pay_for_month'].'-'.$validatedFormData['pay_for_year'];
        $isAlreadyPaid = ContributionPayment::where('society_member_id', $validatedFormData['society_member_id'])
                                ->where('pay_for_month_year', $pay4Month)
                                ->where('id', '!=', $id)
                                ->first();
        //dd($isAlreadyPaid);
        if (is_null($isAlreadyPaid)) {
            //$sqlQury = new ContributionPayment(); 
            $sqlQury = ContributionPayment::findOrFail($id);
            $sqlQury->society_member_id = $validatedFormData['society_member_id'];

            $sqlQury->amount = $validatedFormData['amount'];
            $sqlQury->late_fine = $validatedFormData['late_fine'];
            $sqlQury->pay_date = $validatedFormData['pay_date'];
            $sqlQury->pay_for_month_year = $pay4Month;
            
            $sqlQury->status = $validatedFormData['status'];
            $sqlQury->is_delete = 0;
            $sqlQury->save();

            return redirect()->route('contribution_payment.index')->with('success', 'Record save successfully');

        }else{

            return redirect()->route('contribution_payment.edit',[$id])->with('error', 'Record already exists');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContributionPayment  $contributionPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = ContributionPayment::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('contribution_payment.index')->with('success', 'Record deleted successfully');
    }
}
