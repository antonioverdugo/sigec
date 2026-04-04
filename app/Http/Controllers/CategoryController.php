<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador para la gestión de categorías.
 *
 * Maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * de categorías en el panel de administración.
 */
class CategoryController extends Controller
{
    /**
     * Listar todas las categorías
     */
    public function index(): View
    {
        /**
         * Muestra una lista paginada de categorías.
         *
         * Recupera todas las categorías con paginación de 8 elementos
         * por página para mostrarlas en la vista del dashboard.
         *
         * @return View Vista con la lista de categorías.
         *
         * @example GET /categories
         */
        $categories = Category::paginate(8);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Muestra el formulario para crear una nueva categoría.
     *
     * Retorna la vista con el formulario de creación de categorías.
     *
     * @return View Vista del formulario de creación.
     *
     * @example GET /categories/create
     */
    public function create(): View
    {
        // Retornamos la vista del formulario para crear una nueva categoria
        return view('dashboard.categories.create');
    }

    /**
     * Guarda una nueva categoría en la base de datos.
     *
     * Valida los datos del request, normaliza el nombre (capitaliza
     * la primera letra de cada palabra) y crea la categoría.
     *
     * @param  CreateCategoryRequest  $request  Datos validados del formulario.
     * @return RedirectResponse Redirección a la lista con mensaje de éxito.
     *
     * @example POST /categories
     */
    public function store(CreateCategoryRequest $request): RedirectResponse
    {
        // Crear la categoria
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
     * Guarda una nueva categoría en la base de datos.
     *
     * Valida los datos del request, normaliza el nombre (capitaliza
     * la primera letra de cada palabra) y crea la categoría.
     *
     * @param  CreateCategoryRequest  $request  Datos validados del formulario.
     * @return RedirectResponse Redirección a la lista con mensaje de éxito.
     *
     * @example POST /categories
     */
    public function show(Category $category): RedirectResponse
    {
        return redirect()->route('categories.index');
    }

    /**
     * Muestra los detalles de una categoría específica.
     *
     * Redirige a la lista de categorías ya que esta vista
     * no es necesaria en el sistema actual.
     *
     * @param  Category  $category  Categoría a mostrar.
     * @return RedirectResponse Redirección a la lista de categorías.
     *
     * @example GET /categories/{category}
     */
    public function edit(Category $category): View|RedirectResponse
    {
        // Si la categoria es la general no permitir editarla
        if ($category->id === 1) {
            return redirect()->route('categories.index');
        }
        // Comprobamos que la categoria existe
        $category = $this->findCategory($category->id);

        // Retornamos la vista para modidificar una categoria
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Actualiza una categoría existente.
     *
     * Valida los datos del request, normaliza el nombre y
     * actualiza la categoría en la base de datos.
     *
     * @param  UpdateCategoryRequest  $request  Datos validados del formulario.
     * @param  Category  $category  Categoría a actualizar.
     * @return RedirectResponse Redirección a la lista con mensaje de éxito.
     *
     * @example PUT /categories/{category}
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
     * Elimina una categoría existente.
     *
     * Verifica que la categoría exista y la elimina de la
     * base de datos.
     *
     * @param  Category  $category  Categoría a eliminar.
     * @return RedirectResponse Redirección a la lista con mensaje de éxito.
     *
     * @example DELETE /categories/{category}
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
     * Busca una categoría por su ID.
     *
     * Utiliza findOrFail para lanzar excepción si no se encuentra.
     *
     * @param  int  $id  ID de la categoría a buscar.
     * @return Category|ModelNotFoundException Categoría encontrada.
     *
     * @throws ModelNotFoundException Si la categoría no existe.
     */
    public function findCategory(int $id): Category|ModelNotFoundException
    {
        return Category::findOrfail($id);
    }
}
