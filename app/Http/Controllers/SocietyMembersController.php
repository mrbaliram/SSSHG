<?php

namespace App\Http\Controllers;

use App\Models\SocietyMembers;
use App\Http\Requests\StoreSocietyMembersRequest;
use App\Http\Requests\UpdateSocietyMembersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class SocietyMembersController extends Controller
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
            $results = DB::table('society_members')
                ->select('society_members.*', 'societies.code as societyCode','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where(function($query) use ($searchVal) {
                    $query->where('societies.name', 'like', '%' . $searchVal . '%')
                    ->orWhere('members.name', 'like', '%' . $searchVal . '%');
                })
                ->where('society_members.is_delete', 0)
                ->paginate();
        }else{
            $results = DB::table('society_members')
                ->select('society_members.*', 'societies.code as societyCode','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
                ->orderBy('society_members.id', 'DESC')
                ->paginate();
        }
        
        //dd($results);

        return view('society_member.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // for testing

        // $memberResults2 = DB::table('members')
        //     ->select('members.*', 'society_members.society_id as society_id33')
        //     ->leftJoin('society_members','society_members.member_id','=','members.id')
        //     //->wherenotNull('society_members.member_id')
        //     ->where('members.is_delete', 0)
        //     ->get();

        // dd($memberResults2);

        // ->leftJoin('enrollments','enrollments.student_id','=','students.id')
        // ->whereNull('enrollments.student_id')

        // end
        $results = null;
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code', 'societies.branch_code')
            ->where('societies.is_delete', 0)
            ->get();

        $memberResults = DB::table('members')
            ->select('members.id', 'members.name','members.guardian','society_members.member_id', 'society_members.society_id','societies.code as societyCode')
            ->leftJoin('society_members','society_members.member_id','=','members.id')
            ->leftJoin('societies','society_members.society_id','=','societies.id')
            ->where('members.is_delete', 0)
            ->get();

        $memberTypeResults = DB::table('member_types')
            ->select('member_types.*')
            ->where('member_types.is_delete', 0)
            ->get();

        return view('society_member.add', ['results' => $results, 'societyResults' => $societyResults, 'memberResults' => $memberResults,'memberTypeResults' => $memberTypeResults]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSocietyMembersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $validatedFormData = $request->validate([
            'society_id' => 'required|string|max:255',
            'member_id' => 'required|string|max:255',
            'account_nummber' => 'required|string|max:255',
            'member_type_id' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);

        //generate account_nummber
        $memberCountBySociety = SocietyMembers::where('society_id', $validatedFormData['society_id'])->count() + 1;
        $year = now()->format("y") - 1 ;
        //dd($year);
        if($memberCountBySociety < 10){
            $newAccountNumber = $validatedFormData['account_nummber'].'-'.$year.'0'.$memberCountBySociety;
        }else{
            $newAccountNumber = $validatedFormData['account_nummber'].'-'.$year.$memberCountBySociety;
        }
        
        $isSocietyMembers = SocietyMembers::where('society_id', $validatedFormData['society_id'])
                                ->where('member_id', $validatedFormData['member_id'])
                                ->first();

        if (is_null($isSocietyMembers)) {
            $sqlQury = new SocietyMembers();             
            $sqlQury->society_id = $validatedFormData['society_id'];
            $sqlQury->member_id = $validatedFormData['member_id'];
            $sqlQury->member_type_id = $validatedFormData['member_type_id'];
            $sqlQury->start_date = $validatedFormData['start_date'];
            $sqlQury->end_date = $validatedFormData['end_date'];
            $sqlQury->account_nummber = $newAccountNumber;
            $sqlQury->status = $validatedFormData['status'];
            $sqlQury->is_delete = 0;
            $sqlQury->remarks = $request['remarks'];
            
            $sqlQury->save();

            return redirect()->route('society_member.index')->with('success', 'Record save successfully');

        }else{

            return redirect()->route('society_member.create')->with('error', 'Record already exists');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SocietyMembers  $societyMembers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $SMResults = DB::table('society_members')
                ->select('society_members.*', 'societies.code as societyCode' , 'societies.name as societyName','members.name as memberName',
                    DB::raw('(SELECT sum(amount) FROM contribution_payments WHERE contribution_payments.society_member_id = society_members.id) as totalContributionAmount'),
                )
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.id', $id)
                ->get();
        $contriButionHistoryResults = DB::table('contribution_payments')
                ->select('contribution_payments.*', 'societies.name as societyName','members.name as memberName')
                ->join('society_members','society_members.id','=','contribution_payments.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('contribution_payments.society_member_id', $id)
                ->orderBy('contribution_payments.created_at', 'DESC')
                ->limit(10)
                ->get();


        // call the function show the loan details
        $memberLoanAccount = DB::table('loan_accounts')
        ->select('loan_accounts.id')        
        ->where('loan_accounts.society_member_id', $id)
        ->where('loan_accounts.parent_id', 0)
        ->get();
        if(count($memberLoanAccount)){
            $result_arr = $this->refrence($memberLoanAccount[0]->id);
        }else{
            $result_arr = [];
        }        
        return view('society_member.show', [
            'SMResults' => $SMResults[0], 
            'contriButionHistoryResults' => $contriButionHistoryResults,
            'result_arr' => $result_arr
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SocietyMembers  $societyMembers
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $results = SocietyMembers::find($id);
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code')
            ->where('societies.is_delete', 0)
            ->get();

        
        $memberResults = DB::table('members')
            ->select('members.*')
            ->where('members.is_delete', 0)
            ->get();

        $memberTypeResults = DB::table('member_types')
            ->select('member_types.*')
            ->where('member_types.is_delete', 0)
            ->get();
            
        return view('society_member.edit', ['results' => $results, 'societyResults' => $societyResults, 'memberResults' => $memberResults,'memberTypeResults' => $memberTypeResults]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSocietyMembersRequest  $request
     * @param  \App\Models\SocietyMembers  $societyMembers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sqlQury = SocietyMembers::findOrFail($id);

        $validatedFormData = $request->validate([
            'society_id' => 'required|string|max:255',
            'member_id' => 'required|string|max:255',
            'member_type_id' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'end_date' => 'required|string|max:255',            
            'status' => 'required|in:1,0',
        ]);

        $isSocietyMembers = SocietyMembers::where('society_id', $validatedFormData['society_id'])
                                ->where('member_id', $validatedFormData['member_id'])
                                ->where('id', '!=', $id)
                                ->first();
        //dd($isSocietyMembers);
        if (is_null($isSocietyMembers)) {
            //$sqlQury->society_id = $validatedFormData['society_id'];
            $sqlQury->member_id = $validatedFormData['member_id'];
            $sqlQury->member_type_id = $validatedFormData['member_type_id'];
            $sqlQury->start_date = $validatedFormData['start_date'];
            $sqlQury->end_date = $validatedFormData['end_date'];
            $sqlQury->status = $validatedFormData['status'];
            $sqlQury->account_nummber = $request['account_nummber'];
            $sqlQury->is_delete = 0;
            $sqlQury->remarks = $request['remarks'];
            $sqlQury->save();

            return redirect()->route('society_member.index')->with('success', 'Record save successfully');

        }else{

            return redirect()->route('society_member.edit',[$id])->with('error', 'Record already exists');

        }

        //return redirect()->route('society_member.index')->with('success', 'Record save successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SocietyMembers  $societyMembers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = SocietyMembers::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('society_member.index')->with('success', 'Record deleted successfully');
    }

    public function refrence($id)
    {
        
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
        
        // return view('loan_account.payment_history', ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults,'allRefrences' => $allRefrences, 'loan_paymentsResults' => $loan_paymentsResults]);

         return  ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults,'allRefrences' => $allRefrences, 'loan_paymentsResults' => $loan_paymentsResults];

        // return view('loan_account.refrence', ['results' => $results,'societyResults' => $societyResults, 'societyMembersResults' => $societyMembersResults,'allRefrences' => $allRefrences, 'memberAlreadyTakenLoan_arr' => $memberAlreadyTakenLoan_arr]);
    }
}
