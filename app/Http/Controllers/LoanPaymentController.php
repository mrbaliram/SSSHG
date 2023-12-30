<?php

namespace App\Http\Controllers;

use App\Models\LoanPayment;
use App\Http\Requests\StoreLoanPaymentRequest;
use App\Http\Requests\UpdateLoanPaymentRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class LoanPaymentController extends Controller
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
            
            $results = DB::table('loan_payments')
                ->select('loan_payments.*', 'societies.name as societyName','members.name as memberName')
                
                ->join('loan_accounts','loan_accounts.id','=','loan_payments.loan_account_id')

                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where(function($query) use ($searchVal) {
                    $query->where('societies.name', 'like', '%' . $searchVal . '%')
                    ->orWhere('members.name', 'like', '%' . $searchVal . '%');
                })
                ->where('loan_payments.is_delete', 0)
                ->orderBy('loan_payments.created_at', 'Desc')
                ->paginate();          

        }else{

            $results = DB::table('loan_payments')
                ->select('loan_payments.*', 'societies.name as societyName','members.name as memberName')
                
                ->join('loan_accounts','loan_accounts.id','=','loan_payments.loan_account_id')

                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')

                ->where('loan_payments.is_delete', 0)
                ->orderBy('loan_payments.created_at', 'Desc')
                ->paginate();
        }
        

        return view('loan_payment.index', compact('results'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $results = null;

        $loanAccountResult = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.code as societyCode','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.is_delete', 0)
                ->where('loan_accounts.parent_id', 0)
                ->orderBy('loan_accounts.created_at', 'DESC')
                ->get();
       
        return view('loan_payment.add', ['loanAccountResult' => $loanAccountResult]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLoanPaymentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedFormData = $request->validate([
            'loan_account_id' => 'required|string|max:255',
            'paid_amount' => 'required|string|max:255',
            'intrest_amount' => 'required|string|max:255',
            'pay_date' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);
               
        $sqlQury = new LoanPayment(); 
        $sqlQury->loan_account_id = $validatedFormData['loan_account_id'];
        $sqlQury->paid_amount = $validatedFormData['paid_amount'];
        $sqlQury->intrest_amount = $validatedFormData['intrest_amount'];
        $sqlQury->pay_date = $validatedFormData['pay_date'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->save();

        return redirect()->route('loan_payment.index')->with('success', 'Record save successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function show(LoanPayment $loanPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $results = LoanPayment::find($id);
        
        $loanAccountResult = DB::table('loan_accounts')
                ->select('loan_accounts.*', 'societies.code as societyCode','members.name as memberName')
                ->join('society_members','society_members.id','=','loan_accounts.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('loan_accounts.is_delete', 0)
                ->where('loan_accounts.parent_id', 0)
                ->orderBy('loan_accounts.created_at', 'DESC')
                ->get();

        return view('loan_payment.edit', ['results' => $results, 'loanAccountResult' => $loanAccountResult]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoanPaymentRequest  $request
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validatedFormData = $request->validate([
            'loan_account_id' => 'required|string|max:255',
            'paid_amount' => 'required|string|max:255',
            'intrest_amount' => 'required|string|max:255',
            'pay_date' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);
       
        $sqlQury = LoanPayment::findOrFail($id);  
        $sqlQury->loan_account_id = $validatedFormData['loan_account_id'];
        $sqlQury->paid_amount = $validatedFormData['paid_amount'];
        $sqlQury->intrest_amount = $validatedFormData['intrest_amount'];
        $sqlQury->pay_date = $validatedFormData['pay_date'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->save();

        return redirect()->route('loan_payment.index')->with('success', 'Record save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanPayment  $loanPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = LoanPayment::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('loan_payment.index')->with('success', 'Record deleted successfully');
    }
}
