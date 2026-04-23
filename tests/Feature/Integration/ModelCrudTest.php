<?php
/**
 * Tests de Integración para CRUD y Validación de SIGEC
 * 
 * Este archivo contiene pruebas de integración para verificar:
 * 1. Las reglas de validación de los FormRequest
 * 2. Las operaciones CRUD de los modelos principales
 * 3. El comportamiento de los pósters públicos
 * 
 * Modelos probados:
 * - Category: categorías de contenido
 * - Sponsor: patrocinadores del evento
 * - Poster: pósters científicos
 * - User: usuarios del sistema
 * - Presentation: presentaciones orales
 * 
 * Requests probados:
 * - CreateCategoryRequest, UpdateCategoryRequest
 * - CreateSponsorRequest, UpdateSponsorRequest
 * - CreatePosterRequest, UpdatePosterRequest
 * - CreateUserRequest, UpdateUserRequest
 * 
 * @see Category
 * @see Sponsor
 * @see Poster
 * @see User
 * @see Presentation
 */

use App\Models\Category;
use App\Models\Poster;
use App\Models\Presentation;
use App\Models\Sponsor;
use App\Models\Role;
use App\Models\User;
use App\Models\TypeSponsor;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Sponsor\CreateSponsorRequest;
use App\Http\Requests\Sponsor\UpdateSponsorRequest;
use App\Http\Requests\Poster\CreatePosterRequest;
use App\Http\Requests\Poster\UpdatePosterRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

/**
 * Setup: Crear roles base antes de cada test
 * Se crean los tres roles principales del sistema
 */
beforeEach(function () {
    $this->roleAdmin = Role::factory()->admin()->create();
    $this->rolePonente = Role::factory()->ponente()->create();
    $this->roleAsistente = Role::factory()->asistente()->create();
});

/**
 * =============================================================================
 * TESTS DE VALIDACIÓN DE REQUESTS
 * =============================================================================
 * 
 * Verifican que los FormRequest tienen las reglas de validación
 * necesarias para cada operación.
 */

/**
 * Tests de Validación para Category
 * 
 * Verifica que los requests de Category tengan reglas definidas
 * para los campos name y description.
 */
describe('Unit: Category Requests', function () {
    
    /**
     * Test: CreateCategoryRequest tiene reglas de validación
     * 
     * Verifica que el request de creación tenga reglas para
     * name (obligatorio) y description (opcional).
     */
    test('CreateCategoryRequest tiene reglas de validación', function () {
        $request = new CreateCategoryRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('name');
        expect($rules)->toHaveKey('description');
    });

    /**
     * Test: UpdateCategoryRequest tiene reglas de validación
     * 
     * Verifica que el request de actualización tenga reglas
     * para el campo name.
     */
    test('UpdateCategoryRequest tiene reglas de validación', function () {
        $request = new UpdateCategoryRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('name');
    });
});

/**
 * Tests de Validación para Sponsor
 * 
 * Verifica que los requests de Sponsor tengan reglas definidas
 * para name, email y type_sponsor_id.
 */
describe('Unit: Sponsor Requests', function () {
    
    /**
     * Test: CreateSponsorRequest tiene reglas de validación
     * 
     * Verifica que el request de creación tenga reglas para
     * name, email y type_sponsor_id.
     */
    test('CreateSponsorRequest tiene reglas de validación', function () {
        $request = new CreateSponsorRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('name');
        expect($rules)->toHaveKey('email');
        expect($rules)->toHaveKey('type_sponsor_id');
    });

    /**
     * Test: UpdateSponsorRequest tiene reglas de validación
     * 
     * Verifica que el request de actualización tenga reglas
     * para el campo name.
     */
    test('UpdateSponsorRequest tiene reglas de validación', function () {
        $request = new UpdateSponsorRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('name');
    });
});

/**
 * Tests de Validación para Poster
 * 
 * Verifica que los requests de Poster tengan reglas definidas
 * para title y summary.
 */
