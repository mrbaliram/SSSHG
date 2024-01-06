<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    //////////////////////////////////////////////////// new function added

    public function index()
    {
        $results = User::where('is_delete', 0)->orderBy('created_at', 'DESC')->paginate();
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code')
            ->where('societies.is_delete', 0)
            ->get();
        return view('user.index', ['results' => $results, 'societyResults' => $societyResults]);
    }

    public function add()
    {
        $results = null;
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code')
            ->where('societies.is_delete', 0)
            ->get();
        return view('user.add', ['results' => $results, 'societyResults' => $societyResults]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'password' => 'required|string|max:255',

        ]);
        $sqlQury = new User();
        $sqlQury->name = $validatedData['name'];
        $sqlQury->email = $validatedData['email'];
        $sqlQury->type = $validatedData['type'];
        $sqlQury->password = Hash::make($validatedData['password']);
        $sqlQury->phone = $request['phone'];
        $sqlQury->society_id = $request['society_id'];
        $sqlQury->status = $request['status'];
        $sqlQury->save();
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit_user($id)
    {
        $results = User::find($id);
        $societyResults = DB::table('societies')
            ->select('societies.id', 'societies.name', 'societies.code')
            ->where('societies.is_delete', 0)
            ->get();
        return view('user.edit', ['results' => $results, 'societyResults' => $societyResults]);
    }

    public function update_user(Request $request, $id)
    {
        
        $sqlQury = User::findOrFail($id);
        $validatedData = $request->validate([
            
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $sqlQury->name = $validatedData['name'];        
        $sqlQury->type = $validatedData['type'];
        //$book->status = $validatedData['status'];
        
        if($request['password'] != null){
            $validatedData = $request->validate([
                'password' => 'required|string|max:255',
            ]);
            $sqlQury->password = Hash::make($validatedData['password']);
        }
        $sqlQury->phone = $request['phone'];
        $sqlQury->society_id = $request['society_id'];
        $sqlQury->status = $request['status'];

        $sqlQury->save();
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function delete_user($id)
    {
         $sqlQury = User::findOrFail($id);
         $sqlQury->is_delete = 1;
         $sqlQury->save();
         return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    
}
