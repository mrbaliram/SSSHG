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
                ->select('loan_accounts.*')
                ->where('loan_accounts.is_delete', 0)
                ->paginate();
        }else{
            $results = DB::table('loan_accounts')
                ->select('loan_accounts.*')
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
        return view('loan_account.add', ['results' => $results]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoanAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedFormData = $request->validate([
            'amount' => 'required|string|max:255',
            'intrest_rate' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);
       
        $sqlQury = new LoanAccount(); 
        $sqlQury->amount = $validatedFormData['amount'];
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
        $results = LoanAccount::find($id);
        return view('loan_account.edit', ['results' => $results]);
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
            'amount' => 'required|string|max:255',
            'intrest_rate' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);
        
        $sqlQury->amount = $validatedFormData['amount'];
        $sqlQury->intrest_rate = $validatedFormData['intrest_rate'];
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