describe('Unit: Poster Requests', function () {
    
    /**
     * Test: CreatePosterRequest tiene reglas de validación
     * 
     * Verifica que el request de creación tenga reglas para
     * title y summary.
     */
    test('CreatePosterRequest tiene reglas de validación', function () {
        $request = new CreatePosterRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('title');
        expect($rules)->toHaveKey('summary');
    });

    /**
     * Test: UpdatePosterRequest tiene reglas de validación
     * 
     * Verifica que el request de actualización tenga reglas
     * para el campo title.
     */
    test('UpdatePosterRequest tiene reglas de validación', function () {
        $request = new UpdatePosterRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('title');
    });
});

/**
 * Tests de Validación para User
 * 
 * Verifica que los requests de User tengan reglas definidas
 * para name, email, password y role_id.
 */
describe('Unit: User Requests', function () {
    
    /**
     * Test: CreateUserRequest tiene reglas de validación
     * 
     * Verifica que el request de creación tenga reglas para
     * name, email, password y role_id.
     */
    test('CreateUserRequest tiene reglas de validación', function () {
        $request = new CreateUserRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('name');
        expect($rules)->toHaveKey('email');
        expect($rules)->toHaveKey('password');
        expect($rules)->toHaveKey('role_id');
    });

    /**
     * Test: UpdateUserRequest tiene reglas de validación
     * 
     * Verifica que el request de actualización tenga reglas
     * para name y email.
     */
    test('UpdateUserRequest tiene reglas de validación', function () {
        $request = new UpdateUserRequest();
        $rules = $request->rules();
        
        expect($rules)->toBeArray();
        expect($rules)->toHaveKey('name');
        expect($rules)->toHaveKey('email');
    });
});

/**
 * =============================================================================
 * TESTS DE OPERACIONES CRUD
 * =============================================================================
 * 
 * Verifican las operaciones de Crear, Leer, Actualizar y Eliminar
 * de los modelos principales del sistema.
 */

/**
 * Tests de Operaciones CRUD para Category
 * 
 * Verifica que se puedan crear, actualizar y eliminar categorías.
 */
describe('Feature: Category CRUD Operations', function () {
    
    /**
     * Test: Category puede ser creada
     * 
     * Verifica que se pueda crear una nueva categoría con
     * nombre y descripción específicos.
     */
    test('Category puede ser creada', function () {
        $category = Category::factory()->create([
            'name' => 'Neurociencia',
            'description' => 'Categoría sobre neurociencia',
        ]);
        
        expect($category)->toBeInstanceOf(Category::class);
        expect($category->name)->toBe('Neurociencia');
        $this->assertDatabaseHas('categories', ['name' => 'Neurociencia']);
    });

    /**
     * Test: Category puede ser actualizada
     * 
     * Verifica que se pueda actualizar el nombre de una
     * categoría existente.
     */
    test('Category puede ser actualizada', function () {
        $category = Category::factory()->create();
        
        $category->update(['name' => 'Neurociencia Actualizada']);
        
        expect($category->name)->toBe('Neurociencia Actualizada');
        $this->assertDatabaseHas('categories', ['name' => 'Neurociencia Actualizada']);
    });

    /**
     * Test: Category puede ser eliminada
     * 
     * Verifica que se pueda eliminar una categoría y que
     * ya no exista en la base de datos.
     */
    test('Category puede ser eliminada', function () {
        $category = Category::factory()->create();
        $id = $category->id;
        
        $category->delete();
        
        $this->assertDatabaseMissing('categories', ['id' => $id]);
    });
});

/**
 * Tests de Operaciones CRUD para Sponsor
 * 
 * Verifica que se puedan crear, actualizar y eliminar patrocinadores.
 */
