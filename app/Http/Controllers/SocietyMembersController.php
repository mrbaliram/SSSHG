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
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
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
                ->select('society_members.*', 'societies.name as societyName','members.name as memberName')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')
                ->where('society_members.is_delete', 0)
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
        $results = null;
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code', 'societies.branch_code')
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
        $newAccountNumber = $validatedFormData['account_nummber'].'-0'.$memberCountBySociety;
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
    public function show(SocietyMembers $societyMembers)
    {
        //
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
}
