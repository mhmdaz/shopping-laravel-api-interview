<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->user()->tokenCan('admin')) {
            return User::all();
        } else if (request()->user()->tokenCan('manager')) {
            return User::whereNot('role', 'admin')->get();
        } else {
            return User::where('role', request()->user()->role)->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (request()->user()->tokenCan('admin')) {
            return $user;
        } else if (request()->user()->tokenCan('manager')) {
            return $user->role !== 'admin' ? $user : null;
        } else {
            return $user->role === request()->user()->role ? $user : null;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (
            $user->role !== 'admin' &&
            (
                request()->user()->tokenCan('admin') ||
                request()->user()->tokenCan('manager')
            )
        ) {
            return response()->json([
                'message' => $user->delete() ? 'User deleted successfully' : null
            ]);
        }

        throw new HttpResponseException(
            response()->json([
                'message' => 'This action is unauthorized.',
            ], 401)
        );
    }
}
