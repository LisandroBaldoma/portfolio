# Requerimientos del Proyecto

## IKIGAI - Sitio Web Corporativo con CMS

## 1. Objetivo

Desarrollar un sitio web corporativo administrable para una agencia creativa. El sistema debe permitir:

- Presentar servicios estratégicos.
- Mostrar proyectos realizados.
- Filtrar proyectos por servicio.
- Exhibir métricas sociales de vistas y likes.
- Mostrar proyectos relacionados.
- Recibir solicitudes de contacto mediante formulario.
- Administrar contenido desde un CMS interno.

El sistema debe ser escalable, minimalista y centrado en contenido dinámico.

## 2. Alcance

### Incluye

- Sitio web público.
- Panel administrativo autenticado.
- Gestión de servicios.
- Gestión de proyectos.
- Gestión de bloques de contenido.
- Sistema simple de vistas y likes.
- Formulario de contacto con envío por correo.

### No incluye

- Blog.
- Ecommerce.
- Gestión avanzada de usuarios.
- Persistencia de leads en base de datos.
- Sistema de autenticación pública.

## 3. Sitio Público

### 3.1 Página de inicio

#### Hero

- Imagen de fondo fija y no administrable.
- Título y subtítulo definidos en código.
- Botones de navegación.
- No requiere módulo en base de datos.

#### Servicios

Contenido dinámico proveniente de la base de datos. Cada servicio debe mostrar:

- Icono.
- Nombre.
- Descripción.
- Cantidad de proyectos asociados.

El conteo debe calcularse automáticamente mediante la relación many-to-many y considerar únicamente proyectos activos.

#### Proyectos

- Diseño tipo masonry o Pinterest.
- Filtro por servicio.
- Solo proyectos activos y publicados.
- Imagen para grid.
- Título del proyecto.
- Filtrado dinámico sin recargar toda la página.

#### Formulario de contacto

Debe ser reutilizable en múltiples páginas y contener:

- Nombre completo.
- Teléfono.
- Empresa.
- Servicios requeridos.
- Mensaje.

Funcionalidad requerida:

- Validación backend.
- Envío por correo.
- Confirmación visual.
- Sin almacenamiento en base de datos.

### 3.2 Página de detalle de proyecto

#### Encabezado

Debe mostrar:

- Servicios asociados como pills.
- Título.
- Descripción principal.
- Contador de vistas.
- Contador de likes.
- Botón "Me gusta".

#### Métricas

Cada proyecto debe contar con:

- `views_count`.
- `likes_count`.

Reglas:

- Una vista por navegador, controlada desde el cliente.
- Un like por navegador, controlado desde el cliente.
- El backend incrementa los contadores solo mediante una solicitud explícita.
- No se almacenan registros individuales por usuario.

#### Bloques dinámicos

Cada proyecto puede contener múltiples bloques estructurados. Los bloques deben permitir:

- Texto principal.
- Texto secundario o subtítulo.
- Imagen.
- Combinación de texto e imagen.
- Orden configurable.
- Layouts personalizados sin modificar el código de cada proyecto.

Estructura mínima:

- `project_id`.
- `type`.
- `data`.
- `sort_order`.

La estructura `data` debe ser flexible para permitir nuevos tipos de bloques en el futuro.

#### Proyectos relacionados

Debajo del contenido principal debe mostrarse un carrusel con otros proyectos:

- Solo proyectos activos y publicados.
- Excluir el proyecto actual.
- Mostrar imagen específica para carrusel.
- Mostrar título.
- Permitir navegación con teclado, mouse y touch.

Cada proyecto debe disponer de:

- Imagen para grid.
- Imagen para carrusel.

#### Formulario de contacto

La página de detalle debe reutilizar el formulario del home.

## 4. CMS Administrativo

### 4.1 Servicios

Campos:

- `name`: nombre.
- `slug`: identificador SEO único.
- `description`: descripción.
- `icon`: icono.
- `is_active`: estado activo o inactivo.
- `sort_order`: orden de visualización.

Relación:

- Many-to-many con proyectos.

### 4.2 Proyectos

Campos:

- `title`: título.
- `slug`: identificador SEO único.
- `description`: descripción.
- `grid_image_path`: imagen para grid.
- `carousel_image_path`: imagen para carrusel.
- `published_at`: fecha de publicación.
- `is_active`: estado activo o inactivo.
- `views_count`: contador de vistas.
- `likes_count`: contador de likes.

Relaciones:

- Many-to-many con servicios.
- One-to-many con bloques.

### 4.3 Bloques

Cada bloque debe incluir:

- `project_id`: proyecto asociado.
- `type`: tipo de contenido.
- `data`: contenido flexible serializado como JSON.
- `sort_order`: orden del bloque.

Los formularios administrativos deben permitir:

- Crear bloques.
- Editar título, subtítulo, contenido e imagen.
- Aplicar formato enriquecido al contenido.
- Reordenar o configurar el orden.
- Eliminar bloques existentes.
- Previsualizar imágenes cargadas.

## 5. Reglas de negocio

- Solo son visibles los proyectos activos y publicados.
- `is_active` debe ser verdadero.
- `published_at` debe ser menor o igual a la fecha actual.
- Los servicios inactivos no deben mostrarse en el frontend.
- El conteo de proyectos por servicio debe considerar proyectos activos.
- Los slugs deben ser únicos.
- Las imágenes deben almacenarse en el disco público mediante rutas relativas.
- Las URLs públicas deben generarse según la configuración del entorno.
- El enlace `public/storage` debe existir para servir imágenes locales.
- Los datos enriquecidos deben sanitizarse antes de renderizarse en el sitio público.

## 6. Modelo de datos

### Entidades

- `users`.
- `services`.
- `projects`.
- `project_service`.
- `project_blocks`.

### Relaciones

```text
users

services 1 --- N project_service N --- 1 projects
projects 1 --- N project_blocks
```

## 7. Arquitectura técnica

- Backend: Laravel.
- PHP: 8.x o superior compatible con el proyecto.
- Base de datos: MySQL.
- Entorno local: Laragon.
- Patrón: MVC con CMS administrativo.
- Frontend: Blade, Tailwind CSS y Alpine.js.
- Interacciones: JavaScript vanilla o Alpine.js.
- Imágenes: Laravel Filesystem con disco `public`.
- Procesamiento de correo: Mailables y Jobs/Queues.

Buenas prácticas:

- Usar PSR-12.
- Utilizar type hints y tipos de retorno en PHP.
- Evitar consultas N+1 mediante eager loading.
- Priorizar servicios reutilizables.
- Mantener el contenido visible en español.
- Conservar una arquitectura preparada para nuevos tipos de bloques.

## 8. Identidad visual

### Marca

IKIGAI proviene de la raíz `xocolatl` y representa mezcla, origen y transformación.

Narrativa principal:

> En IKIGAI transformamos ideas crudas en productos digitales sólidos.

### Estilo

- Dark UI.
- Minimalista.
- Editorial.
- Alto contraste.
- Espacios amplios.
- Layout limpio.
- Enfoque profesional y estratégico.
- Sin elementos decorativos innecesarios.

### Colores

- Fondo principal: negro profundo.
- Componentes y tarjetas: gris carbón.
- Acento: verde ácido/lima o naranja quemado, elegido de forma consistente.

### Tipografía

- Sans-serif moderna.
- Títulos con pesos fuertes.
- Subtítulos semi-bold.
- Texto de cuerpo limpio y legible.
- Sin tipografías decorativas.

## 9. Slogan

**De la idea al producto**

Alternativa:

> Diseñamos, planeamos y construimos productos digitales con intención.
