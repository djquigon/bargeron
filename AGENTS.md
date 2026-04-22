# AGENTS.md — M&R WordPress Theme AI Agent Instructions

## Overview

This repository contains M&R Marketing's custom WordPress theme, built on ACF (Advanced Custom Fields) Pro with a modular, flexible content architecture. AI agents working in this codebase should understand the module system, the data-attribute-driven CSS architecture, and the ACF field structure before making changes.

---

## Theme Architecture

### Stack
- WordPress (6.9+)
- ACF Pro (Flexible Content layouts)
- PHP templates (one per module)
- SCSS compiled via Gulp (autoprefixer, pxtorem, minification)
- jQuery, Slick slider, Magnific Popup

### Directory Structure
```
theme-root/
├── style.scss                          # Main SCSS entry point
├── style.css                           # Compiled output
├── gulpfile.js                         # Build pipeline
├── page.php                            # Default page template
├── header.php / footer.php
├── acf-json/                           # ACF field group JSON exports
│   └── group_5e0685a20e447.json        # "Modules" field group
├── library/
│   ├── custom-theme/
│   │   ├── scss/
│   │   │   └── variables/
│   │   │       ├── _breakpoints.scss
│   │   │       ├── _spacing.scss
│   │   │       └── _widths.scss
│   │   ├── js/
│   │   │   ├── header-scripts.js
│   │   │   └── footer-scripts.js
│   │   └── images/
│   └── vendor/
│       ├── scss/
│       │   ├── _column-system.scss
│       │   ├── _container-system.scss
│       │   ├── _padding-system.scss
│       │   └── _flex-system.scss
│       └── js/
└── views/
    └── global/
        ├── modules/
        │   ├── modules.php             # Module router
        │   ├── shared-background/
        │   │   ├── background-start.php
        │   │   ├── background-end.php
        │   │   └── assets/scss/_shared-background.scss
        │   ├── standard-content/
        │   │   ├── standard-content.php
        │   │   └── layout-options/
        │   │       ├── one-column.php
        │   │       ├── two-column.php
        │   │       ├── three-column.php
        │   │       └── four-column.php
        │   ├── blog-post-list/
        │   ├── callout/
        │   ├── faqs/
        │   ├── full-width-two-columns/
        │   ├── gallery-list/
        │   ├── history-timeline/
        │   ├── locations-map-cards/
        │   ├── locations-search-form/
        │   ├── media-gallery/
        │   ├── project-list/
        │   ├── team-members/
        │   ├── testimonials/
        │   ├── video-cards/
        │   └── video-full-width/
        ├── header/
        ├── footer/
        └── widgets/
```

---

## Module System

### How It Works
1. Pages use ACF flexible content field called `modules` (key: `field_5e0685a213305`)
2. Most modules are flexible content layouts with content/settings controls; some structural layouts are intentionally minimal
3. `modules.php` loops through layouts and includes the corresponding PHP template
4. PHP templates read ACF data via `get_sub_field()` and output semantic HTML
5. CSS uses `:has()` selectors on data-attribute spans to apply styles

### Available Modules

| `acf_fc_layout` value | Label | PHP class | Primary Use |
|---|---|---|---|
| `background_start` | Background Start | `.shared-background` | Opens a shared wrapper around subsequent modules |
| `background_end` | Background End | `.shared-background` | Closes the current shared wrapper |
| `standard_content` | Standard Content | `.standard-content` | General content with 1–4 column rows |
| `callout` | Callout | `.callout` | Centered CTA / highlight sections |
| `faqs` | FAQs | `.faqs` | Accordion or card-based Q&A |
| `full_width_two_columns` | Full-Width: 2 Columns | `.full-width-two-columns` | Edge-to-edge split layouts |
| `blog_post_list` | Blog Post List | `.blog-post-list` | Latest/featured blog posts |
| `gallery_list` | Gallery List | `.gallery-list` | List of gallery CPT entries |
| `history_timeline` | History Timeline | `.history-timeline` | Era → date nested timeline |
| `locations_map_cards` | Locations – Map & Cards | `.locations-map-cards` | Map + location cards |
| `locations_search_form` | Locations – Search Form | `.locations-search-form` | Proximity location search |
| `media_gallery` | Media Gallery | `.media-gallery` | Image/video galleries (carousel or masonry) |
| `project_list` | Project List | `.project-list` | List of project CPT entries |
| `team_members` | Team Members | `.team-members` | Staff grid or slider |
| `testimonials` | Testimonials | `.testimonials` | Customer reviews (carousel or columns) |
| `video_full_width` | Video – Full Width | `.video-full-width` | Single featured video |
| `video_cards` | Video – Cards | `.video-cards` | Video grid |

