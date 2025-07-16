<?php

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Career;
use App\Models\Event;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Disable CSRF protection for tests
    $this->withoutMiddleware();
    
    // Crear roles necesarios
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'auxiliar']);
    
    // Crear usuario con permisos
    $this->user = User::factory()->create();
    $this->user->assignRole('admin');
    
    // Actuar como el usuario autenticado
    $this->actingAs($this->user);
});

test('puede crear un evento exitosamente', function () {
    // Arrange - Preparar datos necesarios
    $activity = Activity::factory()->create();
    $agreement = Agreement::factory()->create();
    $career = Career::factory()->create();
    $universities = University::factory()->count(2)->create();

    $eventData = [
        'name' => 'Conferencia Internacional de Tecnología',
        'responsable' => 'Dr. Juan Pérez',
        'activity_id' => $activity->id,
        'has_agreement' => 'si',
        'agreement_id' => $agreement->id,
        'modality' => 'presencial',
        'location' => 'internacional',
        'internationalization_at_home' => 'no',
        'start_date' => '2024-12-15',
        'end_date' => '2024-12-17',
        'start_time' => '09:00',
        'end_time' => '17:00',
        'universities' => $universities->pluck('id')->toArray(),
        'description' => 'Una conferencia sobre las últimas tendencias en tecnología',
        'career_id' => $career->id,
    ];

    // Act - Ejecutar la acción
    $response = $this->post(route('events.store'), $eventData);

    // Assert - Verificar resultados
    $response->assertRedirect(route('events'));
    $response->assertSessionHas('success', 'Evento creado exitosamente.');

    // Verificar que el evento se guardó en la base de datos
    $this->assertDatabaseHas('events', [
        'name' => 'Conferencia Internacional de Tecnología',
        'responsable' => 'Dr. Juan Pérez',
        'activity_id' => $activity->id,
        'has_agreement' => 'si',
        'agreement_id' => $agreement->id,
        'modality' => 'presencial',
        'location' => 'internacional',
        'internationalization_at_home' => 'no',
        'start_date' => '2024-12-15',
        'end_date' => '2024-12-17',
        'start_time' => '09:00:00',
        'end_time' => '17:00:00',
        'description' => 'Una conferencia sobre las últimas tendencias en tecnología',
        'career_id' => $career->id,
    ]);

    // Verificar que el código del evento se generó correctamente
    $event = Event::where('name', 'Conferencia Internacional de Tecnología')->first();
    expect($event->event_code)->toMatch('/^\d{7}$/'); // 4 digits (ddmm) + 3 random digits

    // Verificar que las universidades se asociaron correctamente
    expect($event->universities)->toHaveCount(2);
    expect($event->universities->pluck('id')->toArray())->toBe($universities->pluck('id')->toArray());
});

test('puede crear un evento sin acuerdo asociado', function () {
    // Arrange
    $activity = Activity::factory()->create();
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Seminario Local',
        'responsable' => 'Ing. María García',
        'activity_id' => $activity->id,
        'has_agreement' => 'no',
        'modality' => 'virtual',
        'location' => 'local',
        'internationalization_at_home' => 'si',
        'start_date' => '2024-11-20',
        'end_date' => '2024-11-20',
        'start_time' => '14:00',
        'end_time' => '16:00',
        'universities' => $universities->pluck('id')->toArray(),
        'description' => 'Seminario sobre desarrollo local',
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertRedirect(route('events'));
    
    $this->assertDatabaseHas('events', [
        'name' => 'Seminario Local',
        'has_agreement' => 'no',
        'agreement_id' => null,
        'internationalization_at_home' => 'si',
    ]);
});

test('falla la validación cuando faltan campos requeridos', function () {
    // Act - Intentar crear evento sin datos requeridos
    $response = $this->post(route('events.store'), []);

    // Assert - Verificar que regresa errores de validación
    $response->assertSessionHasErrors([
        'name',
        'responsable',
        'activity_id',
        'has_agreement',
        'modality',
        'location',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'universities',
    ]);
});

test('falla la validación cuando has_agreement es si pero no se proporciona agreement_id', function () {
    // Arrange
    $activity = Activity::factory()->create();
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Evento de Prueba',
        'responsable' => 'Test User',
        'activity_id' => $activity->id,
        'has_agreement' => 'si', // Indica que tiene acuerdo
        // 'agreement_id' => null, // Pero no se proporciona el ID del acuerdo
        'modality' => 'presencial',
        'location' => 'local',
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-01',
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => $universities->pluck('id')->toArray(),
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertSessionHasErrors(['agreement_id']);
});

