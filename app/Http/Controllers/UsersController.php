<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
  /**
   * Método para listar todos los usuarios
   */
  public function index(): View
  {
    // if (auth()->user()->role->id !== 3) {
    //   return view('errors.access-denied');
    // }
    $users = User::with('role')->orderBy('created_at', 'desc')->get();

    return view('dashboard.users.index', compact('users'));
  }

  /**
   * Método para crear un usuario
   */
  public function create() {}

  /**
   * Método para almacenar un usuario
   */
  public function store(CreateUserRequest $request)
  {
    // Crear el usuario
    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role_id' => $request->role_id,
    ]);

    // Redireccionar al listado de usuarios con mensaje de éxito
    return redirect()
      ->route('users.index')
      ->with('success', 'Usuario creado exitosamente');
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    //
  }
}