---

## Shared Background Wrapper

### Purpose
- `background_start` and `background_end` allow multiple consecutive modules to render inside one shared `<div class="shared-background">` wrapper
- Use this when several modules should visually share one outer background shell while still preserving their own internal module structure

### Implementation
- The ACF layout names remain `background_start` and `background_end`
- Their PHP templates live in `views/global/modules/shared-background/`
- `modules.php` tracks whether the wrapper is open and auto-closes any open shared wrapper at the end of the loop
- `background_start` opens the wrapper and now supports:
  - `unique_identifiers`
  - `background`
- `background_end` is a structural closing marker

### CSS Implications
- The theme's structural SCSS uses broad `:has()` selectors such as `main > div` and `article > div`
- Once modules are wrapped inside `.shared-background`, those selectors can accidentally apply child module padding/background behavior to the wrapper itself
- The fix pattern used in this repo is:
  - keep `.shared-background` structurally neutral
  - explicitly override wrapper-level inherited padding/background behavior
  - explicitly restore expected structural behavior on `div.shared-background > section`, `> aside`, and `> div`
- Prefer selector-based exceptions over `!important`
- Shared wrapper-specific SCSS belongs in `views/global/modules/shared-background/assets/scss/_shared-background.scss`

### Template Notes
- `background-start.php` supports wrapper IDs/classes and wrapper-level background output through the same hidden settings-span pattern used by other modules
- Wrapper background settings apply to the shared parent, not to the nested modules inside it

---

## HTML Output Pattern

PHP templates output semantic HTML with hidden `<span>` elements that carry data attributes. CSS reads these via `:has()` selectors. **Do not remove or restructure these spans.**

### Module-Level Pattern
```html
<section class="standard-content optional-class" id="optional-id">
  <!-- content rows here -->
  
  <span class="module-settings" data-nosnippet>
    <span class="padding" 
      data-top-padding-desktop="double" 
      data-bottom-padding-desktop="double" 
      data-top-padding-mobile="single" 
      data-bottom-padding-mobile="single">
      <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
    <span class="background" style="background-color:#1a3d5c">
      <span class="validator-text" data-nosnippet>background settings</span>
    </span>
    <span class="validator-text">module settings</span>
  </span>
</section>
```

### Row-Level Pattern (Standard Content)
```html
<div class="content-row">
  <div class="columns" data-mobile-reverse-order="true">
    <div class="column left one-third" style="--headings-color:#fff;">
      <!-- wysiwyg content -->
    </div>
    <div class="column right two-thirds" style="--headings-color:#fff;">
      <!-- wysiwyg content -->
    </div>
  </div>
  <span class="row-settings" 
    data-column-count="two" 
    data-column-width="variable" 
    data-container-width="standard">
    <span class="validator-text" data-nosnippet>row settings</span>
  </span>
</div>
```

---

## CSS Architecture

### Key Principles
- **Data-attribute driven:** Layout behavior is controlled by data attributes on span elements, not by adding/removing CSS classes in stylesheets
- **`:has()` selectors:** The CSS system uses parent `:has()` selectors to read child span data attributes and apply styles to the parent
- **No utility classes for layout:** Column widths, padding, and backgrounds are all driven by the data-attribute system
- **CSS custom properties for text colors:** `--headings-color`, `--body-text-color`, `--link-color`, `--link-hover-color` are set as inline styles on column elements

### SCSS Variables

**Spacing:**
- `$global_module_padding_double`: 64px
- `$global_module_padding_single`: 32px
- `$global_gap_between_columns`: 24px (small)
- `$global_gap_between_columns_medium`: 48px
- `$global_gap_between_columns_large`: 64px
- `$global_margin_between_content_rows`: 48px