test('falla la validación cuando la fecha de fin es anterior a la fecha de inicio', function () {
    // Arrange
    $activity = Activity::factory()->create();
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Evento de Prueba',
        'responsable' => 'Test User',
        'activity_id' => $activity->id,
        'has_agreement' => 'no',
        'modality' => 'presencial',
        'location' => 'local',
        'start_date' => '2024-12-15',
        'end_date' => '2024-12-10', // Fecha de fin anterior a la de inicio
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => $universities->pluck('id')->toArray(),
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertSessionHasErrors(['end_date']);
});

test('falla la validación cuando se proporcionan valores inválidos para los enums', function () {
    // Arrange
    $activity = Activity::factory()->create();
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Evento de Prueba',
        'responsable' => 'Test User',
        'activity_id' => $activity->id,
        'has_agreement' => 'maybe', // Valor inválido
        'modality' => 'hibrido', // Valor inválido
        'location' => 'espacial', // Valor inválido
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-01',
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => $universities->pluck('id')->toArray(),
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertSessionHasErrors([
        'has_agreement',
        'modality',
        'location',
    ]);
});

test('falla la validación cuando se proporciona una actividad inexistente', function () {
    // Arrange
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Evento de Prueba',
        'responsable' => 'Test User',
        'activity_id' => 99999, // ID que no existe
        'has_agreement' => 'no',
        'modality' => 'presencial',
        'location' => 'local',
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-01',
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => $universities->pluck('id')->toArray(),
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertSessionHasErrors(['activity_id']);
});

test('falla la validación cuando se proporcionan universidades inexistentes', function () {
    // Arrange
    $activity = Activity::factory()->create();

    $eventData = [
        'name' => 'Evento de Prueba',
        'responsable' => 'Test User',
        'activity_id' => $activity->id,
        'has_agreement' => 'no',
        'modality' => 'presencial',
        'location' => 'local',
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-01',
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => [99999, 99998], // IDs que no existen
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertSessionHasErrors(['universities.0', 'universities.1']);
});

test('el codigo del evento se genera correctamente con el formato fecha + numero aleatorio', function () {
    // Arrange
    $activity = Activity::factory()->create();
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Evento de Prueba',
        'responsable' => 'Test User',
        'activity_id' => $activity->id,
        'has_agreement' => 'no',
        'modality' => 'presencial',
        'location' => 'local',
        'internationalization_at_home' => 'no',
        'start_date' => '2024-07-25', // 25 de julio
        'end_date' => '2024-07-25',
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => $universities->pluck('id')->toArray(),
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $event = Event::where('name', 'Evento de Prueba')->first();
    
    // El código debe comenzar con "2507" (25 de julio) seguido de 3 dígitos aleatorios
    expect($event->event_code)->toMatch('/^2507\d{3}$/');
    expect(strlen($event->event_code))->toBe(7);
});

test('puede crear evento con campos opcionales nulos', function () {
    // Arrange
    $activity = Activity::factory()->create();
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Evento Minimo',
        'responsable' => 'Test User',
        'activity_id' => $activity->id,
        'has_agreement' => 'no',
        'modality' => 'presencial',
        'location' => 'local',
        'internationalization_at_home' => 'no',
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-01',
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => $universities->pluck('id')->toArray(),
        // Campos opcionales no proporcionados:
        // 'description' => null,
        // 'career_id' => null,
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertRedirect(route('events'));
    
    $this->assertDatabaseHas('events', [
        'name' => 'Evento Minimo',
        'description' => null,
        'career_id' => null,
    ]);
});

test('se registra correctamente el log cuando se crea un evento', function () {
    // Arrange
    $activity = Activity::factory()->create();
    $universities = University::factory()->count(1)->create();

    $eventData = [
        'name' => 'Evento para Log',
        'responsable' => 'Test User',
        'activity_id' => $activity->id,
        'has_agreement' => 'no',
        'modality' => 'presencial',
        'location' => 'local',
        'internationalization_at_home' => 'no',
        'start_date' => '2024-12-01',
        'end_date' => '2024-12-01',
        'start_time' => '10:00',
        'end_time' => '12:00',
        'universities' => $universities->pluck('id')->toArray(),
    ];

    // Act
    $response = $this->post(route('events.store'), $eventData);

    // Assert
    $response->assertRedirect(route('events'));
    
    // Verificar que el evento se creó correctamente
    $this->assertDatabaseHas('events', [
        'name' => 'Evento para Log',
        'responsable' => 'Test User',
    ]);
});
