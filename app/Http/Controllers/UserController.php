<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('department')->get();
        return view('users.index', compact('user'));
    }

    public function history()
    {
        $history = AttendanceRecord::get();
        return view('users.history', compact('history'));
    }

    public function create()
    {
        return view('register.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for images
            'staff_id' => 'required|unique:users,staff_id', // Check uniqueness in the 'users' table
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // Example validation for email
            'password' => 'required|min:8',
            'genders_id' => 'required',
            'address' => 'required',
            'phonenumber' => 'required',
            'departments_id' => 'required',
        ], [
            'staff_id.unique' => 'The staff ID is already in use.',
            'email.unique' => 'The email address is already in use.',
            // Add custom messages for other rules as needed
        ]);

        $data = new User;

        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $name = $file->getClientOriginalExtension();
            $file->storeAs('public/profilephoto_images', $name);
            $images = $name;
        } else {
            $images = $request->images;
        }
        
        $data->images = $images;
        $data->staff_id  = $request->staff_id;
        $data->name      = $request->name;
        $data->email     = $request->email;
        $data->password = bcrypt($request->get('password'));
        $data->genders_id    = $request->gender;
        $data->address   = $request->address;
        $data->phonenumber = $request->phonenumber;
        $data->departments_id  = $request->department;
        dd('STORE NEW USER', $data);
        
        $data->save();
        

        return redirect('/');
    }

    public function show($id)
    {
        $info = User::findOrFail($id);
        return view('users.user-profile', compact('info'));
    }

    public function edit($id)
    {
        $info = User::findOrFail($id);
        return view('users.edit', compact('info'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User has been deleted successfully');
    }

    public function update(Request $request, $id)
    {
        $data = User::findOrFail($id);

        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $name = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() . '/profilephoto_images', $name);
            $images = $name;
        } else {
            $images = $request->images;
        }

        $data->images = $images;
        $data->staff_id  = $request->staff_id;
        $data->name      = $request->name;
        $data->email     = $request->email;
        $data->password = bcrypt($request->get('password'));
        $data->gender    = $request->gender;
        $data->address   = $request->address;
        $data->phonenumber = $request->phonenumber;
        $data->department  = $request->department;

        $data->save();

        return redirect('/');
    }
}