**Container Widths:**
- `$global_container_width_slim`: 1000px
- `$global_container_width_standard`: 1200px
- `$global_container_width_wide`: 1350px
- `$global_container_width_widest`: 100%

**Key Breakpoints:**
- Tablet landscape: `em(1025)` (64.0625em)
- Tablet portrait: `em(769)` (48.0625em)
- Mobile large: `em(431)` (26.9375em)
- Responsive container padding kicks in at `$breakpoint_laptop_large`: `em(1441)` (90.0625em)

### Child Theme CSS
Client-specific styles go in a child theme. Child themes override:
- Font families and sizes
- Brand colors (headings, body text, links, buttons)
- Button styles (gradients, border-radius, hover states)
- Module-specific visual treatments (callout typography, testimonial cards, etc.)
- Gravity Forms styling
- Header/footer styling

---

## Common Settings (Most Modules)

Most content modules have these settings fields. Use these defaults unless explicitly told otherwise:

| Field | Default | Options |
|---|---|---|
| `tag_type` | `section` | `section`, `aside`, `div` |
| `unique_identifiers.id` | empty | any string |
| `unique_identifiers.class_names` | empty | space-separated classes |
| `padding.top_padding_desktop` | `double` | `double`, `single`, `none` |
| `padding.bottom_padding_desktop` | `double` | `double`, `single`, `none` |
| `padding.top_padding_mobile` | `single` | `double`, `single`, `none` |
| `padding.bottom_padding_mobile` | `single` | `double`, `single`, `none` |
| `background.background_type` | `transparent` | `transparent`, `color`, `image` |
| `text_color.*` | empty (theme defaults) | hex color values |

**Callout exception:** Uses `module_background`/`module_padding` instead of `background`/`padding`, and has additional `container_background`/`container_padding` groups.

**Shared background exception:**
- `background_start` supports `unique_identifiers` and `background`
- `background_start` does not use `tag_type` or padding controls
- `background_end` is a structural closing marker and has no configurable settings

---

## Complete Module Field Schemas

For per-module JSON payload templates with all field names and valid values, see `CLAUDE.md` — it contains a complete schema for every module type. The notes below cover the non-obvious structural rules.

### Field Types Reference

| ACF Field Type | REST API Representation |
|---|---|
| `text`, `textarea` | String |
| `wysiwyg` | HTML string |
| `true_false` | Boolean |
| `select`, `radio` | String (the choice key, not the label) |
| `image` | Integer (WordPress media attachment ID) |
| `post_object` (single) | Integer (post ID) |
| `post_object` (multiple) | Array of integers |
| `color_picker` | Hex string e.g. `"#1a3d5c"` |
| `group` | Object |
| `repeater` | Array of objects |
| `flexible_content` | Array of objects, each with `acf_fc_layout` |

### Background Field Variants

There are two different background field structures in this theme — do not mix them:

**Standard `background` group** (used on `standard_content`, `faqs`, `blog_post_list`, `media_gallery`, etc.):
```json
{
  "background_type": "transparent | color | image",
  "background_color": "#hex",
  "background_image": null,
  "background_image_position": "center | top | bottom | left | right",
  "include_overlay": false,
  "overlay_color": ""
}
```

**Callout `module_background` / `container_background` group** (same structure as above, different field name):
The callout module uses `module_background` for the full-bleed outer section and `container_background` for the inner content box. Both share the same structure above.

**Shared background `background_start.background` group**:
Uses the same structure as the standard `background` group and applies to the shared wrapper itself rather than to an individual nested content module.

**`full_width_two_columns` column `content_background` group** (boolean-based, different from above):
```json
{
  "background_type": false,
  "background_image": null,
  "background_image_overlay": "rgba(0,0,0,.7)",
  "background_color": "#hex"
}
```
Here `background_type` is a **boolean**: `false` = color mode (reads `background_color`), `true` = image mode (reads `background_image`). There is no "transparent" option for column backgrounds.

### `standard_content` Row Fields

Each row in the `rows` repeater uses these fields. Only populate the content fields that match the chosen `column_count`:

