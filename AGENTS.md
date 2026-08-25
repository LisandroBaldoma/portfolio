# IKIGAI — instrucciones definitivas del repositorio
No corras migraciones ni comandos sin mi consentimiento.
Los comandos de tipo php artisan deben ser consultados.

## Propósito y alcance

IKIGAI es un sitio corporativo con portfolio público y CMS autenticado. Presenta servicios, proyectos y sus bloques de contenido, permite el contacto por correo y ofrece páginas públicas para inicio, detalle de proyectos y «Sobre mí».

El alcance actual no incluye blog, ecommerce, gestión avanzada de usuarios ni autenticación pública. Los mensajes de contacto sí se persisten y se gestionan desde el panel autenticado.

## Stack que usa el proyecto

- Laravel 12 con PHP 8.2 o superior.
- MySQL en el entorno local de Laragon.
- Blade para las vistas.
- Tailwind CSS 4, Vite y JavaScript vanilla.
- Alpine.js para interacciones de interfaz.
- Eloquent, migraciones, seeders y Laravel Filesystem (`public`) para datos e imágenes.
- Jobs y Mailables para el formulario de contacto.

No agregues tecnologías, librerías ni patrones alternativos sin una necesidad explícita.

## Arquitectura y ubicación del código

- Las rutas web están en `routes/web.php` y deben tener nombres para los enlaces Blade.
- Las páginas públicas con datos propios usan controladores en `app/Http/Controllers/`; por ejemplo, `HomeController`, `ProjectController` y `AboutMeController`.
- Las operaciones reutilizables viven en `app/Services/`. `ServiceService` concentra la consulta de servicios del home y `ProjectUpdateService` actualiza proyectos, relaciones y bloques.
- La administración está bajo el prefijo y nombre `admin.` con controladores en `app/Http/Controllers/Admin/`.
- Las vistas públicas usan `<x-layouts.public>`. El layout incluye el header y footer públicos.
- Los formularios y fragmentos reutilizables se implementan como componentes Blade en `resources/views/components/`.
- Las nuevas columnas se agregan mediante una migración nueva; no se editan migraciones ya ejecutadas.

## Dominio y datos

### Servicios

`Service` contiene `name`, `slug`, `description`, `icon`, `is_active` y `sort_order`. Se relaciona muchos-a-muchos con `Project` mediante `project_service`.

En el frontend se muestran servicios activos, ordenados por `sort_order`. El contador de cada servicio considera proyectos activos y publicados.

### Proyectos

`Project` contiene título, slug, descripción, URL de producción, tecnologías separadas por comas, imágenes de grid y carrusel, tamaño de grid, fecha de publicación, estado y contadores de vistas y likes.

- Usa `fillable` y `casts` definidos en el modelo al añadir campos persistentes.
- Las imágenes se guardan como rutas relativas en el disco `public`; los accessors del modelo generan su URL pública.
- Carga relaciones con eager loading cuando una vista necesita servicios o bloques.
- En el sitio público, la consulta debe limitarse a `is_active = true`, `published_at` no nulo y `published_at <= now()`.
- El detalle usa route model binding por `slug` (`projects.show`).

### Bloques de proyecto

`ProjectBlock` tiene `project_id`, `data` JSON y `sort_order`. El JSON vigente concentra `title`, `subtitle`, `text` e `image` (`url` y `alt`); no existe una columna `type` en el esquema actual.

El contenido enriquecido se debe renderizar únicamente mediante `safeTitleHtml()`, `safeSubtitleHtml()` o `safeTextHtml()`. No uses `{!! !!}` con datos sin sanitizar.

### Contactos

`Contact` guarda `name`, `email`, `phone`, `company`, `inquiry_type`, `message` y `status`. Puede asociarse a varios servicios mediante `contact_service`.

- Los estados válidos son `nuevo`, `leido`, `respondido` y `archivado`.
- El contacto se registra antes de despachar la notificación por correo.
- Los mensajes se consultan en el recurso autenticado `admin.contacts`; abrir uno nuevo lo cambia a `leido`.

## Comportamiento público vigente

- El home carga servicios con `ServiceService` y proyectos publicados. El filtro por servicio usa el parámetro GET `service` y enlaces a `route('home')`; actualmente recarga la página, no usa AJAX.
- El detalle de proyecto incrementa `views_count` una vez por sesión. El like también se controla por sesión y su endpoint es `projects.like`.
- Los proyectos relacionados comparten servicios con el proyecto actual y excluyen ese proyecto.
- `AboutMeController` lista los proyectos públicos con sus servicios. La vista `aboutme` los presenta como experiencia freelancer; el enlace de producción se muestra solo si `production_url` tiene valor.
- El contacto valida en `ContactController`, guarda el mensaje y sus servicios en la base de datos, y despacha `SendContactEmail` como notificación complementaria.

No cambies estos comportamientos por `localStorage`, AJAX u otros mecanismos sin que la tarea lo pida expresamente.

## CMS y formularios

- Los recursos administrativos de servicios y proyectos se exponen como `Route::resource` sin `show`. Los contactos exponen `index`, `show` y `update` para consulta y seguimiento.
- Al crear o editar proyectos, valida los campos en `Admin\ProjectController`, conserva el slug único y delega la actualización de imágenes, relaciones y bloques a `ProjectUpdateService`.
- `production_url` debe ser una URL válida y `technologies` es texto separado por comas.
- Mantén la asociación de servicios mediante `service_ids` y valida sus IDs contra la tabla `services`.

## Interfaz y contenido

- El sitio público usa una interfaz oscura, minimalista y editorial, con alto contraste y espacios amplios.
- El layout público define los tokens en uso: fondo `#0A111E`, tarjeta `#121212`, borde `#1f1f1f` y acento `#FFC72C`.
- La tipografía pública es `Space Grotesk`; se cargan también los Material Symbols para iconos.
- Conserva las utilidades y clases Tailwind ya usadas en las vistas. El layout público carga Tailwind por CDN; Vite procesa los assets configurados en `vite.config.js`.
- Todo texto visible para usuarios debe estar en español, salvo nombres propios, tecnología o contenido proporcionado por el usuario.
- Respeta la composición responsive existente (`md:`, `lg:`) y la navegación por rutas nombradas.

## Calidad y verificación

- Sigue PSR-12 en PHP y usa tipos de retorno y type hints al crear código nuevo cuando corresponda.
- Evita N+1: usa `with()` o `withCount()` para relaciones necesarias en listas.
- Mantén los cambios acotados: no refactorices código no relacionado con la tarea.
- Después de cambios de PHP o Blade, valida como mínimo con `php artisan view:cache` o el comando de Artisan pertinente; para rutas, usa `php artisan route:list`.
- Ejecuta `php artisan migrate` cuando una tarea incluya una migración. Para comprobar assets, usa `npm run build`.
- El conjunto de pruebas se ejecuta con `php artisan test` o `composer test`.
