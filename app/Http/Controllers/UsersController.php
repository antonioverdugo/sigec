<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Models\Role;
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
    $users = User::with('role')->orderBy('created_at', 'desc')->paginate(8);

    return view('dashboard.users.index', compact('users'));
  }

  /**
   * Método para crear un usuario
   */
  public function create(): View
  {
    // Obtener los roles
    $roles = Role::get();
    // Enviar la vista del formulario creacion de usuario
    return view('dashboard.users.create', compact('roles'));
  }

  /**
   * Método para almacenar un usuario
   */
  public function store(CreateUserRequest $request)
  {
    // Crear el usuario
    User::create([
      'name' => ucwords(strtolower($request->name)),
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role_id' => $request->role_id,
    ]);

    // Redireccionar al listado de usuarios con mensaje de éxito
    return redirect()
      ->route('users.index')
      ->with('message', 'Usuario creado exitosamente')
      ->with('icon', 'success');
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
   * Eliminar el usuario correctamente
   */
  public function destroy(User $user)
  {
    return redirect()
      ->route('users.index')
      ->with('message', 'Usuario eliminado correctamente')
      ->with('icon', 'success');
  }
}
