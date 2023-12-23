<?php

namespace App\Http\Controllers;

use App\Models\Member_type;
use App\Http\Requests\StoreMember_typeRequest;
use App\Http\Requests\UpdateMember_typeRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class MemberTypeController extends Controller
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
            $results = DB::table('member_types')
                ->select('member_types.*')
                ->where(function($query) use ($searchVal) {
                    $query->where('member_types.name', 'like', '%' . $searchVal . '%')
                    ->orWhere('member_types.code', 'like', '%' . $searchVal . '%');
                })
                ->where('is_delete', 0)
                ->paginate();
        }else{
            $results = DB::table('member_types')
                ->select('member_types.*')  
                ->where('is_delete', 0)           
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }
        return view('member_type.index', compact('results'));
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
        return view('member_type.add_edit', ['results' => $results]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMember_typeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);
        $sqlQury = new Member_type();
        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->code = $validatedFormData['code'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->is_delete = 0;
        
        $sqlQury->save();
        return redirect()->route('member_type.index')->with('success', 'Record created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member_type  $member_type
     * @return \Illuminate\Http\Response
     */
    public function show(Member_type $member_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member_type  $member_type
     * @return \Illuminate\Http\Response
     */
    

    public function edit($id)
    {
        //
        $results = Member_type::find($id);
        return view('member_type.add_edit', ['results' => $results]);
        //return view('language.create', ['results' => $results]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMember_typeRequest  $request
     * @param  \App\Models\Member_type  $member_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sqlQury = Member_type::findOrFail($id);
        
        $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);

        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->code = $validatedFormData['code'];
        $sqlQury->status = $validatedFormData['status'];

        $sqlQury->save();

        return redirect()->route('member_type.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member_type  $member_type
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $sqlQury = Member_type::findOrFail($id);
    //     $sqlQury->is_delete = 1;
    //     $sqlQury->save();
    //     return redirect()->route('member_type.index')->with('success', 'Record deleted successfully');
    // }

    public function destroy($id)
    {
        $sqlQury = Member_type::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('member_type.index')->with('success', 'Record deleted successfully');
    }
}
