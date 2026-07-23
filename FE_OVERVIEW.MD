# Modification
If theres modification to the code, update it together with the related files.
If this documentation becomes outdated, update it together with the related files.

# FE Documentation

This document explains the frontend structure under `resources/` so future Developer can understand where UI code lives, how it is organized, and what each important file is used for.

## Purpose

This project currently has two main frontend feature areas:

1. **Surat Wizard**  
   Located in `resources/views/surat`  
   This area is used to create surat through a step-by-step wizard flow.

2. **Master Data Management**  
   Located in `resources/views/master-data`  
   This area is used to manage CRUD pages for master/reference data.

The frontend in this project is mainly built with:

- **Blade** for server-rendered views
- **Alpine.js** for lightweight interactivity
- **Tailwind CSS** for styling
- **Vite** for asset bundling

This document is meant to help future maintainers quickly locate the correct file type and avoid mixing concerns.

## Project note (Laravel + API)
This project is a single Laravel application: the backend and frontend live in the same repository. The frontend is implemented as Blade + Alpine + Vite, but communicates with the backend primarily via the API (routes/api.php). Treat the backend as the canonical source for data and business logic while the frontend is responsible for presentation and interactions.

## Where to check data shapes / structures
When the frontend needs to know request/response shapes, attributes, or relationships, check the API documentation: bruno\CURUG_API_DOC

this documentation is made using bruno, so it is using bruno API collection format.


---

## Main `resources/` basic Structure

```text
resources/
├───css
│       app.css
│       
├───js
│   │   app.js
│   │   bootstrap.js
│   │   
│   ├───components
│   │       login.js
│   │       surat-wizard.js
│   │       
│   ├───composables
│   │       kkLookup.js
│   │       
│   ├───mappers
│   │       kkMapper.js
│   │       pendudukMapper.js
│   │       
│   ├───pages
│   │       kk.js
│   │       penduduk.js
│   │       
│   ├───services
│   │       auth.js
│   │       httpClient.js
│   │       kkApi.js
│   │       pendudukApi.js
│   │       
│   └───utils
│           date.js
│           format.js
│           inputMode.js
│           number.js
│           pagination.js
│           validation.js
│           
└───views
    ├───auth
    │       login.blade.php
    │       
    ├───components
    │   │   
    │   └───form
    │           input.blade.php
    │           select.blade.php
    │           textarea.blade.php
    │           
    ├───layouts
    │       app.blade.php
    │       auth.blade.php
    │       
    ├───master-data
    │   ├───kk
    │   │   │   index.blade.php
    │   │   │   
    │   │   └───partials
    │   │           form.blade.php
    │   │           table.blade.php
    │   │           
    │   └───penduduk
    │       │   index.blade.php
    │       │   
    │       └───partials
    │               
    ├───partials
    │       
    └───surat
        │   index.blade.php
        │   
        └───steps
                isi-data-manual.blade.php
                isi-nik.blade.php
                pilih-jenis-surat.blade.php
                preview-download.blade.php
```

- this structure maybe have not been updated
---

## `resources/views/`

This directory contains **Blade templates**.

### What belongs here
- Full pages
- Layouts
- Partial templates
- Reusable UI components
- Form sections and wizard steps

### Typical usage
Blade files are used for:
- Rendering HTML
- Embedding components with `<x-... />`
- Using Alpine directives like `x-data`, `x-if`, `:class`

---

## Main Feature Areas

### `resources/views/surat/`
This directory contains the pages for the **surat wizard**.

### What it is used for
- Step-by-step surat creation
- Wizard flow screens
- Input collection for surat generation
- UI connected to the surat pengajuan process

### Notes
If a view is part of the surat creation flow, it should usually go here.

---

### `resources/views/master-data/`
This directory contains the pages for **master data CRUD management**.

### What it is used for
- Create, read, update, delete pages
- Reference/master table management
- Admin data maintenance screens

### Subdirectories
Each subdirectory usually represents one managed master data entity.

Example:
- `resources/views/master-data/master-field-surat`  
  Used to manage surat field definitions.

Other folders inside `master-data` should follow the same pattern:
- one folder per master data type
- all CRUD-related views for that data type grouped together

### Notes
If a view is for managing stored reference and CRUD data instead of the surat wizard, it usually belongs here.

---

## Important subdirectories

### `resources/views/components/`
Reusable UI blocks.

**Rule of thumb:**  
If a UI block is reused in more than one page, it should usually live here.

### `resources/views/layouts/`
Base page layouts.

### `resources/views/partials`

Specific fragment layouts
---


## `resources/js/`

This directory contains frontend JavaScript sources.

### What belongs here
- Main JS entry file
- Alpine.js setup
- Global frontend helpers
- Any custom client-side behavior
- Third-party library initialization

