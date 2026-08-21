# Contexto de Proyecto: XOKOL (Portfolio Oficial & CMS)

## 1. Visión General
**XOKOL** es un sitio web corporativo administrable y portfolio profesional de un **AI Engineer & Fullstack Developer**. 
Permite presentar áreas de especialidad (servicios), exhibir proyectos/casos de estudio dinámicos con layouts flexibles mediante bloques, capturar leads mediante formularios de contacto e incluir un panel de administración (CMS) autenticado.

---

## 2. Stack y Arquitectura Téchnica
* **Framework Backend:** Laravel (PHP 8.x)
* **Base de Datos:** MySQL (Servidor local Laragon / Entorno `.test`)
* **Patrón de Arquitectura:** MVC + CMS / Admin Panel
* **Frontend:** Dark UI, CSS utility-first (Tailwind CSS recomendado), JavaScript vanilla/Alpine.js para interacción dinámica sin recarga de página.

---

## 3. Modelo de Datos (ERD) & Entidades

### `users`
* `id` (PK)
* `name`, `email` (unique), `password`
* `timestamps`

### `services`
* `id` (PK)
* `name`, `slug` (unique), `description` (text), `icon` (string)
* `is_active` (boolean, default true), `sort_order` (integer, default 0)
* `timestamps`

### `projects`
* `id` (PK)
* `title`, `slug` (unique), `description` (text)
* `grid_image_path` (nullable), `carousel_image_path` (nullable)
* `published_at` (datetime, nullable), `is_active` (boolean, default true)
* `views_count` (unsigned int, default 0), `likes_count` (unsigned int, default 0)
* `timestamps`

### `project_service` (Pivot Table)
* `id` (PK)
* `project_id` (FK -> `projects.id`, onDelete cascade)
* `service_id` (FK -> `services.id`, onDelete cascade)
* `timestamps`
* *Constraint:* Unique(`project_id`, `service_id`)

### `project_blocks` (Page Builder Dinámico)
* `id` (PK)
* `project_id` (FK -> `projects.id`, onDelete cascade)
* `type` (varchar: `heading`, `rich_text`, `image`)
* `data` (text/json serializado)
  * `heading`: `{"text": "..."}`
  * `rich_text`: `{"html": "<p>...</p>"}`
  * `image`: `{"url": "/storage/...", "alt": "..."}`
* `sort_order` (integer, default 0)
* `timestamps`

---

## 4. Reglas Principales de Negocio

1. **Visibilidad:** Solo se deben renderizar en el sitio público los proyectos que estén activos (`is_active = true`) y cuya fecha de publicación sea menor o igual a la actual (`published_at <= now()`).
2. **Conteo Dinámico de Proyectos por Servicio:** En la lista de servicios se debe calcular la cantidad de proyectos asociados considerando **únicamente** los proyectos activos y publicados (`withCount`).
3. **Métricas en Cliente (Views y Likes):**
   * El conteo de vistas y likes se controla mediante `localStorage` en el navegador para evitar duplicados locales.
   * El backend solo incrementa el contador cuando el frontend lo solicita explícitamente vía API/Controller. No se persisten logs individuales por usuario.
4. **Formulario de Contacto:**
   * **No persiste en BD.** Realiza validación en backend y procesa el envío vía email mediante Mailables/Queues.
5. **Filtrado en Grid de Proyectos:** El filtro por servicio en la vista principal debe realizarse de forma dinámica asíncrona (Fetch/AJAX) sin recargar la página.

---

## 5. Guía de Estilo & UI/UX

* **Estética:** Dark UI Minimalista, estilo editorial con alto contraste y espacios amplios.
* **Colores:**
  * Fondo Principal: Negro profundo (`#0A0A0A` / `#000000`)
  * Tarjetas / Componentes: Gris carbón (`#171717` / `#1E1E1E`)
  * Acento: Naranja quemado o Verde ácido / Lima
* **Tipografía:** Sans-serif moderna, títulos en pesos fuertes (`font-bold` / `font-extrabold`), body legible.

---

## 6. Instrucciones de Generación de Código para Copilot
* Escribe código limpio, moderno y siguiendo las convenciones oficiales de **Laravel (PSR-12)**.
* Asegura el uso de **Type Hinting** y tipos de retorno explícitos en PHP.
* Prioriza la reutilización de componentes y la optimización de consultas SQL (evita el problema N+1 usando Eager Loading `with()`).
* Mantén el contenido textual en **Español**.