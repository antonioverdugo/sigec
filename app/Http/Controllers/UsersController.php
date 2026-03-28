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
   * Lista todos los usuarios de forma paginada.
   *
   * Recupera los usuarios con su rol relacionado,
   * ordenados por fecha de creación descendente.
   *
   * @return View Vista con la lista de usuarios
   */
  public function index(): View
  {
    $users = User::with('role')->orderBy('created_at', 'desc')->paginate(8);

    return view('dashboard.users.index', compact('users'));
  }

  /**
   * Muestra un usuario específico.
   *
   * Redirige al listado ya que la vista de detalle
   * no está implementada actualmente.
   *
   * @param int $id ID del usuario a mostrar
   * @return RedirectResponse Redirige a la lista de usuarios
   */

  public function show(int $id): RedirectResponse
  {
    return redirect()->route('users.index');
  }

  /**
   * Muestra el formulario para crear un nuevo usuario.
   *
   * Recupera todos los roles disponibles para el selector
   * del formulario de creación.
   *
   * @return View Vista con el formulario de creación
   * @see Role
   */
  public function create(): View
  {
    // Obtener los roles
    $roles = Role::get();
    // Enviar la vista del formulario creacion de usuario
    return view('dashboard.users.create', compact('roles'));
  }

  /**
   * Almacena un nuevo usuario en el sistema.
   *
   * Valida los datos mediante CreateUserRequest.
   * El nombre se formatea automáticamente a formato título.
   * La contraseña se almacena hasheada.
   *
   * @param CreateUserRequest $request Datos validados del formulario
   * @return RedirectResponse Redirige a la lista con mensaje de éxito
   * @throws \Exception Si ocurre un error al crear el usuario
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
   * Muestra el formulario para editar un usuario existente.
   *
   * Recupera el usuario por su ID y los roles disponibles
   * para el formulario de edición.
   *
   * @param int $idUser ID del usuario a editar
   * @return View Vista con el formulario de edición
   * @throws ModelNotFoundException Si el usuario no existe
   * @see User
   * @see Role
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
   * Actualiza los datos de un usuario existente.
   *
   * Valida los datos mediante UpdateUserRequest.
   * Permite actualizar email y contraseña de forma opcional.
   * Si se proporciona contraseña, se almacena hasheada.
   *
   * @param UpdateUserRequest $request Datos validados del formulario
   * @param User $user Instancia del usuario a actualizar
   * @return RedirectResponse Redirige a la lista con mensaje de éxito
   * @throws ModelNotFoundException Si el usuario no existe
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
   * Elimina un usuario del sistema.
   *
   * Realiza una eliminación lógica del usuario.
   *
   * @param User $user Instancia del usuario a eliminar
   * @return RedirectResponse Redirige a la lista con mensaje de éxito
   * @throws ModelNotFoundException Si el usuario no existe
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
   * Busca un usuario por su ID.
   *
   * Método auxiliar que utiliza findOrFail para
   * devolver el usuario o lanzar excepción si no existe.
   *
   * @param int $id ID del usuario a buscar
   * @return User El usuario encontrado
   * @throws ModelNotFoundException Si el usuario no existe
   */
  private function findUser(int $id): User|ModelNotFoundException
  {
    return User::findOrFail($id);
  }
}
