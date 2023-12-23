<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // societyName societies
        if($request['search'] != null){
            $searchVal = $request['search'];
            $results = DB::table('members')
                ->select('members.*')
                ->where(function($query) use ($searchVal) {
                    $query->where('members.city', 'like', '%' . $searchVal . '%')
                    ->orWhere('members.name', 'like', '%' . $searchVal . '%')
                    ->orWhere('members.state', 'like', '%' . $searchVal . '%');
                })
                ->where('members.is_delete', 0)
                ->paginate();
        }else{
            $results = DB::table('members')
                ->select('members.*')
                ->where('members.is_delete', 0)
                ->orderBy('members.created_at', 'DESC')
                ->paginate(10);
        }
        return view('member.index', compact('results'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $results = null;
        $memberResults = DB::table('members')
            ->select('members.*')
            ->where('members.is_delete', 0)
            ->get();
        $userResults = User::all();

        

           
            // 'adhar_card_url',
            // 'photo_url',
            
        return view('member.create', ['userResults' => $userResults, 'memberResults' => $memberResults]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sqlQury = new Member();

        $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);
         
        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->user_id = $validatedFormData['user_id'];
        $sqlQury->city = $validatedFormData['city'];
        $sqlQury->state = $validatedFormData['state'];
        $sqlQury->address1 = $validatedFormData['address1'];
        $sqlQury->status = $validatedFormData['status'];
        // optional field value contact_no contact_person
        $sqlQury->parent_id = $request['parent_id'];
        $sqlQury->reference_id = $request['reference_id'];
        $sqlQury->sub_reference_id = $request['sub_reference_id'];
        $sqlQury->phone = $request['phone'];
        $sqlQury->pin_code = $request['pin_code'];
        $sqlQury->remarks = $request['remarks'];

        $sqlQury->guardian = $request['guardian'];
        $sqlQury->gender = $request['gender'];
        $sqlQury->email = $request['email'];

        // check adhar card and save it adhar_card_url 
        if($request['adhar_card_url'] != null){
            $validatedData = $request->validate([
                'adhar_card_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fileName = time() . '.' . $request->adhar_card_url->extension();
            $request->adhar_card_url->storeAs('public/images', $fileName);
            $sqlQury->adhar_card_url = $fileName;

        }
        // check member profile photo and save it photo_url
        if($request['photo_url'] != null){
            $validatedData = $request->validate([
                'photo_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fileName = time() . '.' . $request->photo_url->extension();
            $request->photo_url->storeAs('public/images', $fileName);
            $sqlQury->photo_url = $fileName;

        }

        $sqlQury->save();

        return redirect()->route('member.index')->with('success', 'Record created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = DB::table('members')
                ->select('members.*')
                ->where('members.id', $id)
                ->get()->first();

        return view('member.show', ['results' => $results]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $memberResults = DB::table('members')
            ->select('members.*')
            ->where('members.is_delete', 0)
            ->where('members.id','!=', $id)
            ->get();

        $userResults = User::all();
        $results = Member::find($id);
        
        return view('member.edit', ['results' => $results, 'userResults' => $userResults, 'memberResults' => $memberResults]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$sqlQury = new Member();
        $sqlQury = Member::findOrFail($id);
        $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);
         
        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->user_id = $validatedFormData['user_id'];
        $sqlQury->city = $validatedFormData['city'];
        $sqlQury->state = $validatedFormData['state'];
        $sqlQury->address1 = $validatedFormData['address1'];
        $sqlQury->status = $validatedFormData['status'];
        // optional fields
        $sqlQury->address2 = $request['address2'];
        $sqlQury->parent_id = $request['parent_id'];
        $sqlQury->reference_id = $request['reference_id'];
        $sqlQury->sub_reference_id = $request['sub_reference_id'];
        $sqlQury->phone = $request['phone'];
        $sqlQury->pin_code = $request['pin_code'];
        $sqlQury->remarks = $request['remarks'];

        $sqlQury->guardian = $request['guardian'];
        $sqlQury->gender = $request['gender'];
        $sqlQury->email = $request['email'];

        // check adhar card and save it adhar_card_url 
        if($request['adhar_card_url'] != null){
            $validatedData = $request->validate([
                'adhar_card_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fileName = time() . '.' . $request->adhar_card_url->extension();
            $request->adhar_card_url->storeAs('public/images', $fileName);
            $sqlQury->adhar_card_url = $fileName;

        }
        // check member profile photo and save it photo_url
        if($request['photo_url'] != null){
            $validatedData = $request->validate([
                'photo_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fileName = time() . '.' . $request->photo_url->extension();
            $request->photo_url->storeAs('public/images', $fileName);
            $sqlQury->photo_url = $fileName;

        }

        $sqlQury->save();

        return redirect()->route('member.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = Member::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('member.index')->with('success', 'Record deleted successfully');
    
    }
}
