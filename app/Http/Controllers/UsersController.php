<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
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
  public function store(CreateUserRequest $request): RedirectResponse
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
   * Muestra el formulario para actualizar el usuario
   */
  public function edit(int $idUser): View
  {
    // Obtener el usuario o falla
    $user = $this->findUser($idUser);
    // Obtener los roles
    $roles = Role::get();
    // Retorna una vista a la que le pasamos
    return view('dashboard.users.edit', compact('user', 'roles'));
  }

  /**
   * Método para actualizar el usuario
   */
  public function update(
    UpdateUserRequest $request,
    User $user,
  ): RedirectResponse {
    // Los datos se validad en UpdateUserRequest
    $data = [
      'name' => ucwords(strtolower($request->name)),
      'role_id' => $request->role_id,
    ];

    // Si el email es distinto es que ha cambiado
    if ($request->email !== $user->email) {
      $data['email'] = $request->email;
    }

    // Si el password tiene algo se guarda con hash en la data
    if ($request->filled('password')) {
      $data['password'] = Hash::make($request->password);
    }

    // Se actualiza el usuario
    User::where('id', $user->id)->update($data);

    // Redirigimos a la vista
    return redirect()
      ->route('users.index')
      ->with('message', 'Usuario actualizado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Eliminar el usuario correctamente
   */
  public function destroy(User $user): RedirectResponse
  {
    // Comprobar que el usuario existe
    $userFind = $this->findUser($user->id);

    // Eliminamos el usuario
    User::where('id', $userFind->id)->delete();

    // Retornamos a la vista con el mensaje
    return redirect()
      ->route('users.index')
      ->with('message', 'Usuario eliminado correctamente')
      ->with('icon', 'success');
  }

  /**
   * Método para comprobar que existe el usuario
   */
  private function findUser(int $id): User|ModelNotFoundException
  {
    return User::findOrFail($id);
  }
}
