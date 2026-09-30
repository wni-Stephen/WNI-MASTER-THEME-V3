# WebsiteNI Master Theme Changelog

## V3.0.1 — 30 September 2026

Starter-theme readiness pass for new WebsiteNI projects.

- Replaced the front-page animation demo with the normal Flexible Content/editor renderer.
- Added a shared `components/page-content.php` renderer for standard pages, the front page, Contact and Privacy Policy templates.
- Fixed the Contact template so it no longer renders an empty page.
- Removed the hard-coded cookie notice from the theme; consent should be handled per project.
- Made footer Privacy Policy and Terms links conditional so missing pages do not create dead links.
- Removed the editor-facing Extra CSS Class field from the shared ACF Layout Options group.
- Cleaned empty starter SCSS placeholders and aligned Stylelint with intentional Sass/Foundation syntax.
- Tidied JavaScript comments and retained existing reusable GSAP/ScrollSmoother behaviour.
- Added/confirmed Node, ESLint, Stylelint and PHPCS project tooling.
- Added dependency/build artefacts to `.gitignore`.

---

This file records significant changes made to the WebsiteNI master WordPress starter theme.

The `README.md` documents how the current theme works.

This changelog documents what changed between versions.

---

## V3 — 24 September 2026

Development started September 2026.

---

### Build System

- Replaced the legacy Gulp build process with Vite.

- Removed `gulpfile.js`.

- Removed legacy Gulp dependencies from `package.json`.

- Added `vite.config.mjs`.

- Added `postcss.config.mjs`.

- Added `assets/scripts/src/main.js` as the main JavaScript entry point.

- SCSS is now compiled through Vite.

- Foundation is bundled through Vite.

- What Input is bundled through Vite.

- WebsiteNI `functions.js` is bundled into the main JavaScript output.

Compiled assets are now generated inside:

```text

assets/dist/

```

WordPress now loads:

```text

assets/dist/style.css

assets/dist/script.js

```

instead of the previous Gulp-generated files.

---

### Development Workflow

Added the following npm commands:

```bash

npm run dev

npm run watch

npm run build

```

`npm run dev` and `npm run watch` both run Vite in watch mode.

The standard WebsiteNI client-site workflow can continue using:

```bash

npm install

npm run watch

```

For a one-off build:

```bash

npm run build

```

For a timed seven-hour watch session:

```bash

timeout -k 10 7h npm run watch

```

Git is used for maintaining the master starter theme but is not required for normal client-site development.

---

### Compiled Assets

Removed the old Gulp-generated assets:

```text

assets/styles/style.css

assets/styles/style.css.map

assets/scripts/script.js

assets/scripts/script.js.map

```

Vite now generates:

```text

assets/dist/style.css

assets/dist/script.js

```

The `assets/dist` directory is retained in the master starter theme so it can be deployed with working compiled assets without requiring Node.js or npm on the production server.

Files inside `assets/dist` should not be edited manually. Production source maps are disabled in the Vite configuration.

---

### Foundation Upgrade

- Upgraded Foundation from `6.4.3` to `6.9.0`.

- Updated `package.json` and `package-lock.json`.

- Rebuilt all compiled theme assets through Vite.

- Confirmed Foundation JavaScript initialisation continues to work through the Vite entry point.

The following were tested after the upgrade:

- Grid/container widths

- Grid gutters

- Responsive columns

- `grid-x`

- `cell`

- `small-*` classes

- `medium-*` classes

- `large-*` classes

- Header/navigation

- Mobile navigation

- Dropdown menus

- Accordions

- Tabs

- Buttons

- Form fields

- Select fields

- Responsive visibility classes

- Foundation flex/alignment behaviour

No visual or functional regressions were found during local testing.

---

### JavaScript Cleanup

Removed the separate Foundation initialisation file:

```text

assets/scripts/js/init-foundation.js

```

Foundation is now initialised from:

```text

assets/scripts/src/main.js

```

Removed the legacy SmoothState script:

```text

assets/scripts/js/jquery.smoothState.min.js

```

Removed the previous separate animation JavaScript file.

WebsiteNI-specific functionality remains in:

```text

assets/scripts/functions.js

```

Current theme JavaScript includes:

- Responsive YouTube/Vimeo wrappers

- Foundation content cleanup

- Mobile navigation

- Mobile submenu toggles

- Search overlay

- Editable inline SVG conversion

- ScrollSmoother initialisation

- Reusable GSAP animation helpers

---

### GSAP

GSAP remains part of the WebsiteNI starter theme and is now installed through npm and bundled through Vite.

The starter theme includes:

```text

GSAP

ScrollTrigger

ScrollSmoother

```

These are registered in `assets/scripts/src/main.js` and remain available globally for project-specific animation work.

Reusable animation helpers and ScrollSmoother initialisation are handled in `assets/scripts/functions.js`.

---

### Magnific Popup

Magnific Popup has been removed from the starter theme.

The legacy gallery and inline-popup initialisation, styles and dependency are no longer included.

---

### SCSS Cleanup

Removed old compiled stylesheet files that are no longer part of the active build process.

Removed:

```text

assets/styles/custom.css

assets/styles/custom.css.map

```

Updated SCSS image paths so referenced theme images resolve correctly through the Vite build.

Removed redundant legacy SCSS imports.

Cleaned up old spacing class usage in theme templates.

Current spacing utilities use descriptive names such as:

```text

.paddingtopxsml

.paddingbottomxsml

.paddingtopsml

.paddingbottomsml

.paddingtopmed

.paddingbottommed

.paddingtoplrg

.paddingbottomlrg

.paddingtopxlrg

.paddingbottomxlrg

```

