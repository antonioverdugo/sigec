<?php
/**
 * Tests Unitarios para Modelos de SIGEC
 * 
 * Este archivo contiene pruebas unitarias para verificar el comportamiento
 * de todos los modelos Eloquent del sistema SIGEC.
 * 
 * Modelos probados:
 * - Category: categorías de contenido
 * - Sponsor: patrocinadores del evento
 * - TypeSponsor: tipos de patrocinio
 * - TypePresentation: tipos de presentación
 * - Role: roles de usuario
 * - User: usuarios del sistema
 * - Poster: pósters científicos
 * - Presentation: presentaciones orales
 * 
 * @see Category
 * @see Sponsor
 * @see TypeSponsor
 * @see TypePresentation
 * @see Role
 * @see User
 * @see Poster
 * @see Presentation
 */

use App\Models\Category;
use App\Models\Poster;
use App\Models\Presentation;
use App\Models\Sponsor;
use App\Models\TypeSponsor;
use App\Models\TypePresentation;
use App\Models\Role;
use App\Models\User;

/**
 * Setup: Crear roles base antes de cada test
 * Se crean los tres roles principales del sistema para usar en las pruebas
 */
beforeEach(function () {
    $this->roleAdmin = Role::factory()->admin()->create();
    $this->rolePonente = Role::factory()->ponente()->create();
    $this->roleAsistente = Role::factory()->asistente()->create();
});

/**
 * Tests del Modelo Category
 * 
 * Verifica que el modelo Category pueda tener relaciones HasMany
 * con Presentation y Poster.
 */
describe('Unit: Category Model', function () {
    
    /**
     * Test: category puede tener presentaciones
     * 
     * Verifica que una categoría pueda asociarse con múltiples
     * presentaciones a través de la relación presentations().
     */
    test('category puede tener presentaciones', function () {
        $category = Category::factory()->create();
        Presentation::factory()->count(3)->create(['category_id' => $category->id]);
        expect($category->presentations)->toHaveCount(3);
    });

    /**
     * Test: category puede tener pósters
     * 
     * Verifica que una categoría pueda asociarse con múltiples
     * pósters a través de la relación posters().
     */
    test('category puede tener pósters', function () {
        $category = Category::factory()->create();
        Poster::factory()->count(5)->create(['category_id' => $category->id]);
        expect($category->posters)->toHaveCount(5);
    });
});

/**
 * Tests del Modelo Sponsor
 * 
 * Verifica las relaciones y funcionalidades del modelo Sponsor,
 * incluyendo la relación BelongsTo con TypeSponsor.
 */
describe('Unit: Sponsor Model', function () {
    
    /**
     * Test: sponsor tiene tipo de patrocinio
     * 
     * Verifica que un patrocinador tenga asociada una relación
     * type_sponsor (no sea null).
     */
    test('sponsor tiene tipo de patrocinio', function () {
        $sponsor = Sponsor::factory()->create();
        expect($sponsor->type_sponsor)->not->toBeNull();
    });

    /**
     * Test: sponsor puede ser de tipo oro
     * 
     * Verifica que se pueda crear un patrocinador con tipo 'gold'
     * usando la factory correspondiente.
     */
    test('sponsor puede ser de tipo oro', function () {
        $sponsor = Sponsor::factory()->gold()->create();
        expect($sponsor->type_sponsor->name)->toBe('gold');
    });

    /**
     * Test: sponsor pertenece a type_sponsor
     * 
     * Verifica que la relación BelongsTo funcione correctamente
     * asignando un sponsor a un tipo específico.
     */
    test('sponsor pertenece a type_sponsor', function () {
        $typeSponsor = TypeSponsor::factory()->platinum()->create();
        $sponsor = Sponsor::factory()->create(['type_sponsor_id' => $typeSponsor->id]);
        expect($sponsor->type_sponsor->name)->toBe('platinum');
    });
});

/**
 * Tests del Modelo TypeSponsor
 * 
 * Verifica que el modelo TypeSponsor pueda tener múltiples
 * patrocinadores a través de la relación HasMany.
 */
