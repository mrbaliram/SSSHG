<?php

namespace App\Http\Controllers;

use App\Models\LoanAccount;
use App\Models\LoanPayment;

use App\Http\Requests\StoreLoanAccountRequest;
use App\Http\Requests\UpdateLoanAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class LoanAccountController extends Controller
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
             $results = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.code as societyCode','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where(function($query) use ($searchVal) {
                    $query->where('societies.name', 'like', '%' . $searchVal . '%')
                    ->orWhere('societies.code', 'like', '%' . $searchVal . '%')
                    ->orWhere('members.name', 'like', '%' . $searchVal . '%');
                })
                ->where('loan_accounts.is_delete', 0)
                ->paginate();
        }else{
            $results = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.code as societyCode','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.is_delete', 0)
                ->orderBy('loan_accounts.created_at', 'DESC')
                ->paginate();
        }


        $loan_paymentsTotal = DB::table('loan_payments')
                ->select('loan_payments.loan_account_id', DB::raw('SUM(paid_amount) as total_paid_amount'), DB::raw('SUM(intrest_amount) as total_intrest_amount'))
                ->groupBy('loan_account_id')
                ->where('is_delete', 0)
                ->get();

        //dd( $loan_paymentsTotal);
       // DB::raw('SUM(price) as total_sales')

        //$loanPayment = LoanPayment::Where('loan_payments',true)
        // $loanPayment = DB::table('loan_accounts')
        //     ->selectRaw("SUM(loan_accounts.paid_amount) as total_paid_amount")
        //     ->selectRaw("SUM(loan_accounts.intrest_amount) as total_intrest_amount")
        //     ->groupBy('loan_accounts.loan_account_id')
        //     ->get();

        //     dd($loanPayment);

    //     $users = User::join('elanlar', 'elanlar.user_id', 'users.id')
    // ->select([
    //    'users.*', 
    //     DB::raw('(SELECT COUNT(*) FROM elanlar WHERE elanlar.user_id = users.id) as elan_sayi')
    // ])->where('elanlar.country_id', 19)->groupBy('users.id');
                //loan_paymentsTotal
        //return view('loan_account.index', compact('results'));

         return view('loan_account.index', ['results' => $results, 'loan_paymentsTotal' => $loan_paymentsTotal]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $results = null;
        $societyMembersResults = DB::table('society_members')
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->get();

        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code', 'societies.maximum_loan_amount', 'societies.intrest_rate')
            ->where('societies.is_delete', 0)
            ->get();

        return view('loan_account.add', ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoanAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $validatedFormData = $request->validate([
            'amount' => 'required|string|max:255',
            'society_member_id' => 'required|string|max:255',
            'full_amount' => 'required|string|max:255',
            'intrest_rate' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);
       
        $sqlQury = new LoanAccount();
        $sqlQury->amount = $validatedFormData['amount'];
        $sqlQury->full_amount = $validatedFormData['full_amount'];
        $sqlQury->society_member_id = $validatedFormData['society_member_id'];
        $sqlQury->intrest_rate = $validatedFormData['intrest_rate'];
        $sqlQury->start_date = $validatedFormData['start_date'];
        $sqlQury->end_date = $validatedFormData['end_date'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->is_delete = 0;
        $sqlQury->save();

        return redirect()->route('loan_account.index')->with('success', 'Record save successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanAccount  $loanAccount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $loan_paymentsResults = DB::table('loan_payments')
                ->select('loan_payments.*', 'societies.name as societyName','members.name as memberName')
                
                ->join('loan_accounts','loan_accounts.id','=','loan_payments.loan_account_id')

                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')

                ->where('loan_payments.is_delete', 0)
                ->where('loan_payments.loan_account_id', $id)
                ->orderBy('loan_payments.created_at', 'Desc')
                ->paginate();

        $results = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.id as societyId','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.id', $id)
                ->get();

        $results = $results[0];
        //society_member_id
        $societyMembersResults = DB::table('society_members')
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->where('societies.id', $results->societyId)
                ->where('society_members.id','!=', $results->society_member_id)
                ->get();

        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code', 'societies.maximum_loan_amount', 'societies.intrest_rate')
            ->where('societies.id', $results->societyId)
            ->get();

        $allRefrences = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.id as societyId','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_reference_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.parent_id', $id)
                ->get();
        
        return view('loan_account.payment_history', ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults,'allRefrences' => $allRefrences, 'loan_paymentsResults' => $loan_paymentsResults]);


       //return view('loan_account.payment_history', ['results' => $results]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanAccount  $loanAccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $results = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.id as societyId','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.id', $id)
                ->get();

        $results = $results[0];
        $societyMembersResults = DB::table('society_members')
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->where('societies.id', $results->societyId)
                ->get();

        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code', 'societies.maximum_loan_amount', 'societies.intrest_rate')
            ->where('societies.id', $results->societyId)
            ->get();

        return view('loan_account.edit', ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoanAccountRequest  $request
     * @param  \App\Models\LoanAccount  $loanAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sqlQury = LoanAccount::findOrFail($id);
        
        $validatedFormData = $request->validate([
            'society_member_id' => 'required|string|max:255',
            'full_amount' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);
        
        //$sqlQury->amount = $validatedFormData['amount'];
        //$sqlQury->intrest_rate = $validatedFormData['intrest_rate'];
        $sqlQury->full_amount = $validatedFormData['full_amount'];
        $sqlQury->society_member_id = $validatedFormData['society_member_id'];
        $sqlQury->start_date = $validatedFormData['start_date'];
        $sqlQury->end_date = $validatedFormData['end_date'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->is_delete = 0;
        $sqlQury->save();

        return redirect()->route('loan_account.index')->with('success', 'Record save successfully');
    }

    //refrence
    public function refrence($id)
    {
        
        $results = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.id as societyId','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.id', $id)
                ->get();

        $results = $results[0];
        //society_member_id
        $societyMembersResults = DB::table('society_members')
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->where('societies.id', $results->societyId)
                ->where('society_members.id','!=', $results->society_member_id)
                ->get();

        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code', 'societies.maximum_loan_amount', 'societies.intrest_rate')
            ->where('societies.id', $results->societyId)
            ->get();

        $allRefrences = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.id as societyId','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_reference_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.parent_id', $id)
                ->get();
        
        return view('loan_account.refrence', ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults,'allRefrences' => $allRefrences]);
    }
    

    // // add reference members
    public function loan_account_refrence(Request $request, $id)
    {
        
        for($i = 0; $i < $request['numOfRef']; $i++){
            if($request['society_member_id'][$i] != 0){
                
                $sqlQury = new LoanAccount();
                $sqlQury->amount = $request['amount'][$i];
                $sqlQury->society_member_id = $request['parent_society_member_id'];
                $sqlQury->society_member_reference_id = $request['society_member_id'][$i];
                $sqlQury->parent_id = $id;
                $sqlQury->status = 1;
                $sqlQury->is_delete = 0;
                $sqlQury->save();
            }
        }
        
        return redirect()->route('loan_account.index')->with('success', 'Record save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanAccount  $loanAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = LoanAccount::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('loan_account.index')->with('success', 'Record deleted successfully');
    }
}
