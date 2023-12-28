<?php

namespace App\Http\Controllers;

use App\Models\LoanAccount;
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
                ->select('loan_accounts.*', 'societies.name as societyName','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
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
        
        //dd($results);

        return view('loan_account.index', compact('results'));
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
    public function show(LoanAccount $loanAccount)
    {
        //
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

        return view('loan_account.refrence', ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults]);
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