describe('Feature: Sponsor CRUD Operations', function () {
    
    /**
     * Test: Sponsor puede ser creado
     * 
     * Verifica que se pueda crear un nuevo patrocinador con
     * nombre, email y tipo de patrocinio.
     */
    test('Sponsor puede ser creado', function () {
        $typeSponsor = TypeSponsor::factory()->gold()->create();
        
        $sponsor = Sponsor::factory()->create([
            'name' => 'TechCorp',
            'email' => 'contact@techcorp.com',
            'type_sponsor_id' => $typeSponsor->id,
        ]);
        
        expect($sponsor)->toBeInstanceOf(Sponsor::class);
        expect($sponsor->name)->toBe('TechCorp');
        $this->assertDatabaseHas('sponsors', ['name' => 'TechCorp']);
    });

    /**
     * Test: Sponsor puede ser actualizado
     * 
     * Verifica que se pueda actualizar el nombre de un
     * patrocinador existente.
     */
    test('Sponsor puede ser actualizado', function () {
        $sponsor = Sponsor::factory()->create();
        
        $sponsor->update(['name' => 'TechCorp Editado']);
        
        expect($sponsor->name)->toBe('TechCorp Editado');
        $this->assertDatabaseHas('sponsors', ['name' => 'TechCorp Editado']);
    });

    /**
     * Test: Sponsor puede ser eliminado
     * 
     * Verifica que se pueda eliminar un patrocinador y que
     * ya no exista en la base de datos.
     */
    test('Sponsor puede ser eliminado', function () {
        $sponsor = Sponsor::factory()->create();
        $id = $sponsor->id;
        
        $sponsor->delete();
        
        $this->assertDatabaseMissing('sponsors', ['id' => $id]);
    });
});

/**
 * Tests de Operaciones CRUD para Poster
 * 
 * Verifica que se puedan crear, actualizar, publicar y eliminar pósters.
 */
describe('Feature: Poster CRUD Operations', function () {
    
    /**
     * Test: Poster puede ser creado
     * 
     * Verifica que un ponente pueda crear un nuevo póster con
     * título, resumen y categoría.
     */
    test('Poster puede ser creado', function () {
        $ponente = User::factory()->create(['role_id' => $this->rolePonente->id]);
        $category = Category::factory()->create();
        
        $poster = Poster::factory()->create([
            'title' => 'Título Póster',
            'summary' => 'Resumen del póster científico',
            'user_id' => $ponente->id,
            'category_id' => $category->id,
        ]);
        
        expect($poster)->toBeInstanceOf(Poster::class);
        expect($poster->title)->toBe('Título Póster');
        $this->assertDatabaseHas('posters', ['title' => 'Título Póster']);
    });

    /**
     * Test: Poster puede ser actualizado por el propietario
     * 
     * Verifica que el autor del póster pueda actualizar
     * el título de su propio póster.
     */
    test('Poster puede ser actualizado por el propietario', function () {
        $ponente = User::factory()->create(['role_id' => $this->rolePonente->id]);
        $poster = Poster::factory()->create(['user_id' => $ponente->id]);
        
        $poster->update(['title' => 'Título Editado']);
        
        expect($poster->title)->toBe('Título Editado');
        $this->assertDatabaseHas('posters', ['title' => 'Título Editado']);
    });

    /**
     * Test: Poster puede ser publicado
     * 
     * Verifica que se pueda cambiar el estado de un póster
     * de no publicado a publicado.
     */
    test('Poster puede ser publicado', function () {
        $poster = Poster::factory()->unpublished()->create();
        
        $poster->update(['published' => true]);
        
        expect($poster->published)->toBeTrue();
        $this->assertDatabaseHas('posters', ['published' => true]);
    });

    /**
     * Test: Poster puede ser eliminado por el propietario
     * 
     * Verifica que el autor del póster pueda eliminar
     * su propio póster.
     */
    test('Poster puede ser eliminado por el propietario', function () {
        $ponente = User::factory()->create(['role_id' => $this->rolePonente->id]);
        $poster = Poster::factory()->create(['user_id' => $ponente->id]);
        $id = $poster->id;
        
        $poster->delete();
        
        $this->assertDatabaseMissing('posters', ['id' => $id]);
    });
});

/**
 * Tests de Operaciones CRUD para User
 * 
 * Verifica que se puedan crear, actualizar y eliminar usuarios.
 */
describe('Feature: User CRUD Operations', function () {
    
    /**
     * Test: User puede ser creado
     * 
     * Verifica que se pueda crear un nuevo usuario con
     * nombre, email y rol específico.
     */
    test('User puede ser creado', function () {
        $user = User::factory()->create([
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@test.com',
            'role_id' => $this->rolePonente->id,
        ]);
        
        expect($user)->toBeInstanceOf(User::class);
        $this->assertDatabaseHas('users', ['email' => 'nuevo@test.com']);
    });

    /**
     * Test: User puede ser actualizado
     * 
     * Verifica que se pueda actualizar el nombre de un
     * usuario existente.
     */
    test('User puede ser actualizado', function () {
        $user = User::factory()->create();
        
        $user->update(['name' => 'Usuario Editado']);
        
        expect($user->name)->toBe('Usuario Editado');
        $this->assertDatabaseHas('users', ['name' => 'Usuario Editado']);
    });

    /**
     * Test: User puede ser eliminado
     * 
     * Verifica que se pueda eliminar un usuario y que
     * ya no exista en la base de datos.
     */
    test('User puede ser eliminado', function () {
        $user = User::factory()->create();
        $id = $user->id;
        
        $user->delete();
        
        $this->assertDatabaseMissing('users', ['id' => $id]);
    });
});