describe('Unit: TypeSponsor Model', function () {
    
    /**
     * Test: type_sponsor puede tener patrocinadores
     * 
     * Verifica que un tipo de patrocinio pueda asociarse
     * con múltiples patrocinadores.
     */
    test('type_sponsor puede tener patrocinadores', function () {
        $typeSponsor = TypeSponsor::factory()->create();
        Sponsor::factory()->count(4)->create(['type_sponsor_id' => $typeSponsor->id]);
        expect($typeSponsor->sponsors)->toHaveCount(4);
    });
});

/**
 * Tests del Modelo TypePresentation
 * 
 * Verifica que el modelo TypePresentation pueda tener relaciones
 * HasMany con Presentation y Poster.
 */
describe('Unit: TypePresentation Model', function () {
    
    /**
     * Test: type_presentation puede tener presentations
     * 
     * Verifica que un tipo de presentación pueda asociarse
     * con múltiples presentaciones.
     */
    test('type_presentation puede tener presentations', function () {
        $typePresentation = TypePresentation::factory()->oral()->create();
        Presentation::factory()->count(3)->create(['type_presentation_id' => $typePresentation->id]);
        expect($typePresentation->presentations)->toHaveCount(3);
    });

    /**
     * Test: type_presentation puede tener posters
     * 
     * Verifica que un tipo de presentación pueda asociarse
     * con múltiples pósters.
     */
    test('type_presentation puede tener posters', function () {
        $typePresentation = TypePresentation::factory()->poster()->create();
        Poster::factory()->count(2)->create(['type_presentation_id' => $typePresentation->id]);
        expect($typePresentation->posters)->toHaveCount(2);
    });
});

/**
 * Tests del Modelo Role
 * 
 * Verifica las relaciones del modelo Role, principalmente
 * la relación HasMany con User.
 */
describe('Unit: Role Model', function () {
    
    /**
     * Test: role puede tener usuarios
     * 
     * Verifica que un rol pueda tener múltiples usuarios
     * asociados a través de la relación users().
     */
    test('role puede tener usuarios', function () {
        $role = Role::factory()->create();
        User::factory()->count(4)->create(['role_id' => $role->id]);
        expect($role->users)->toHaveCount(4);
    });

    /**
     * Test: role tiene nombre
     * 
     * Verifica que se pueda crear un rol con un nombre
     * específico usando la factory.
     */
    test('role tiene nombre', function () {
        $role = Role::factory()->admin()->create();
        expect($role->name)->toBe('admin');
    });
});

/**
 * Tests del Modelo User
 * 
 * Verifica las relaciones del modelo User con Role, Presentation
 * y Poster, además del atributo calculado 'initials'.
 */
describe('Unit: User Model', function () {
    
    /**
     * Test: user puede tener role
     * 
     * Verifica que un usuario tenga una relación BelongsTo
     * con el modelo Role.
     */
    test('user puede tener role', function () {
        $user = User::factory()->create(['role_id' => $this->roleAdmin->id]);
        expect($user->role->name)->toBe('admin');
    });

    /**
     * Test: user puede tener presentaciones
     * 
     * Verifica que un usuario pueda crear múltiples
     * presentaciones a través de la relación HasMany.
     */
    test('user puede tener presentaciones', function () {
        $user = User::factory()->create();
        Presentation::factory()->count(2)->create(['user_id' => $user->id]);
        expect($user->presentations)->toHaveCount(2);
    });

    /**
     * Test: user puede tener pósters
     * 
     * Verifica que un usuario pueda crear múltiples
     * pósters a través de la relación HasMany.
     */
    test('user puede tener pósters', function () {
        $user = User::factory()->create();
        Poster::factory()->count(3)->create(['user_id' => $user->id]);
        expect($user->posters)->toHaveCount(3);
    });

    /**
     * Test: user initials attribute returns correct initials
     * 
     * Verifica que el atributo 'initials' del usuario devuelva
     * las dos primeras letras del nombre (ej: "Juan Pérez" -> "JP").
     */
    test('user initials attribute returns correct initials', function () {
        $user = User::factory()->create(['name' => 'Juan Pérez']);
        expect($user->initials)->toBe('JP');
    });

    /**
     * Test: user initials with single name
     * 
     * Verifica el comportamiento del atributo 'initials' cuando
     * el usuario tiene un solo nombre (ej: "Juan" -> "J").
     */
    test('user initials with single name', function () {
        $user = User::factory()->create(['name' => 'Juan']);
        expect($user->initials)->toBe('J');
    });

    /**
     * Test: user initials with three names
     * 
     * Verifica el comportamiento del atributo 'initials' cuando
     * el usuario tiene más de dos nombres (ej: "Juan Antonio López" -> "JA").
     */
    test('user initials with three names', function () {
        $user = User::factory()->create(['name' => 'Juan Antonio López']);
        expect($user->initials)->toBe('JA');
    });
});