Margin helpers use naming such as:

```text

.margintopsml

.marginbottomsml

.margintopmed

.marginbottommed

```

The older abbreviated naming such as:

```text

ptopsml

pbottomsml

ptopmed

pbottommed

```

is no longer part of the active utility system.

---

### Colours

Colour utilities are generated from the Foundation colour palette.

The theme supports utility patterns including:

```text

.bg-primary

.text-primary

.border-primary

.border-t-primary

.border-r-primary

.border-b-primary

.border-l-primary

.hover:bg-primary

.hover:text-primary

.hover:border-primary

.bg-gradient-primary

.bg-primary-text-white

.bg-primary-text-black

.underline-primary

```

The same pattern applies to colours defined in `$foundation-palette`.

---

### Navigation

Removed JavaScript-generated mobile navigation close markup.

The mobile navigation close control is now output directly from:

```text

header.php

```

Retained:

- Hamburger navigation

- Mobile navigation overlay

- Nested mobile submenu toggles

- Desktop dropdown navigation

- Search trigger

- Search overlay

---

### Header Improvements

Updated `header.php` with:

- Correct viewport metadata.

- WordPress `body_class()`.

- WordPress `wp_body_open()`.

- Improved accessibility attributes.

- Escaped theme image URLs.

- Cleaner navigation markup.

- Mobile navigation close markup moved into PHP.

- Removal of legacy JavaScript-generated markup.

---

### Asset Loading

Asset loading is now handled from:

```text

app/assets.php

```

The main compiled assets are:

```text

assets/dist/style.css

assets/dist/script.js

```

The main JavaScript bundle includes:

- Foundation

- What Input

- GSAP

- ScrollTrigger

- ScrollSmoother

- WebsiteNI theme JavaScript

Hamburgers CSS is imported through the Vite entry point and compiled into the main stylesheet.

jQuery is externalised from the Vite bundle so WordPress supplies the runtime copy.

Asset versions for the compiled Vite files use file modification times so browsers receive updated files after rebuilds.

---

### Vite Entry Point

Added:

```text

assets/scripts/src/main.js

```

This is now the main front-end JavaScript entry point.

It is responsible for:

- Importing the main SCSS file.

- Importing What Input.

- Importing Foundation.

- Importing GSAP, ScrollTrigger and ScrollSmoother.

- Importing Hamburgers CSS.

- Importing WebsiteNI `functions.js`.

- Externalising jQuery so WordPress provides the runtime copy.

- Initialising Foundation.

---

### Forms

Foundation form styling remains part of the compiled theme.

The WebsiteNI project form partial remains at:

```text

assets/styles/scss/helper/_forms.scss

```

This provides a small global form baseline while leaving plugin-specific styling to individual projects.

---

### Images & SVGs

Updated theme image references where required to work correctly with the new build setup.

Theme assets remain stored in:

```text

assets/images/

```

PHP template image URLs should use:

```php

get_template_directory_uri()

```

rather than hard-coded WordPress theme paths.

Unrestricted SVG uploads are no longer enabled directly by the theme. Safe SVG is recommended when SVG uploads are required.

---

### Repository Cleanup

Removed tracked macOS `.DS_Store` files.

Added `.DS_Store` to `.gitignore`.

Removed the accidental self-referencing theme symlink.

Updated `.gitignore` so compiled Vite assets inside:

```text

assets/dist/

```

can be committed.

The following remain ignored:

```text

node_modules/

.DS_Store

```

---

### Local Development Setup

The master starter theme is currently developed locally using a LocalWP test site.

A symlink connects the LocalWP theme directory to the master theme repository, allowing the same source files to be edited and tested without maintaining duplicate theme copies.

This local setup is only for development of the master starter theme and does not change the normal WebsiteNI client-site workflow.

---

### Client Site Development

Normal WebsiteNI client websites continue to be developed directly on the WebsiteNI development server using VS Code Remote Explorer over SSH.

Typical theme locations include:

```text

public_html/site/wp-content/themes/web

```

and:

```text

public_html/newsite/wp-content/themes/web

```

Typical setup:

```bash

cd public_html/site/wp-content/themes/web

npm install

npm run watch

```

or:

```bash

npm run build

```

Git is not required for normal WebsiteNI client-site development.

---

### Documentation

Expanded `README.md` to document the current starter-theme setup.

Documentation now includes:

- Development setup

- WebsiteNI server workflow

- Vite workflow

- SCSS structure

- JavaScript structure

- Compiled assets

- Foundation

- Grid and breakpoints

- Colour utilities

- Spacing utilities

- General utility classes

- Buttons

- Typography

- Forms

- Navigation

- Search

- GSAP

- Images and SVGs

- Design tokens and brand settings

- WordPress features

- ACF options

- Master-theme Git workflow

Added this `CHANGELOG.md` to record major changes between starter-theme versions.

---

## V2

Previous WebsiteNI master starter theme.

### Build System

- Gulp-based SCSS compilation.

- Gulp-based JavaScript compilation.

- Foundation `6.4.x`.

- JavaScript concatenation through Gulp.

- Legacy Babel/Gulp dependencies.

- Generated CSS stored inside:

```text

assets/styles/

```

- Generated JavaScript stored inside:

```text

assets/scripts/

```

### Development

Typical development relied on commands such as:

```bash

gulp watch

```

or project-specific npm watch commands.

V3 replaces this build layer with Vite while retaining the existing WordPress, Foundation and SCSS approach.