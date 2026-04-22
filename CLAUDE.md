# CLAUDE.md — M&R WordPress Theme Quick Reference

This is the M&R Marketing custom WordPress theme. Pages are built with ACF Pro flexible content modules. A `wordpress-mcp` plugin exposes REST API tools for reading and writing pages and ACF fields. Full architecture documentation is in `AGENTS.md`.

**Theme path:** `wp-content/themes/mrmastertheme/`
**Module router:** `views/global/modules/modules.php`
**ACF field JSON:** `acf-json/group_5e0685a20e447.json`

---

## All Available Modules

| `acf_fc_layout` value | Label | PHP class on element |
|---|---|---|
| `standard_content` | Standard Content | `.standard-content` |
| `callout` | Callout | `.callout` |
| `faqs` | FAQs | `.faqs` |
| `full_width_two_columns` | Full-Width: 2 Columns | `.full-width-two-columns` |
| `blog_post_list` | Blog Post List | `.blog-post-list` |
| `gallery_list` | Gallery List | `.gallery-list` |
| `history_timeline` | History Timeline | `.history-timeline` |
| `locations_map_cards` | Locations – Map & Cards | `.locations-map-cards` |
| `locations_search_form` | Locations – Search Form | `.locations-search-form` |
| `media_gallery` | Media Gallery | `.media-gallery` |
| `project_list` | Project List | `.project-list` |
| `team_members` | Team Members | `.team-members` |
| `testimonials` | Testimonials | `.testimonials` |
| `video_full_width` | Video – Full Width | `.video-full-width` |
| `video_cards` | Video – Cards | `.video-cards` |

---

## Critical Rules for MCP Writes

1. **Always read the page before writing.** ACF flexible content is stored as a single field. Writing replaces the entire array. Read current modules → append or edit → write the full array back.
2. **Use `acf_fc_layout` on every module object** — this is how ACF identifies the layout type.
3. **Do not populate conditional fields that don't apply** — e.g. don't send `column_content_halves_left` when `column_count` is `"one"`.
4. **Image fields in ACF groups/repeaters expect WordPress media attachment IDs** (integers). WYSIWYG fields accept raw `<img src="URL">` HTML.
5. **Do not use `<h1>` in module content** — reserved for the page title area.
6. **WYSIWYG fields accept HTML** — use `<h2>`–`<h6>`, `<p>`, `<ul>`, `<ol>`, `<a href="" class="button">`, `<img>`.

---

## Shared Field Reference

These fields appear on nearly every module. Defaults shown.

### `padding` (or `module_padding`)
```json
{
  "top_padding_desktop":    "double",
  "bottom_padding_desktop": "double",
  "top_padding_mobile":     "single",
  "bottom_padding_mobile":  "single"
}
```
Valid values: `"double"` | `"single"` | `"none"`

### `background` (or `module_background`)
```json
{
  "background_type":           "transparent",
  "background_color":          "",
  "background_image":          null,
  "background_image_position": "center",
  "include_overlay":           false,
  "overlay_color":             ""
}
```
`background_type` values: `"transparent"` | `"color"` | `"image"`

### `text_color`
```json
{ "headings_color": "", "body_text_color": "", "link_color": "", "link_hover_color": "" }
```
Leave all empty to inherit theme defaults. Values are hex strings.

### `unique_identifiers`
```json
{ "id": "", "class_names": "" }
```

### `tag_type`
`"section"` (default) | `"aside"` | `"div"`

### `container_width`
`"slim"` (1000px) | `"standard"` (1200px) | `"wide"` (1350px) | `"widest"` (100%)

---

## Module Field Schemas

