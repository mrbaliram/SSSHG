<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\societies;
use App\Models\Society_rule;

use App\Http\Requests\StoreSociety_ruleRequest;
use App\Http\Requests\UpdateSociety_ruleRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class SocietyRuleController extends Controller
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
            $results = DB::table('society_rules')
                ->select('society_rules.*', 'societies.name as societyName')
                ->join('societies','societies.id','=','society_rules.society_id')
                ->where('society_rules.is_delete', 0)
                ->orderBy('society_rules.created_at', 'DESC')
                ->paginate(10);
        }
        return view('society_rule.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $results = null;
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code')
            ->where('societies.is_delete', 0)
            ->get();

        return view('society_rule.add_edit', ['results' => $results, 'societyResults' => $societyResults]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSociety_ruleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedFormData = $request->validate([
            'society_id' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sort_desc' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);

        $sqlQury = new Society_rule(); 
        $sqlQury->society_id = $validatedFormData['society_id'];
        $sqlQury->title = $validatedFormData['title'];
        $sqlQury->sort_desc = $validatedFormData['sort_desc'];
        $sqlQury->status = $validatedFormData['status'];

        $sqlQury->long_desc = $request['long_desc'];        
        $sqlQury->is_delete = 0;
        
        $sqlQury->save();
        return redirect()->route('society_rule.index')->with('success', 'Record created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Society_rule  $society_rule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = DB::table('society_rules')
                ->select('society_rules.*', 'societies.name as societyName')
                ->join('societies','societies.id','=','society_rules.society_id')
                ->where('society_rules.id', $id)
                ->get()->first();

        return view('society_rule.show', ['results' => $results]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Society_rule  $society_rule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code')
            ->where('societies.is_delete', 0)
            ->get();

        $results = Society_rule::find($id);
        
        return view('society_rule.add_edit', ['results' => $results, 'societyResults' => $societyResults]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSociety_ruleRequest  $request
     * @param  \App\Models\Society_rule  $society_rule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sqlQury = Society_rule::findOrFail($id);
        
        $validatedFormData = $request->validate([
            'society_id' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'sort_desc' => 'required|string|max:255',
            'status' => 'required|in:1,0',
        ]);

        $sqlQury->society_id = $validatedFormData['society_id'];
        $sqlQury->title = $validatedFormData['title'];
        $sqlQury->sort_desc = $validatedFormData['sort_desc'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->long_desc = $request['long_desc'];        
        $sqlQury->is_delete = 0;

        $sqlQury->save();

        return redirect()->route('society_rule.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Society_rule  $society_rule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = Society_rule::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('society_rule.index')->with('success', 'Record deleted successfully');
    }
}
