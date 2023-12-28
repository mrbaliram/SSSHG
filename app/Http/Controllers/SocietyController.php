<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Http\Requests\StoreSocietyRequest;
use App\Http\Requests\UpdateSocietyRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class SocietyController extends Controller
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
            $results = DB::table('societies')
                ->select('societies.*')
                ->where(function($query) use ($searchVal) {
                    $query->where('societies.name', 'like', '%' . $searchVal . '%')
                    ->orWhere('societies.code', 'like', '%' . $searchVal . '%');
                })
                ->where('is_delete', 0)
                ->paginate();
        }else{
            $results = DB::table('societies')
                ->select('societies.*')  
                ->where('is_delete', 0)           
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
        }
        return view('society.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('society.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSocietyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sqlQury = new Society();

        $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'contribution_amount' => 'required|string|max:255',
            'maximum_loan_amount' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
        ]);
         
         
        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->code = $validatedFormData['code'];
        $sqlQury->contribution_amount = $validatedFormData['contribution_amount'];
        $sqlQury->maximum_loan_amount = $validatedFormData['maximum_loan_amount'];
        $sqlQury->city = $validatedFormData['city'];
        $sqlQury->state = $validatedFormData['state'];
        $sqlQury->address1 = $validatedFormData['address1'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->start_date = $validatedFormData['start_date'];
        // optional field value contact_no contact_person
        $sqlQury->address2 = $request['address2'];
        $sqlQury->pin_code = $request['pin_code'];
        $sqlQury->contact_no = $request['contact_no'];
        $sqlQury->contact_person = $request['contact_person'];
        $sqlQury->remarks = $request['remarks'];
        $sqlQury->intrest_rate = $request['intrest_rate'];
        $sqlQury->branch_code = $request['branch_code'];

        $sqlQury->is_delete = 0;

        $sqlQury->save();
        
        return redirect()->route('society.index')->with('success', 'Record created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Society  $society
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
       $results = DB::table('societies')
            ->select('societies.*')
            ->where('id', $id)
        ->get()->first();
        return view('society.show', ['results' => $results]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Society  $society
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $results = Society::find($id);
        return view('society.edit', ['results' => $results]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSocietyRequest  $request
     * @param  \App\Models\Society  $society
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sqlQury = Society::findOrFail($id);
        $validatedFormData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'contribution_amount' => 'required|string|max:255',
            'maximum_loan_amount' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'start_date' => 'required|string|max:255',
        ]);
         
        $sqlQury->name = $validatedFormData['name'];
        $sqlQury->code = $validatedFormData['code'];
        $sqlQury->contribution_amount = $validatedFormData['contribution_amount'];
        $sqlQury->maximum_loan_amount = $validatedFormData['maximum_loan_amount'];
        $sqlQury->city = $validatedFormData['city'];
        $sqlQury->state = $validatedFormData['state'];
        $sqlQury->address1 = $validatedFormData['address1'];
        $sqlQury->status = $validatedFormData['status'];
        $sqlQury->start_date = $validatedFormData['start_date'];
        // optional field value contact_no contact_person
        $sqlQury->address2 = $request['address2'];
        $sqlQury->pin_code = $request['pin_code'];
        $sqlQury->contact_no = $request['contact_no'];
        $sqlQury->contact_person = $request['contact_person'];
        $sqlQury->remarks = $request['remarks'];
        $sqlQury->intrest_rate = $request['intrest_rate'];
        $sqlQury->branch_code = $request['branch_code'];

        $sqlQury->save();
        return redirect()->route('society.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Society  $society
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sqlQury = Society::findOrFail($id);
        $sqlQury->is_delete = 1;
        $sqlQury->save();
        return redirect()->route('society.index')->with('success', 'Record deleted successfully');
    }
}