### `standard_content`
```json
{
  "acf_fc_layout": "standard_content",
  "rows": [
    {
      "container_width": "standard",
      "include_lr_padding": false,
      "column_count": "one",

      "column_content_single": "<p>HTML — used when column_count is one</p>",

      "column_widths": {
        "dual_column_width_selection": "variable",
        "left_column_width":  "one-half",
        "right_column_width": "one-half"
      },
      "column_content_halves_left":  "<p>Used when column_count is two</p>",
      "column_content_halves_right": "<p>Used when column_count is two</p>",
      "reverse_order_mobile": false,

      "column_content_thirds_left":   "<p>Used when column_count is three</p>",
      "column_content_thirds_center": "<p>Used when column_count is three</p>",
      "column_content_thirds_right":  "<p>Used when column_count is three</p>",

      "column_content_fourths_one":   "<p>Used when column_count is four</p>",
      "column_content_fourths_two":   "<p>Used when column_count is four</p>",
      "column_content_fourths_three": "<p>Used when column_count is four</p>",
      "column_content_fourths_four":  "<p>Used when column_count is four</p>"
    }
  ],
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`column_count` options: `"one"` | `"two"` | `"three"` | `"four"`
`column_widths.dual_column_width_selection`: `false` (equal halves) | `"variable"` (use left/right width values)
Left/right width options: `"one-half"` | `"one-third"` | `"two-thirds"` | `"one-quarter"` | `"three-quarters"` | `"two-fifths"` | `"three-fifths"`
`include_lr_padding`: only meaningful when `container_width` is `"widest"`

---

### `callout`
```json
{
  "acf_fc_layout": "callout",
  "content": "<h2>Heading</h2><p>Body copy.</p>",
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" },
  "module_background": { "background_type": "transparent", ... },
  "module_padding": { "top_padding_desktop": "double", ... },
  "container_width": "slim",
  "container_background": { "background_type": "transparent", ... },
  "container_padding": { "top_padding_desktop": "double", ... },
  "text_color": { ... }
}
```
Note: uses `module_background`/`module_padding` (not `background`/`padding`) plus a second layer `container_background`/`container_padding` for the inner content box.

---

### `faqs`
```json
{
  "acf_fc_layout": "faqs",
  "module_title": "Optional section title",
  "faqs": [
    { "question": "Question text", "answer": "<p>Answer HTML</p>" }
  ],
  "all_faqs_button": { "button_text": "", "button_link": "" },
  "layout": "toggles",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`layout` options: `"toggles"` | `"cards"`

---

### `full_width_two_columns`
```json
{
  "acf_fc_layout": "full_width_two_columns",
  "left_column": {
    "width": 50,
    "content_type": "background-image",
    "column_background_image": 1171,
    "column_content": "",
    "content_background": {
      "background_type": false,
      "background_image": null,
      "background_image_overlay": "rgba(0,0,0,.7)",
      "background_color": ""
    }
  },
  "right_column": {
    "width": 50,
    "content_type": "content",
    "column_background_image": null,
    "column_content": "<h2>Heading</h2><p>Copy.</p>",
    "content_background": {
      "background_type": false,
      "background_image": null,
      "background_image_overlay": "rgba(0,0,0,.7)",
      "background_color": "#f5f5f5"
    }
  },
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" },
  "reverse_order_mobile": false,
  "column_content_padding": { "padding_desktop": "double", "padding_mobile": "single" },
  "text_color": { ... }
}
```
`content_type`: `"content"` | `"background-image"`
`content_background.background_type` is a **boolean**: `false` = color mode, `true` = image mode (unlike other backgrounds which use string values)
`width`: integer, left + right must sum to 100. Valid range 20–80.

---

### `media_gallery`
```json
{
  "acf_fc_layout": "media_gallery",
  "module_title": "",
  "include_intro_content": false,
  "intro_content": "",
  "media_gallery": [
    { "media_type": true, "slide_image": 1171, "slide_video": { "video_link": "", "poster_image": null, "video_description": "" } },
    { "media_type": false, "slide_image": null, "slide_video": { "video_link": "https://youtube.com/watch?v=...", "poster_image": null, "video_description": "<p>Caption</p>" } }
  ],
  "layout": "carousel",
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`media_type`: `true` = image slide, `false` = video slide
`layout` options: `"carousel"` | `"masonry"`

---

### `blog_post_list`
```json
{
  "acf_fc_layout": "blog_post_list",
  "module_title": "",
  "blogs": "",
  "all_blogs_button": { "button_text": "", "button_link": "/blog/" },
  "layout": "cards",
  "overlay_content": false,
  "column_count": "three",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`layout`: `"featured"` | `"cards"`
`blogs`: `""` for automatic (latest posts), or array of post IDs for manual selection
`overlay_content`: applies only when `layout` is `"cards"`
`column_count`: `"one"` | `"two"` | `"three"` | `"four"` (applies only when `layout` is `"cards"`)

---

### `gallery_list`
```json
{
  "acf_fc_layout": "gallery_list",
  "module_title": "",
  "include_intro_content": false,
  "intro_content": "",
  "manual_selection_or_automatic": false,
  "gallery_list": null,
  "featured_manual_selection_or_automatic": false,
  "featured_gallery": null,
  "featured_custom_excerpt": "",
  "all_galleries_button_text": "",
  "all_galleries_button_link": "/galleries/",
  "layout": "cards",
  "slide_count": "three",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`layout`: `"cards"` | `"carousel"` | `"featured"` | `"full-width"` | `"masonry"`

---

### `project_list`
```json
{
  "acf_fc_layout": "project_list",
  "module_title": "",
  "include_intro_content": false,
  "intro_content": "",
  "manual_selection_or_automatic": false,
  "project_list": null,
  "featured_manual_selection_or_automatic": false,
  "featured_project": null,
  "featured_custom_excerpt": "",
  "all_projects_button_text": "",
  "all_projects_button_link": "/projects/",
  "layout": "carousel",
  "slide_count": "three",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`layout`: `"carousel"` | `"featured"` | `"full-width"`

---

### `history_timeline`
```json
{
  "acf_fc_layout": "history_timeline",
  "eras": [
    {
      "era_title": "1970s",
      "dates": [
        {
          "date_title": "1971",
          "add_an_image": false,
          "layout": false,
          "image_left": null,
          "content": "<h2>Event Title</h2><p>Description.</p>",
          "image_right": null
        }
      ]
    }
  ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... }
}
```
`dates[].layout`: `false` (no image) | `"image-left"` | `"image-right"`
`dates[].image_left` / `image_right`: attachment ID (integer)

---

### `locations_map_cards`
```json
{
  "acf_fc_layout": "locations_map_cards",
  "module_title": "",
  "locations": [1117, 1136],
  "all_locations_button": { "button_text": "", "button_link": "/locations/" },
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`locations`: array of `mandr_location` post IDs.

---

### `locations_search_form`
```json
{
  "acf_fc_layout": "locations_search_form",
  "include_intro_content": false,
  "intro_content": "",
  "all_locations_page": 1130,
  "button_text": "Search Locations",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`all_locations_page`: page post ID (integer).

---

### `team_members`
```json
{
  "acf_fc_layout": "team_members",
  "module_title": "",
  "intro_content": "",
  "team_members": [101, 102],
  "all_team_members_button": { "button_text": "", "button_link": "/team/" },
  "bio_options": {
    "display_full_bio_or_view_bio_button": false,
    "bio_button_options": "modal"
  },
  "layout": "cards",
  "column_count": "three",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`layout`: `"cards"` | `"slider"`
`bio_options.display_full_bio_or_view_bio_button`: `true` = show full bio inline, `false` = show button
`bio_options.bio_button_options`: `"single"` (link to bio page) | `"modal"` (lightbox)
`team_members`: array of `mandr_team_member` post IDs.

---

### `testimonials`
```json
{
  "acf_fc_layout": "testimonials",
  "module_title": "",
  "include_intro_content": false,
  "intro_content": "",
  "testimonials": [
    { "testimonial": "<p>Quote text.</p>", "author_name": "Jane Smith", "author_title": "CEO" }
  ],
  "all_testimonials_button": { "button_text": "", "button_link": "" },
  "layout": "carousel",
  "column_count": "three",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`layout`: `"carousel"` | `"columns"`
`column_count`: applies only when `layout` is `"columns"`. Options: `"two"` | `"three"`

---

### `video_full_width`
```json
{
  "acf_fc_layout": "video_full_width",
  "video_title": "Optional title",
  "video_link": "https://youtube.com/watch?v=...",
  "description": "<p>Optional caption.</p>",
  "poster_image": 1171,
  "all_videos_button": { "button_text": "", "button_link": "" },
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" }
}
```
No `padding` or `background` fields — this module has fixed full-width styling.

---

### `video_cards`
```json
{
  "acf_fc_layout": "video_cards",
  "module_title": "",
  "include_intro_content": false,
  "intro_content": "",
  "videos": [
    {
      "video_link": "https://youtube.com/watch?v=...",
      "poster_image": 1171,
      "description_visibility": false,
      "description": ""
    }
  ],
  "all_videos_button": { "button_text": "", "button_link": "" },
  "column_count": "three",
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`column_count`: `"two"` | `"three"`
`poster_image`: attachment ID (integer). YouTube/Vimeo will use platform thumbnail if omitted.

---

## Data Flow Summary

```
WordPress DB (ACF fields)
    ↓  REST API via wordpress-mcp plugin
modules.php  ←  loops have_rows('modules')
    ↓  get_row_layout() matches acf_fc_layout value
[module-name].php  ←  reads fields via get_sub_field()
    ↓  outputs semantic HTML + hidden <span> settings tags
CSS :has() selectors  ←  read data-attributes on spans
    ↓  apply padding, backgrounds, column widths, colors
Rendered page
```

PHP templates live at: `views/global/modules/[module-name]/[module-name].php`
The data-attribute span pattern must never be modified — CSS depends on it.

---

*Full architecture, CSS system, SCSS variables, coding conventions: see `AGENTS.md`.*
