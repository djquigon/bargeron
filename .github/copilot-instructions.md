# Copilot / AI Agent Instructions — M&R master theme

This file contains concise, project-specific guidance to help AI coding agents be immediately productive.

Overview

- This repository is a WordPress theme used by M&R Marketing. The primary code lives in `wp-content/themes/mrmastertheme`.
- Key responsibilities: PHP templates (ACF-driven), SCSS (Gulp-built), and frontend JS split into header/footer bundles.

Architecture highlights

- Modules: ACF flexible content field `modules` is the primary content model. The module router is `views/global/modules/modules.php` and individual module templates live in `views/global/modules/<module-name>/`.
- Data-driven CSS: Module and row settings are encoded in hidden `<span>` elements (examples: `module-settings`, `row-settings`, `validator-text`) and the CSS relies on `:has()` selectors and data-attributes. Do not remove or restructure these spans.
- SCSS & build: `style.scss` is the main entry. SCSS sources live under `library/custom-theme/scss/`, `library/vendor/scss/` and `views/**/**/*.scss`. Gulp compiles `style.css` at the theme root.
- JS bundles: Header and footer scripts are combined into `header.min.js` and `footer.min.js` via `gulpfile.js`. Module-specific JS should go in `views/**/**/modules/**/assets/js/`.

Developer workflows (how to build/run locally)

- Theme folder: `wp-content/themes/mrmastertheme`
- Install deps: run `npm install` from the theme folder (this project uses Gulp + Node devDependencies declared in `package.json`).
- Common tasks:
    - Start file watcher (recommended): `npx gulp` (runs the default `watch` task)
    - Build JS once: `npx gulp js`
    - Build SASS once: `npx gulp sass`

Project-specific conventions

- ACF layouts: Use the exact layout names seen in `views/global/modules/modules.php` (e.g., `standard_content`, `callout`, `faqs`, `media_gallery`, `video_cards`, `video_full_width`).
- ACF helpers: Templates use `get_field()` / `get_sub_field()` for ACF. Follow existing pattern — set variables at the top and then output HTML.
- Semantic HTML: Modules should avoid `<h1>` (page title reserved). Start module headings at `<h2>`.
- Inline color variables: Text color custom properties are set inline on column elements (e.g., `style="--headings-color:#fff;"`). Prefer using these over global class changes.
- Do NOT hardcode layout-related pixels: use the data-attribute driven system and SCSS variables (`$global_*`).

Files & locations to inspect for context

- Module router: `views/global/modules/modules.php`
- Example module: `views/global/modules/standard-content/standard-content.php`
- Gulp build: `wp-content/themes/mrmastertheme/gulpfile.js`
- SCSS entry: `wp-content/themes/mrmastertheme/style.scss`
- Theme scripts: `wp-content/themes/mrmastertheme/library/custom-theme/js/`

Integration notes & gotchas

- Some vendor or third-party module code is intentionally excluded from the main watch/compile paths (see `gulpfile.js` exclusions for `views/conditional/pages/locations-page/modules/**`). Avoid editing vendor subfolders unless you know how their build pipeline differs.
- The project uses a tiny MCP/REST workflow (see AGENTS.md) for ACF population — when modifying or adding modules via API: always read the existing `modules` array, modify or append, then write back the full array (writing replaces the whole flexible content field).
- Images in WYSIWYG: you may use `<img src="URL">` in WYSIWYG HTML, but ACF image fields require WordPress attachment IDs when writing via the API.

Behavior for AI agents

- Read before write: when modifying ACF `modules`, fetch the current value first; do not overwrite blindly.
- Preserve data-attribute spans and `validator-text` nodes — CSS depends on them.
- Keep changes minimal and consistent with existing PHP/SCSS style. Prefer small surgical edits and mirror surrounding conventions.

If you need more

- If anything is unclear about an individual module, point to the specific file (path + short snippet) and ask — include the `modules.php` layout name you intend to modify.

Thanks — please review and tell me any unclear or missing items to iterate.
