# Guía de la prueba

## Migraciones `/migrations`

### `2025_06_17_075041_create_projects_table.php`

:green_circle: Si los estados estan predefinidos, ¿la columna está correctamente definida?
> Debería de ser un `enum` con los valores definidos en el modelo `Project`.

:yellow_circle: Si el campo `name` y `status` sirve para buscar, ¿que falta?
> Falta un índice para mejorar el rendimiento de las consultas.

### `2025_06_17_075933_add_identifier_column_projects_table.php`
:green_circle: ¿Que modificación es necesaria para que la columna se cree justo después de la columna `id`?
> La columna `identifier` debe ser creada con la opción `after('id')`.

:yellow_circle: ¿Que problema dará esta migración?
> Se crea una columna que no es `nullable` sin un valor por defect, además no es única, lo que puede causar problemas al insertar datos.

## Routes `/routes/api.php`
:red_circle: ¿Que ves mal?
- Se podría agrupar en grupos
- Pone `proyectos` en vez de `projects`

:yellow_circle: Tenemos un middleware que queremos aplicar a todos los endpoints que cuelgan de `/projects`, ¿cómo lo harías?
> Agruparía las rutas de `projects` y aplicaría el middleware en el grupo. Por ejemplo:

```php
Route::middleware(\App\Http\Middleware\OnlyIsAdmin::class)->prefix('projects')->group(function () {
    ....
});
```

## Models `/app/Models`

### `Project.php`

:green_circle: ¿Que ves mal?
> Falta el tipado de las relaciones

:yellow_circle: ¿Porque en `admin()` se especifica la columna y en `tasks()` no?
> Porque la columna no sigue la conveción de convención de nombres de Laravel, mientras que `tasks` sí lo hace.

## Controllers `/app/Http/Controllers`

### `ProjectController.php`
¿Que ves mal?
- :green_circle: No se hace query builder
- :green_circle: Faltan tipados en las respuestas y en los parámetros de las funciones.
- :green_circle: No se valida nada
- :green_circle: Endpoints que no devuelve nada y cada uno devuelve un tipo de respuesta diferente.
- :yellow_circle: Se usa `Project::all()` en vez de `Project::paginate()`, lo que puede causar problemas de rendimiento si hay muchos proyectos.

### `TareasController.php`
¿Que ves mal?
- :green_circle: Archivo mal formateado.
- :green_circle: El nombre del controlador debería ser `TaskController` para seguir la convención de nombres de Laravel.
- :green_circle: El nombre de las variables ni misimo idioma ni sigue el mismo patrón (camelcase o snakecase).
- :yellow_circle: Validaciones dentro de los métodos y no en un `FormRequest`.
- :yellow_circle: El método store devuelve un `200` en vez de un `201` para indicar que se ha creado un recurso.
- :red_circle: Se recibe el project en la url pero no se valida que el `task.project_id` sea el mismo que el `project.id` de la url por tal de validar que la url es correcta.
- :red_circle: Al crear y actualizar dentro del controlador ese código no es reutilizable. Estaría bien extraerlo a otra capa. (Ejemplo: UsersController)

## Bonus track

### Preguntas generales
:red_circle: Para hacer que un usuario pueda observar tanto un proyecto como una tarea, ¿cómo debería de ser la relación en el modelo `Watcher`? ¿Es correcto como está?
> Debería de ser una relación polimórfica para que el modelo `Watcher` pueda observar tanto proyectos como tareas. Actualmente, no es correcto ya que no se ha implementado una relación polimórfica.
> 
> Para implementar esto, modificaría el modelo `Watcher` para incluir una relación polimórfica y crearía las migraciones necesarias para agregar las columnas `watchable_id` y `watchable_type` en la tabla `watchers`.

:red_circle: Tenemos un servicio que queremos usar en distintos proyectos. ¿Que planteamiento harías?
> Crearía un paquete de Laravel que encapsule la lógica del servicio y lo haga reutilizable en diferentes proyectos. Este paquete podría ser instalado a través de Composer y configurado según las necesidades de cada proyecto.

:red_circle: Dado el servicio anterior, ¿como solventarias la evolución de este cuando haya cambios que rompe la compatibilidad en proyectos donde se usa?
> Implementaría un sistema de versiones en el paquete del servicio. Cada vez que se realice un cambio que rompa la compatibilidad, incrementaría la versión principal del paquete y documentaría los cambios necesarios para actualizar los proyectos que lo utilizan. Además, proporcionaría una guía de migración para facilitar la actualización a los desarrolladores.

### Command `ImportadorUsuarios` teniendo en cuenta que el FakeImporter es un request a una API externa
¿Porque está mal el código?
- :green_circle: No hay una validación, ni se mira si el usuario ya existe lo que dará conflictos al insertar.
- :red_circle: Está mal planteado, ya que se debería extraer en una función y usar la recursividad.

