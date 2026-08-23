# IKIGAI

Sitio web corporativo y portfolio administrable para una agencia creativa especializada en productos digitales, desarrollo fullstack e integraciones de inteligencia artificial.

IKIGAI transforma ideas en productos digitales sólidos. El proyecto combina una experiencia editorial de alto contraste con un CMS interno para gestionar servicios, proyectos y contenido del portfolio.

## Características

- Página de inicio con hero, servicios y portfolio de proyectos.
- Filtrado de proyectos por servicio.
- Páginas de detalle para cada proyecto.
- Bloques dinámicos con título, subtítulo, texto e imagen.
- Editor enriquecido para contenido de bloques.
- Vista previa y administración de imágenes.
- Eliminación de bloques existentes desde el CMS.
- Carrusel nativo de proyectos relacionados, sin dependencia externa.
- Contadores de vistas y likes por proyecto.
- Formulario de contacto con validación y envío por correo.
- Panel administrativo autenticado.

## Stack tecnológico

- Laravel 12.
- PHP 8.2 o superior.
- MySQL.
- Blade.
- Tailwind CSS.
- Alpine.js.
- JavaScript vanilla.
- Vite.
- Laravel Filesystem para imágenes públicas.
- Mailables y Jobs/Queues para el formulario de contacto.

## Estructura principal

```text
app/
  Http/Controllers/       Controladores públicos y administrativos
  Models/                 Modelos Eloquent
  Services/               Lógica reutilizable de negocio
  Jobs/                   Procesamiento de tareas en cola
  Mail/                   Correos de contacto
database/
  migrations/             Estructura de base de datos
  seeders/                Datos iniciales
resources/
  css/                    Estilos del proyecto
  js/                     JavaScript e interacción
  views/                  Vistas Blade públicas y administrativas
public/
  storage/                Enlace a las imágenes almacenadas
```

## Modelo de contenido

El sistema utiliza estas entidades:

- `users`: usuarios del panel administrativo.
- `services`: servicios mostrados en el sitio.
- `projects`: casos de estudio del portfolio.
- `project_service`: relación many-to-many entre proyectos y servicios.
- `project_blocks`: contenido flexible asociado a cada proyecto.

Cada proyecto puede tener múltiples bloques ordenados. Los bloques guardan sus datos como JSON y soportan título, subtítulo, contenido enriquecido e imagen.

## Requisitos

- PHP 8.2 o superior.
- Composer.
- Node.js y npm.
- MySQL.
- Extensiones PHP requeridas por Laravel.

## Instalación local

Instalar dependencias:

```bash
composer install
npm install
```

Crear el archivo de entorno y generar la clave:

```bash
copy .env.example .env
php artisan key:generate
```

Configurar en `.env` la conexión a MySQL y la URL de la aplicación. En Laragon, por ejemplo:

```env
APP_URL=http://localhost/portfolio/public
DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=
```

Ejecutar migraciones y seeders:

```bash
php artisan migrate --seed
```

Crear el enlace público de imágenes:

```bash
php artisan storage:link
```

## Ejecución

Para desarrollo, iniciar Laravel y Vite:

```bash
php artisan serve
npm run dev
```

También puede utilizarse el script integrado:

```bash
composer run dev
```

## Imágenes

Las imágenes se guardan en `storage/app/public` y se registran en la base de datos como rutas relativas, por ejemplo:

```text
projects/blocks/imagen.png
```

Cada entorno debe tener el enlace `public/storage`, creado mediante `php artisan storage:link`.

## Reglas de visibilidad

El frontend solo muestra proyectos que cumplan ambas condiciones:

- `is_active = true`.
- `published_at` es menor o igual a la fecha actual.

El conteo de proyectos por servicio considera únicamente proyectos activos y publicados.

## Documentación de requerimientos

La especificación funcional completa está disponible en [REQUERIMIENTOS_PROYECTO.md](REQUERIMIENTOS_PROYECTO.md).

## Identidad visual

- Interfaz oscura y minimalista.
- Fondo negro profundo y componentes en gris carbón.
- Color de acento consistente.
- Tipografía sans-serif moderna.
- Títulos fuertes, espacios amplios y composición editorial.

## Marca

IKIGAI toma su nombre de la raíz `xocolatl`, asociada con mezcla, origen y transformación.

**Slogan:** De la idea al producto.

> Diseñamos, planeamos y construimos productos digitales con intención.
