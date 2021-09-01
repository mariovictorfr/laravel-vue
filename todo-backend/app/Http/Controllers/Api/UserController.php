<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendMailDeleteUser;
use App\Mail\SendMailNewUser;
use App\Mail\SendMailUpdateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($search = $request->search) {
            return User::where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->get();
        }
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $validationRules = [
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'name' => ['required'],
        ];
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Mail::to($user->email)->send(new SendMailNewUser($user));

        return response()->json($user);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 400);
        }
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 400);
        }

        $validationRules = [
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($id),],
            'password' => ['sometimes', 'required', 'min:6', 'confirmed'],
            'name' => ['sometimes', 'required'],
        ];
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Mail::to($user->email)->send(new SendMailUpdateUser($user));

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $affectedRows = User::destroy($id);
        if (!$affectedRows) {
            return response()->json(['error' => 'Usuário não encontrado.'], 400);
        }

        Mail::to($user->email)->send(new SendMailDeleteUser($user));

        return response()->json('Usuário deletado.', 200);
    }
}