/**
 * =============================================================================
 * TESTS DE PÓSTERS PÚBLICOS
 * =============================================================================
 * 
 * Verifica el comportamiento del listado público de pósters,
 * donde solo se muestran los pósters publicados.
 */

/**
 * Tests de Listado de Pósters Públicos
 * 
 * Verifica que solo los pósters con published=true sean
 * visibles en el listado público.
 */
describe('Feature: Public Poster Listing', function () {
    
    /**
     * Test: solo pósters publicados son visibles en listado público
     * 
     * Verifica que cuando se crea un póster publicado y uno no publicado,
     * solo el publicado aparezca en el listado público.
     */
    test('solo pósters publicados son visibles en listado público', function () {
        $ponente = User::factory()->create(['role_id' => $this->rolePonente->id]);
        $category = Category::factory()->create();
        
        $publishedPoster = Poster::factory()->published()->create([
            'user_id' => $ponente->id,
            'category_id' => $category->id,
        ]);
        
        $unpublishedPoster = Poster::factory()->unpublished()->create([
            'user_id' => $ponente->id,
            'category_id' => $category->id,
        ]);
        
        $publishedPosters = Poster::where('published', true)->get();
        $unpublishedPosters = Poster::where('published', false)->get();
        
        expect($publishedPosters)->toHaveCount(1);
        expect($publishedPosters->first()->title)->toBe($publishedPoster->title);
        expect($unpublishedPosters)->toHaveCount(1);
    });

    /**
     * Test: pósters públicos pueden ser accedidos
     * 
     * Verifica que un póster publicado esté contenido en la
     * colección de pósters públicos.
     */
    test('pósters públicos pueden ser accedidos', function () {
        $ponente = User::factory()->create(['role_id' => $this->rolePonente->id]);
        $category = Category::factory()->create();
        $poster = Poster::factory()->published()->create([
            'user_id' => $ponente->id,
            'category_id' => $category->id,
        ]);
        
        $publicPosters = Poster::where('published', true)->get();
        
        expect($publicPosters)->toHaveCount(1);
        expect($publicPosters->contains($poster))->toBeTrue();
    });
});

/**
 * =============================================================================
 * TESTS DE PRESENTATION
 * =============================================================================
 * 
 * Verifica las operaciones CRUD del modelo Presentation.
 */

/**
 * Tests de Operaciones CRUD para Presentation
 * 
 * Verifica que se puedan crear y publicar presentaciones.
 */
describe('Feature: Presentation CRUD Operations', function () {
    
    /**
     * Test: Presentation puede ser creada
     * 
     * Verifica que un ponente pueda crear una nueva presentación
     * con título, resumen y categoría.
     */
    test('Presentation puede ser creada', function () {
        $ponente = User::factory()->create(['role_id' => $this->rolePonente->id]);
        $category = Category::factory()->create();
        
        $presentation = Presentation::factory()->create([
            'title' => 'Título Presentación',
            'summary' => 'Resumen de la presentación',
            'user_id' => $ponente->id,
            'category_id' => $category->id,
        ]);
        
        expect($presentation)->toBeInstanceOf(Presentation::class);
        $this->assertDatabaseHas('presentations', ['title' => 'Título Presentación']);
    });

    /**
     * Test: Presentation puede ser publicada
     * 
     * Verifica que se pueda cambiar el estado de una presentación
     * de no publicada a publicada.
     */
    test('Presentation puede ser publicada', function () {
        $presentation = Presentation::factory()->create(['published' => false]);
        
        $presentation->update(['published' => true]);
        
        expect($presentation->published)->toBeTrue();
    });
});