/**
 * Tests del Modelo Poster
 * 
 * Verifica las relaciones BelongsTo del modelo Poster con
 * User, Category y TypePresentation, además del estado 'published'.
 */
describe('Unit: Poster Model', function () {
    
    /**
     * Test: poster pertenece a user
     * 
     * Verifica que un póster tenga asociado un usuario
     * (autor del póster).
     */
    test('poster pertenece a user', function () {
        $poster = Poster::factory()->create();
        expect($poster->user)->not->toBeNull();
    });

    /**
     * Test: poster pertenece a category
     * 
     * Verifica que un póster tenga asociada una categoría.
     */
    test('poster pertenece a category', function () {
        $poster = Poster::factory()->create();
        expect($poster->category)->not->toBeNull();
    });

    /**
     * Test: poster pertenece a type_presentation
     * 
     * Verifica que un póster tenga asociado un tipo
     * de presentación.
     */
    test('poster pertenece a type_presentation', function () {
        $poster = Poster::factory()->create();
        expect($poster->type_presentation)->not->toBeNull();
    });

    /**
     * Test: poster puede estar publicado
     * 
     * Verifica que se pueda crear un póster con estado
     * published = true.
     */
    test('poster puede estar publicado', function () {
        $poster = Poster::factory()->published()->create();
        expect($poster->published)->toBeTrue();
    });

    /**
     * Test: poster puede estar sin publicar
     * 
     * Verifica que se pueda crear un póster con estado
     * published = false.
     */
    test('poster puede estar sin publicar', function () {
        $poster = Poster::factory()->unpublished()->create();
        expect($poster->published)->toBeFalse();
    });
});

/**
 * Tests del Modelo Presentation
 * 
 * Verifica las relaciones BelongsTo del modelo Presentation con
 * User, Category y TypePresentation, además del estado 'published'.
 */
describe('Unit: Presentation Model', function () {
    
    /**
     * Test: presentation pertenece a user
     * 
     * Verifica que una presentación tenga asociado un usuario
     * (autor de la presentación).
     */
    test('presentation pertenece a user', function () {
        $presentation = Presentation::factory()->create();
        expect($presentation->user)->not->toBeNull();
    });

    /**
     * Test: presentation pertenece a category
     * 
     * Verifica que una presentación tenga asociada una categoría.
     */
    test('presentation pertenece a category', function () {
        $presentation = Presentation::factory()->create();
        expect($presentation->category)->not->toBeNull();
    });

    /**
     * Test: presentation pertenece a type_presentation
     * 
     * Verifica que una presentación tenga asociado un tipo
     * de presentación.
     */
    test('presentation pertenece a type_presentation', function () {
        $presentation = Presentation::factory()->create();
        expect($presentation->type_presentation)->not->toBeNull();
    });

    /**
     * Test: presentation puede estar publicada
     * 
     * Verifica que se pueda crear una presentación con estado
     * published = true.
     */
    test('presentation puede estar publicada', function () {
        $presentation = Presentation::factory()->published()->create();
        expect($presentation->published)->toBeTrue();
    });
});