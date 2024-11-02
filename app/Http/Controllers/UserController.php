<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function users()
    {
        $users = User::query()->with('dealer')->where('role','dealer')->get();

        return view('users',compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('user-create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:admin,dealer',
            // Conditional validation rules for dealer role
            'INN' => $request->role === 'dealer' ? 'required|string|max:20' : 'nullable|string|max:20',
            'director_name' => $request->role === 'dealer' ? 'required|string|max:255' : 'nullable|string|max:255',
            'dealer_name' => $request->role === 'dealer' ? 'required|string|max:255' : 'nullable|string|max:255',
            'ofice_adres' => $request->role === 'dealer' ? 'required|string|max:255' : 'nullable|string|max:255',
            'store_adres' => $request->role === 'dealer' ? 'required|string|max:255' : 'nullable|string|max:255',
            'phone_number' => $request->role === 'dealer' ? 'required|string|max:20' : 'nullable|string|max:20',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash the password
            'role' => $request->role,  // Save the selected role (admin or dealer)
        ]);

        // Check if the role is 'dealer' and create the dealer entry
        if ($request->role === 'dealer') {
            $user->dealer()->create([  // Assuming 'dealer' relationship is defined in the User model
                'INN' => $request->INN,
                'name' =>$request->dealer_name,
                'director_name' => $request->director_name,
                'ofice_adres' => $request->ofice_adres,
                'store_adres' => $request->store_adres,
                'phone_number' => $request->phone_number,
                'user_id' => $user->id, // Set the user_id to the created user's ID
            ]);
        }

        // Redirect to a route (e.g., user list) with a success message
        return redirect()->route('users')->with('success', 'User created successfully.');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'dealer') {
            $user->dealer()->delete();
        }
        $user->delete();

        return redirect()->route('users')->with('success', 'User deleted successfully!');
    }

    public function edit($id)
    {
        $user = User::query()->find($id);

        return view('user-edit',compact('user'));
    }

    public function show($id)
    {
        // Find the user by ID, including the related dealer and its counters
        $user = User::with('dealer.counters')->findOrFail($id);

        return view('user-show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);


        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,dealer',
            'INN' => 'nullable|required_if:role,dealer|string|max:255',
            'director_name' => 'nullable|required_if:role,dealer|string|max:255',
            'dealer_name' => 'nullable|required_if:role,dealer|string|max:255',
            'ofice_adres' => 'nullable|required_if:role,dealer|string|max:255',
            'store_adres' => 'nullable|required_if:role,dealer|string|max:255',
            'phone_number' => 'nullable|required_if:role,dealer|string|max:15',
        ]);

        // Add conditional password validation
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
        }

        // Update user general fields
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];



        // If a new password is provided, hash it and save
        if ($request->filled('password')) {
            $user->password = Hash::make($request['password']);
        }

        // Handle dealer-specific data when the role is 'dealer'
        if ($validatedData['role'] === 'dealer') {
            Dealer::query()->updateOrCreate(
                ['user_id' => $user->id], // Match based on user_id
                [
                    'INN' =>  $validatedData['INN'],
                    'director_name' => $validatedData['director_name'],
                    'dealer_name' => $validatedData['dealer_name'],
                    'ofice_adres' => $validatedData['ofice_adres'],
                    'store_adres' => $validatedData['store_adres'],
                    'phone_number' => $validatedData['phone_number'],
                ]
            );
            $user->role = $validatedData['role'];
        }elseif ($validatedData['role'] === 'admin') {
            $user->role = 'admin';
        }
        $user->save();


        return redirect()->route('users')->with('success', 'User updated successfully.');
    }



}
