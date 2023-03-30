<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function redirectuser(){
        $usertype =Auth::user()->usertype;

        if($usertype == '1'){
            return view('admin.admin');
        }
        else{
            return view('home');
        }

    }

    public function fetchusers()
    {
        $user = User::all();

        return response()->json([
            'users' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'email' => 'required|email|max:200',
            'account_no' => 'required|max:200',
            'amount' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->messages(),
            ]);
        } else {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->account_no = $request->input('account_no');
            $user->amount = $request->input('amount');
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => 'User was added successfully'
            ]);
        }
    }

    //a function to edit user
    public function edit($id)
    {
        $std = User::find($id);

        if ($std) {
            return response()->json([
                'status' => 200,
                'message' => 'user was found',
                'user' => $std
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'user not found'
            ]);
        }
    }

    //function to update user details to the database
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'email' => 'required|email|max:200',
            'account_no' => 'required|max:200',
            'amount' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->messages(),
            ]);
        } else {
            $user = User::find($id);

            if ($user) {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->account_no = $request->input('account_no');
                $user->amount = $request->input('amount');
                $user->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'User was updated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'user not found'
                ]);
            }
        }
    }

    //a function to delete a user data from the database
    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'user deleted successfully'
        ]);
    }
}