| `column_count` | Content fields to populate |
|---|---|
| `"one"` | `column_content_single` |
| `"two"` | `column_widths`, `column_content_halves_left`, `column_content_halves_right`, `reverse_order_mobile` |
| `"three"` | `column_content_thirds_left`, `column_content_thirds_center`, `column_content_thirds_right` |
| `"four"` | `column_content_fourths_one`, `column_content_fourths_two`, `column_content_fourths_three`, `column_content_fourths_four` |

`column_widths.dual_column_width_selection`: `false` = equal halves (`one-half` / `one-half`); `"variable"` = use `left_column_width` and `right_column_width`.

Valid width values: `"one-half"` | `"one-third"` | `"two-thirds"` | `"one-quarter"` | `"three-quarters"` | `"two-fifths"` | `"three-fifths"`

`include_lr_padding` only has effect when `container_width` is `"widest"`.

### Custom Post Type IDs

These modules reference custom post types by ID (integer). Look up real IDs via the REST API before writing:
- `locations_map_cards.locations` → `mandr_location` post IDs
- `team_members.team_members` → `mandr_team_member` post IDs
- `gallery_list` featured/list fields → `mandr_gallery` post IDs
- `project_list` featured/list fields → `mandr_project` post IDs
- `locations_search_form.all_locations_page` → `page` post ID

---

## ACF Population via MCP

This site has the `wordpress-mcp` plugin installed with REST API CRUD tools enabled. AI agents can create pages and populate ACF fields through the MCP connection.

### Codex MCP Setup

When a developer wants Codex to connect to a local WordPress site via MCP, use the repo templates in `conf/codex/wordpress-mcp/` instead of inventing a new setup each time.

Required workflow:
- Ask the developer for a fresh JWT token.
- Save the token into `%USERPROFILE%\.codex\scripts\<site>.jwt`.
- Use `conf/codex/wordpress-mcp/start-wordpress-mcp.local-site.ps1.example` as the launcher template.
- Use `conf/codex/wordpress-mcp/wordpress-mcp-stdio-wrapper.js` as the stdio bridge template.
- Replace the placeholder site slug and local URLs in the PowerShell launcher.
- Point the developer's Codex MCP config at the generated launcher script.
- Verify the setup by listing 10 pages through MCP before doing content edits.

Rules:
- Do not commit real JWT tokens into the repo.
- Do not rely on `npx @automattic/mcp-wordpress-remote@latest` as the default long-term setup.
- Prefer a launcher that probes both HTTP and HTTPS for the local site and selects the working MCP endpoint automatically.
- If MCP initialization is strict about `clientInfo`, use the provided stdio wrapper template to normalize the initialize payload.

### Current Local Setup Notes
- `.mcp.json` should point to a machine-local PowerShell launcher, not to a committed JWT or a direct `npx` command
- Expected machine-local files:
  - `%USERPROFILE%\.codex\scripts\mr-master-theme-2024.jwt`
  - `%USERPROFILE%\.codex\scripts\start-wordpress-mcp-mr-master-theme-2024.ps1`
  - `%USERPROFILE%\.codex\scripts\wordpress-mcp-stdio-wrapper.js`
- For this site, the launcher may find HTTP is more reliable than HTTPS for MCP health checks because of local SSL behavior
- Verify MCP through the launcher path before doing content edits
- When editing ACF flexible content through MCP, always read the page first and then write the full `acf.modules` array back

