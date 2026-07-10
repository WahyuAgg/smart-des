# Init
If theres modification to the code, update it together with the related files.
If this documentation becomes outdated, update it together with the related files.

# BE Documentation

This document explains the backend structure and how it interfaces with the frontend in this project. Keep it concise for future maintainers and AI agents.

## Purpose
Describe controllers, models, API endpoints, routes, auth, validation, and common conventions used when the frontend (Blade + Alpine + Vite) interacts with the backend.

---

## Directory / Code Layout (high level)
- app/
  - Http/
    - Controllers/
      - Api/            -> API controllers (JSON responses)
      - Web/ or root   -> Controllers that return Blade views (if any)
    - Requests/        -> FormRequest validation classes
    - Resources/       -> API Resource transformers (optional)
  - Models/            -> Eloquent models (business entities)
- database/
  - migrations/
  - seeders/
- routes/
  - api.php            -> JSON API routes (consumed by SPA, JS, mobile)
  - web.php            -> Blade routes (server-rendered pages)

---

## Controllers
- API controllers live in `App\Http\Controllers\Api`.
- Use `Route::apiResource()` for standard CRUD endpoints.
- Controller responsibilities:
  - Validate input (prefer FormRequest)
  - Use Models / Services to perform actions
  - Return JSON responses (use `JsonResource` / `ResourceCollection` when appropriate)
  - Return appropriate HTTP codes (200, 201, 422, 404, 500)

Example conventions:
- index() -> return list (paginated)
- show($id) -> return single item
- store(Request) -> validate & create, return 201 with resource
- update(Request,$id) -> validate & update, return 200 with resource
- destroy($id) -> delete, return 204

---

## Models
- Eloquent models in `App\Models`.
- Relationships, casts, and fillable/guarded attributes live here.
- Use query scopes for reusable queries (e.g., scopeActive()).

---

## Routes
- routes/api.php
  - JSON endpoints consumed by JS or external clients.
  - Protected routes use `auth:sanctum` and additional role middleware (example: admin|petugas|kepala_desa).
  - Example from project:
    - `Route::apiResource('srt-pengajuan-surat', SrtPengajuanSuratController::class)`
    - `Route::get('/srt-pengajuan-surat/{id}/generate', ...)` — generate surat endpoint returning file/url or binary.
- routes/web.php
  - Blade-rendered pages (if present). Use for server-side pages that render views.

Best practice:
- Keep API routes stateless and JSON-only.
- Use web routes for pages that need server-rendered HTML.

---

## Auth & Security
- Sanctum is used for token/session authentication for API routes.
- Apply `auth:sanctum` middleware to restrict endpoints.
- Use role-based middleware (`role:...`) for authorization.
- Validate all inputs via FormRequest classes.
- Sanitize file uploads and store with storage disk (use signed URLs if necessary).

---

## Request Validation & Resources
- Use FormRequest classes in `app/Http/Requests` to encapsulate validation rules and authorize() checks.
- Use `App\Http\Resources\*` to shape JSON responses — keeps frontend contract stable.

---

## Common API Patterns (communication with FE)
- Frontend expects predictable JSON:
  - Success: { "data": {...}, "meta": {...} } or Resource-wrapped data.
  - Error (validation): HTTP 422 with { "message": "...", "errors": { field: [..] } }
- For file download/generation endpoints (e.g., surat generate), return either:
  - A presigned URL to file storage (200 with { url: "..." })
  - Or a streamed response with appropriate headers (Content-Type, Content-Disposition)
- Pagination: use Laravel pagination and return meta (current_page, last_page, per_page, total).
- Consistent status codes: 201 for created, 204 for deleted, 404 for not found.

---

## Important Backend Files to Check / Edit
- routes/api.php — main API surface; define apiResource routes and custom endpoints.
- app/Http/Controllers/Api/* — controller implementations.
- app/Models/* — data models.
- app/Http/Requests/* — validation rules.
- app/Http/Resources/* — API resources for consistent JSON output.
- config/auth.php / config/sanctum.php — auth configuration.

---

## Tips for Frontend-Backend Integration
- Document endpoint contracts near controllers (brief comment with request/response shape).
- Use service classes for heavy business logic and keep controllers thin.
- When changing response shape, update FE_DOCUMENTATION.md and inform frontend implementers.
- Add versioning to API routes if breaking changes are expected (e.g., /api/v1/...).

---

## Troubleshooting
- CORS issues: check `config/cors.php`.
- Auth issues: verify Sanctum cookie/session config and SPA domain settings.
- Validation errors: use `->validate()` in controllers or FormRequest and inspect 422 payload format.

---

## Quick Example — surat generate flow
1. FE calls: GET /api/srt-pengajuan-surat/{id}/generate (authenticated)
2. BE:
   - Validate permissions (role/ownership)
   - Build document (template + DB values)
   - Store file and return URL or stream file
3. FE:
   - On URL: download or open in new tab
   - On streamed binary: handle via blob download

## Cross-reference / When to consult frontend docs

When you need frontend context during backend analysis or modification (which Blade views consume an endpoint, expected UI behavior, JS services, or component usage), consult FE_DOCUMENTATION.MD (`FE_DOCUMENTATION.MD`). Update BE_DOCUMENTATION.MD if backend changes require frontend updates, and coordinate changes with the frontend documentation to keep both in sync.

# Note
If theres modification to the code, update it together with the related files.
If this documentation becomes outdated, update it together with the related files.