### Important file: `resources/js/app.js`

This is the **main frontend entry point**.

### What it is used for
- Bootstrapping Alpine.js
- Registering frontend scripts globally
- Loading CSS into the build pipeline
- Initializing plugins or UI behavior
- Serving as the Vite entry referenced by Blade

### Common responsibilities
- importing the main CSS entry
- initializing Alpine
- attaching custom component logic
- loading libraries used across many pages

### Notes 
When adding frontend behavior, check `resources/js/app.js` before creating new JS files.  
If the behavior is global, it probably belongs there.

---

## `resources/css/`

This directory contains frontend styles.

### What belongs here
- Main Tailwind entry CSS
- Custom utilities
- Global visual overrides
- Project-wide style adjustments

### Important file: `resources/css/app.css`

This is the **main stylesheet entry**.

### What it is used for
- Loading Tailwind directives
- Defining custom CSS layers
- Applying global styles
- Bundling styles through Vite

### Typical content
- `@tailwind base;`
- `@tailwind components;`
- `@tailwind utilities;`
- custom CSS rules if needed

### Notes 
If styling appears across many pages, check `resources/css/app.css` before adding inline styles in Blade.

---

## Frameworks and Tools Used

### Blade
Used for server-rendered frontend views.

### Alpine.js
Used for lightweight UI interaction inside Blade views/components.

### Tailwind CSS
Used for utility-based styling across the UI.

### Vite
Used to compile and serve frontend assets during development and build time.

### JavaScript
Used for:
- Alpine initialization
- shared frontend behavior
- page interaction logic
- integration with external libraries

---

## How the frontend pieces connect

### Blade
Handles structure and server-side rendering.

### Alpine.js
Handles small client-side interactions inside Blade components/views.

### CSS
Handles all styling, usually via Tailwind utilities and a central CSS entry file.

### JS
Handles bootstrapping and any shared frontend behavior.

---

## Practical file selection guide

### Use `resources/views/` when:
- You need to build a page
- You need a reusable component
- You need a layout
- You need to render data from Laravel

### Use `resources/js/` when:
- You need Alpine setup
- You need global JS behavior
- You need frontend event handling
- You need a script shared by many views

### Use `resources/css/` when:
- You need global styling
- You need custom Tailwind extensions
- You need repeated visual rules

---

## Web vs API routes (important for FE/BE integration)

- routes/web.php
  - Used for server-rendered pages (Blade). Typical for pages that are loaded by the browser and rendered on the server.
  - Include layouts and Blade views here (e.g., pages that mount Alpine components).

- routes/api.php
  - Used for JSON endpoints consumed by JavaScript (Alpine fetch/axios) or external clients.
  - Protect endpoints with `auth:sanctum` & role middleware when needed.
  - Example endpoints used by frontend:
    - GET `/api/jenis-surat` -> list surat types
    - POST `/api/pengajuan-surat` -> create surat pengajuan
    - GET `/api/srt-pengajuan-surat/{id}/generate` -> generate/download surat

When implementing frontend calls, prefer calling API routes under `/api/*` using `resources/js/services/*`.

---

## resources/js/ — implementation structure (components / services / utils)

Add a small structure in `resources/js/` to keep JS organized:

Suggested folders:
- resources/js/
  - app.js                -> main entry (imports app.css, initializes Alpine)
  - components/           -> reusable Alpine/interactive components (export functions or register via Alpine.data)
    - stepIndicator.js
    - modal.js
  - services/             -> API wrappers / fetch or axios clients
    - apiClient.js        -> generic fetch wrapper (adds auth token, handles JSON, errors)
    - suratService.js     -> endpoints related to surat (listJenis, createPengajuan, generateSurat)
    - masterDataService.js-> CRUD wrappers for master data resources
  - utils/                -> small helpers
    - formatDate.js
    - download.js         -> helper to download blobs or open files in new tab
  - vendors/              -> optional third-party integrations

Usage patterns:
- app.js should import services when needed and register Alpine components:
  - import './components/stepIndicator'
  - import apiClient from './services/apiClient'
  - window.apiClient = apiClient // if global access needed
- Services should return plain objects / responses; handle errors and status codes centrally in `apiClient`.
- Utilities provide pure functions used by components and services.



Notes:
- Keep DOM-manipulating code inside components.
- Keep fetch / network logic inside services.
- Keep small pure helpers inside utils.

---

## Notes

- **master-data/** = master data CRUD screens

When working on the frontend, prefer:
1. reusable components over duplicated markup
2. global JS setup in `resources/js/app.js`
3. global styling in `resources/css/app.css`
4. Blade views only for page-specific structure


- If theres modification to the code, update it together with the related files.
- If this documentation becomes outdated, update it together with the related files.
