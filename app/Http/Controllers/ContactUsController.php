<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreContactUsRequest;
use App\Http\Requests\UpdateContactUsRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // societyName societies
        //dd(Auth::user()->id);
        if($request['search'] != null){
            $searchVal = $request['search'];
            $results = DB::table('society_rules')
                ->select('society_rules.*', 'societies.name as societyName')
                ->join('societies','societies.id','=','society_rules.society_id')
                ->where(function($query) use ($searchVal) {
                    $query->where('society_rules.title', 'like', '%' . $searchVal . '%')
                    ->orWhere('societies.name', 'like', '%' . $searchVal . '%')
                    ->orWhere('society_rules.sort_desc', 'like', '%' . $searchVal . '%');
                })
                ->where('society_rules.is_delete', 0)
                ->paginate();
        }else{
            $results = DB::table('contact_us')
                ->select('contact_us.*', 'societies.code as societyCode','members.name as memberName')

                ->join('society_members','society_members.id','=','contact_us.society_member_id')
                ->join('societies','societies.id','=','society_members.society_id')
                ->join('members','members.id','=','society_members.member_id')

                ->where('contact_us.is_delete', 0)
                ->orderBy('contact_us.created_at', 'DESC')
                ->paginate(10);
        }
        return view('contact_us.index', compact('results'));
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
        $memberResults = DB::table('members')
            ->select('members.id', 'members.name','members.guardian','society_members.member_id', 'society_members.society_id','societies.code as societyCode')
            ->leftJoin('society_members','society_members.member_id','=','members.id')
            ->leftJoin('societies','society_members.society_id','=','societies.id')
            ->where('members.is_delete', 0)
            ->get();
        return view('contact_us.add', ['results' => $results, 'memberResults' => $memberResults]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactUsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            //'mobile' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);

        $sqlQury = new ContactUs();
        
        $sqlQury->user_id = Auth::user()->id;
        
        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->message = $validatedFormData['message'];
        $sqlQury->status = $validatedFormData['status'];

        $sqlQury->mobile = $request['mobile'];
        $sqlQury->society_member_id = $request['member_id'];;
        // $sqlQury->other_info1 = $request['other_info1'];
        $sqlQury->remarks = $request['remarks'];


        $sqlQury->save();

        return redirect()->route('contact_us.index')->with('success', 'Record created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $results = DB::table('contact_us')
                ->select('contact_us.*')                
               ->where('contact_us.id', $id)
                ->get()->first();

         // $results = DB::table('society_rules')
         //        ->select('society_rules.*', 'societies.name as societyName')
         //        ->join('societies','societies.id','=','society_rules.society_id')
         //        ->where('society_rules.id', $id)
         //        ->get()->first();

        return view('contact_us.show', ['results' => $results]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $results = ContactUs::find($id);
        $memberResults = DB::table('members')
            ->select('members.id', 'members.name','members.guardian','society_members.member_id', 'society_members.society_id','societies.code as societyCode')
            ->leftJoin('society_members','society_members.member_id','=','members.id')
            ->leftJoin('societies','society_members.society_id','=','societies.id')
            ->where('members.is_delete', 0)
            ->get();
        return view('contact_us.edit', ['results' => $results, 'memberResults' => $memberResults]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactUsRequest  $request
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sqlQury = ContactUs::findOrFail($id);
        
       $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);
        $sqlQury->society_member_id = 1;
        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->message = $validatedFormData['message'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->mobile = $request['mobile'];
        $sqlQury->society_member_id = $request['member_id'];
        $sqlQury->remarks = $request['remarks'];
        $sqlQury->save();
        return redirect()->route('contact_us.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = ContactUs::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('contact_us.index')->with('success', 'Record deleted successfully');
    }
}