### Key Rules
1. **Always read existing modules before writing** — flexible content is stored as a single field. Writing replaces the entire value. To append a module, read the current array, add to it, and write back the full array.
2. **Use layout names exactly** — `standard_content`, `callout`, `faqs`, `full_width_two_columns`, `media_gallery`, `testimonials`, `video_cards`, `video_full_width`
3. **Respect conditional fields** — Only populate fields that are relevant to the selected options (e.g., don't populate `column_content_halves_left` when `column_count` is `one`)
4. **WYSIWYG fields accept HTML** — Use proper HTML tags: `<h2>`, `<h3>`, `<p>`, `<a href="" class="button">`, `<img>`, `<ul>`, `<ol>`
5. **Images in wysiwyg fields** — Use `<img src="URL">` directly. For ACF image fields (backgrounds, gallery), you need WordPress media library attachment IDs.
6. **Heading hierarchy** — Avoid `<h1>` in module content (reserved for page title). Start with `<h2>` for section headings.

### Population Example
To create a page with two modules:

**Step 1:** Create a page (POST to `/wp/v2/pages`) with title and draft status.

**Step 2:** Update the page's `modules` field with an array containing both layouts:
```json
{
  "modules": [
    {
      "acf_fc_layout": "standard_content",
      "rows": [
        {
          "container_width": "standard",
          "column_count": "one",
          "column_content_single": "<h2>Welcome</h2><p>Hello world.</p>"
        }
      ],
      "tag_type": "section",
      "padding": {
        "top_padding_desktop": "double",
        "bottom_padding_desktop": "double",
        "top_padding_mobile": "single",
        "bottom_padding_mobile": "single"
      },
      "background": {
        "background_type": "transparent"
      }
    },
    {
      "acf_fc_layout": "callout",
      "content": "<h2>Get in Touch</h2><p>We would love to hear from you.</p>",
      "tag_type": "section",
      "container_width": "slim",
      "module_background": {
        "background_type": "color",
        "background_color": "#1a3d5c"
      },
      "module_padding": {
        "top_padding_desktop": "double",
        "bottom_padding_desktop": "double",
        "top_padding_mobile": "single",
        "bottom_padding_mobile": "single"
      },
      "text_color": {
        "headings_color": "#ffffff",
        "body_text_color": "#ffffff"
      }
    }
  ]
}
```

---

## Coding Conventions

### PHP
- Use `get_sub_field()` and `get_field()` for ACF data (never access `$_POST` or `wp_postmeta` directly)
- Template parts are loaded via `get_template_part()` with `$args` array for passing data
- Variables are declared at the top of each template file before any HTML output
- Conditional HTML is handled with PHP alternative syntax (`if/endif`, `foreach/endforeach`)

### SCSS
- All variables are prefixed with `$global_`
- Breakpoints use an `em()` function for conversion
- Module-specific SCSS lives in the module's directory: `views/global/modules/[module-name]/assets/scss/`
- Never write raw pixel values for layout — use the variable system
- Child theme overrides target module class names (`.standard-content`, `.callout`, `.faqs`, etc.)

### HTML
- Semantic tags: `<section>` for content with headings, `<aside>` or `<div>` for content without
- All settings/configuration spans must include `<span class="validator-text" data-nosnippet>` for accessibility
- Column classes: `.column`, `.left`, `.right`, `.center`, `.one-third`, `.two-thirds`, etc.
- Data attributes on spans control layout — never hardcode widths or padding in inline styles (except CSS custom properties for text colors)

### JavaScript
- jQuery is available globally
- Scripts are split: header (jQuery + vendor) and footer (custom + module JS)
- Module-specific JS lives in `views/global/modules/[module-name]/assets/js/`
- Compiled via Gulp with Babel for browser compatibility

---

## Handoff Notes

- The shared background solution is now a first-class structural pattern in this theme
- Use `background_start` / `background_end` for grouped module wrappers instead of inventing ad hoc parent containers in templates
- `background_start` now supports:
  - `unique_identifiers`
  - `background`
- The wrapper template lives at `views/global/modules/shared-background/background-start.php`
- The wrapper SCSS exceptions live at `views/global/modules/shared-background/assets/scss/_shared-background.scss`
- If the ACF JSON changes, re-import or sync the field group in wp-admin before testing
- When handing this repo to another developer, assume the authoritative layout list is the current ACF JSON, not an older hard-coded module count
- Any future wrapper-style features should follow the same rule:
  - keep wrapper elements inert
  - restore behavior on intended child modules with selector-aware exceptions

---

## What AI Agents Should NOT Do

- Do not modify the parent theme's SCSS variable files or layout system files
- Do not restructure the data-attribute span pattern in PHP templates
- Do not remove `validator-text` spans or `data-nosnippet` attributes
- Do not use `<h1>` tags in module content
- Do not hardcode pixel values for padding, gaps, or container widths — use the variable/data-attribute system
- Do not overwrite existing ACF modules without reading them first
- Do not create new module types without explicit instruction — use the existing 8 types
