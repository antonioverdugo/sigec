<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
  /**
   * Listar todas las categorías
   */
  public function index(): View
  {
    // Obtener todas las categorías
    $categories = Category::paginate(8);
    return view('dashboard.categories.index', compact('categories'));
  }

  /**
   * Mostrar el formulario para crear una nueva categoría
   */
  public function create(): View
  {
    // Retornamos la vista del formulario para crear una nueva categoria
    return view('dashboard.categories.create');
  }

  /**
   * Guardar una nueva categoría
   */
  public function store(CreateCategoryRequest $request): RedirectResponse
  {
    //Crear la categoria
    Category::create([
      'name' => ucwords(strtolower(trim($request->name))),
      'description' => trim($request->description),
    ]);

    // Redirigir a la lista de categorias con mensaje de éxito
    return redirect()
      ->route('categories.index')
      ->with('message', 'Categoria creada correctamente')
      ->with('icon', 'success');
  }

  /**
   * Mostrar una categoría específica
   */
  public function show(Category $category): RedirectResponse
  {
    // Como no es necesaria este metodo voy a redirigira a la lista de categorias
    return redirect()->route('categories.index');
  }

  /**
   * Mostrar el formulario para editar una categoría
   */
  public function edit(Category $category): View
  {
    // Comprobamos que la categoria existe
    $category = $this->findCategory($category->id);
    // Retornamos la vista para modidificar una categoria
    return view('dashboard.categories.edit', compact('category'));
  }

  /**
   * Actualizar una categoría existente
   */
  public function update(UpdateCategoryRequest $request, Category $category)
  {
    $data = [
      'name' => ucwords(strtolower(trim($request->name))),
      'description' => $request->description,
    ];

    // Actualizar la categoria
    Category::where('id', $category->id)->update($data);
    // Redirigir a la lista de categorías con mensaje de éxito
    return redirect()
      ->route('categories.index')
      ->with('message', 'Categoria actualizada correctamente')
      ->with('icon', 'success');
  }

  /**
   * Eliminar una categoría existente
   */
  public function destroy(Category $category)
  {
    // Comprobamos que la categoria existe
    $findCategory = $this->findCategory($category->id);
    // Si existe eliminar la categoria
    Category::where('id', $findCategory->id)->delete();
    // Redirigir a la lista de categorías con mensaje de éxito
    return redirect()
      ->route('categories.index')
      ->with('message', 'Categoria eliminada correctamente')
      ->with('icon', 'success');
  }

  /**
   * Método para comprobar que existe una categoría
   */
  public function findCategory(int $id): Category|ModelNotFoundException
  {
    return Category::findOrfail($id);
  }
}
