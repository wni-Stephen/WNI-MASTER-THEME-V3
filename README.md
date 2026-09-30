# WebsiteNI Master Theme

WebsiteNI WordPress starter theme used as the base for new website builds.

The theme uses WordPress, Foundation, SCSS and JavaScript, with Vite handling front-end asset compilation.

---

## Development Setup

### Requirements

- WordPress

- Node.js 20.19.0 or later in the 20.x series, or Node.js 22.12.0 or later (`^20.19.0 || >=22.12.0`), matching Vite's requirement

- npm

Node.js and npm are required to install dependencies and compile assets. Check `node --version` in the terminal where you will run npm; for WebsiteNI client sites, use the VS Code SSH terminal on the Guru server. Ensure that Node.js meets the requirement above before installing dependencies or running a build.

After adding the theme to a project, install the front-end dependencies:

```bash

npm install

```

### Development

Run Vite in watch mode while developing:

```bash

npm run watch

```

Vite will automatically rebuild the compiled CSS and JavaScript whenever the source SCSS or JavaScript files are changed.

A development watch command is also available:

```bash

npm run dev

```

Both `dev` and `watch` currently run Vite in watch mode.

### Code Quality

Install PHP development dependencies once per checkout:

```bash
composer install
```

Run all configured code-quality checks with:

```bash
npm run lint
```

Or run them individually:

```bash
npm run lint:js
npm run lint:css
npm run lint:php
```

`node_modules/` and `vendor/` are development dependencies and should not be committed or copied to production.

### Production Build

Create a one-off production build with:

```bash

npm run build

```

Compiled assets are generated inside:

```text

assets/dist/

```

The `assets/dist` directory is included with the theme so deployed WordPress websites do not require Node.js or npm simply to load the existing compiled assets.

Do not manually edit files inside `assets/dist`.

---

## WebsiteNI Client Site Workflow

Client websites are typically developed directly on the WebsiteNI Guru server using VS Code Remote Explorer over SSH. The same WordPress installation is then taken live by updating the domain DNS records to point to the WebsiteNI server.

Typical WordPress theme paths include:

```text

public_html/site/wp-content/themes/web

```

or:

```text

public_html/newsite/wp-content/themes/web

```

After adding the WebsiteNI starter theme to a client website:

```bash

npm install

```

While developing:

```bash

npm run watch

```

Vite will watch the source SCSS and JavaScript files and automatically rebuild:

```text

assets/dist/style.css

assets/dist/script.js

```

For a one-off build:

```bash

npm run build

```

For a seven-hour watch session:

```bash

timeout -k 10 7h npm run watch

```

Git is used for maintaining the master starter theme, but is not required for normal client-site development.

---

## Front-end Build System

WebsiteNI Master Theme V3 uses Vite instead of the previous Gulp build process.

### Main SCSS Source

```text

assets/styles/scss/style.scss

```

This loads Foundation and the custom WebsiteNI SCSS.

### Main JavaScript Entry Point

```text

assets/scripts/src/main.js

```

This imports:

- jQuery for module resolution, while keeping WordPress jQuery external at runtime

- Foundation

- What Input

- GSAP, ScrollTrigger and ScrollSmoother

- Hamburgers CSS

- WebsiteNI theme JavaScript

- Main SCSS

WebsiteNI-specific JavaScript remains in:

```text

assets/scripts/functions.js

```

### Compiled Assets

Vite generates:

```text

assets/dist/style.css

assets/dist/script.js

```

WordPress loads the compiled CSS and JavaScript through `app/assets.php`.

Do not manually edit files inside `assets/dist`.

---

## Foundation

Foundation is the base front-end framework used by the starter theme.

Foundation currently provides:

- XY Grid

- Flex utilities

- Typography

- Forms

- Buttons

- Accordions

- Accordion menus

- Button groups

- Close buttons

- Labels

- Responsive embeds

- Tables

- Tabs

- Visibility classes

- Float classes

Foundation is installed through npm and bundled into the Vite build.

Foundation settings are configured in:

```text

assets/styles/scss/_settings.scss

```

---

## Grid & Breakpoints

### Maximum Grid Width

```text

1740px

```

### Grid Gutters

```text

Small:  20px

Medium: 30px

```

### Breakpoints

```text

small:     0

medium:    640px

large:     1024px

xlarge:    1200px

xxlarge:   1440px

xxxlarge:  1740px

```

The available Foundation breakpoint classes are:

```text

small

medium

large

xlarge

xxlarge

xxxlarge

```

---

## SCSS Structure

The main custom SCSS file is:

```text

assets/styles/scss/custom.scss

```

It currently loads:

```text

helper/mixins
helper/variables
helper/tokens
helper/colours
helper/fonts
helper/classes
helper/effects
helper/forms
helper/search

partial/front-page
partial/page-contact
partial/404
partial/archive
partial/single

layout/header
layout/footer

```

Project colours are configured separately in:

```text

assets/styles/scss/helper/_brand.scss

```

Additional project-specific partials can be added as required.

---

## Colours

Project colour values are configured in:

```text

assets/styles/scss/helper/_brand.scss

```

These values are mapped into Foundation's `$foundation-palette` inside:

```text

assets/styles/scss/_settings.scss

```

The starter palette currently includes:

### Brand Colours

```text

primary

secondary

tertiary

quaternary

quinary

senary

```

### Semantic Colours

```text

success

warning

alert

info

```

### Neutral Colours

```text

black

white

gray-light

gray

gray-dark

```

Colour utilities are generated automatically in:

```text

assets/styles/scss/helper/_colours.scss

```

### Background Colours

```text

.bg-primary

.bg-secondary

.bg-tertiary

```

The same pattern applies to every colour in `$foundation-palette`.

### Text Colours

```text

.text-primary

.text-secondary

.text-white

.text-black

```

### Border Colours

```text

.border-primary

.border-secondary

```

### Individual Border Colours

```text

.border-t-primary

.border-r-primary

.border-b-primary

.border-l-primary

```

### Hover Colours

```text

.hover:bg-primary

.hover:text-primary

.hover:border-primary

```

### Gradients

```text

.bg-gradient-primary

.bg-gradient-secondary

```

### Combined Background/Text Utilities

```text

.bg-primary-text-white

.bg-primary-text-black

```

### Underline Colours

```text

.underline-primary

```

### White Typography

```text

.fontcolourwhite

```

This applies white text styling to common nested typography elements including headings, paragraphs, links, spans and list items.

---

## Spacing

Spacing values are defined in:

```text

assets/styles/scss/helper/_variables.scss

```

Current spacing tokens are:

```text

$spacingXSmall: 40px

$spacingSmall:  50px

$spacingMedium: 70px

$spacingLarge:  85px

$spacingXLarge: 140px

```

### Padding Utilities

Examples include:

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

The medium, large and extra-large utilities increase responsively at their relevant breakpoints.

### Margin Utilities

Examples include:

```text

.margintopsml

.marginbottomsml

.margintopmed

.marginbottommed

.margintoplrg

.marginbottomlrg

.margintopxlrg

.marginbottomxlrg

```

### Responsive Margin Helpers

The theme also includes helpers such as:

```text

.marginbottomsmlscreens

.margintopsmlscreens

.marginbottomsmlscreensonly

.margintopsmlscreensonly

.marginbottomsml_lrgscreensonly

.margintopsml_lrgscreensonly

.marginbottomlrg_lrgscreensonly

.margintoplrg_lrgscreensonly

```

There is also:

```text

.nomarginbottom

```

---

## General Utility Classes

General utilities are defined in:

```text

assets/styles/scss/helper/_classes.scss

```

### Background

```text

.bg-center

```

Sets a background image to cover, no-repeat and centred.

### Width & Position

```text

.width100

.relative

.absolute

```

### Flexbox

```text

.wni-flex

.wni-flex-col

```

### Flex Justification

```text

.wni-flex-justify-start

.wni-flex-justify-center

.wni-flex-justify-between

.wni-flex-justify-end

```

### Flex Alignment

```text

.wni-flex-align-start

.wni-flex-align-center

.wni-flex-align-end

```

### Flex Content Alignment

```text

.wni-flex-content-start

.wni-flex-content-center

.wni-flex-content-end

.wni-flex-content-between

.wni-flex-content-around

.wni-flex-content-evenly

```

### Text Alignment

```text

.text-left

.text-center

.text-right

```

Large-screen variants include:

```text

.text-left-lg

.text-center-lg

.text-right-lg

```

### Visibility

Custom XL and XXL visibility helpers include:

```text

.hide-for-xl

.show-for-xl

.hide-for-xxl

.show-for-xxl

```

Foundation's standard visibility classes are also compiled into the theme.

---

## Buttons

Global button styling is located in:

```text

assets/styles/scss/custom.scss

```

The default `.button` includes the WebsiteNI starter styling.

Available modifiers include:

```text

.button.center

.button.right

.button.spacingtop

.button.spacingtop-res

.button.resbutton

.button.inverse

.button.inverseoutline

.button.whiteoutline

```

### `.spacingtop`

Adds a fixed top margin.

### `.spacingtop-res`

Uses responsive top spacing.

### `.resbutton`

Displays full-width on smaller screens and returns to content width from the large breakpoint.

### `.inverse`

Uses the secondary colour as the button background.

### `.inverseoutline`

Transparent button with a secondary-colour outline.

### `.whiteoutline`

Transparent button with a white outline.

---

## Typography

Typography helper styles are located in:

```text

assets/styles/scss/helper/_fonts.scss

```

Heading helpers include:

```text

.uppercase

.nomarginbottom

.marginbottomsml

.marginbottomlrg

```

Additional typography utilities include:

```text

.pfirstof

.plastof

.fontcolourwhite

```

Foundation typography defaults are configured inside:

```text

assets/styles/scss/_settings.scss

```

---

## Forms

The starter form partial is located at:

```text

assets/styles/scss/helper/_forms.scss

```

Foundation's standard form styles are compiled into the main stylesheet.

The WebsiteNI form partial adds a small global baseline for inherited fonts, labels, focus states and textarea behaviour without overriding Foundation heavily.

Plugin-specific styling, such as Formidable Forms, should be added per project when required.

---

## Navigation

The starter theme contains responsive desktop and mobile navigation.

Two WordPress menu locations are registered:

```text

primary-navigation

secondary-navigation

```

### Mobile Navigation

The mobile navigation includes:

- Hamburger menu

- Sliding navigation overlay

- Close control

- Nested submenu toggles

- Page movement while the mobile navigation is active

The menu behaviour is controlled from:

```text

assets/scripts/functions.js

```

The navigation markup is output from:

```text

header.php

```

The close icon is included directly in the PHP markup rather than being injected using JavaScript.

### Desktop Navigation

Desktop navigation includes:

- Horizontal navigation

- Dropdown submenus

- Animated hover states

- Search trigger

Navigation styles are located in:

```text

assets/styles/scss/layout/_header.scss

```

---

## Search

The theme includes a full-screen search interface.

Search styling is located in:

```text

assets/styles/scss/helper/_search.scss

```

JavaScript handles:

- Opening the search

- Closing the search

- Focusing the search input after opening

The search form is output through:

```php

get_search_form();

```

---

## JavaScript Features

WebsiteNI-specific JavaScript is located in:

```text

assets/scripts/functions.js

```

Current functionality includes:

- Responsive YouTube/Vimeo wrappers

- Empty paragraph cleanup inside Foundation components

- Mobile navigation

- Mobile submenu toggles

- Accessible search opening, closing and focus handling

- Inline editable SVG conversion

- ScrollSmoother initialisation

- Reusable GSAP animation classes

---

## GSAP

GSAP is installed through npm and bundled by Vite.

The starter theme includes:

```text

GSAP

ScrollTrigger

ScrollSmoother

```

These are registered in:

```text

assets/scripts/src/main.js

```

and exposed globally for project-specific animation work.

Animation and ScrollSmoother setup is handled in:

```text

assets/scripts/functions.js

```

Reusable animation classes include:

```text

.fade-up
.fade-in
.fade-left
.fade-right
.scale-in

```

---

## Images & SVGs

Theme image assets are stored inside:

```text

assets/images/

```

In PHP templates, build image URLs using WordPress:

```php

<?php echo esc_url(

   get_template_directory_uri() . '/assets/images/example.svg'

); ?>

```

Do not hard-code the theme folder URL.

The theme does not enable unrestricted SVG uploads directly. Use the Safe SVG plugin when SVG uploads are required.

Images with the class:

```text

.editsvg

```

can be converted into inline SVG markup by the theme JavaScript.

---

## Cookie Consent

Cookie consent is intentionally not hard-coded into the starter theme. Use the project-approved consent solution when a website requires consent controls, and configure it for the cookies and services used by that specific site.

---

## WordPress Features

The starter theme currently includes:

- WordPress title support

- Featured image support

- Primary navigation

- Secondary navigation

- ACF options pages

- Custom WordPress login styling

- Custom dashboard content

- Gutenberg disabled

- XML-RPC disabled

- WordPress version hidden

- Emoji assets disabled

- WordPress jQuery used as the runtime jQuery dependency

- Safe SVG recommended when SVG uploads are required

---

## ACF Options

When Advanced Custom Fields Pro is available, the theme creates:

```text

Global Settings

├── General Settings

└── Footer Settings

```

These can be extended for each project.

---

## Asset Workflow

The current front-end workflow is:

```text

SCSS / Foundation / Hamburgers CSS
┐
├── Vite ──> assets/dist/style.css
What Input      │
GSAP            ├──────────> assets/dist/script.js
functions.js    │
┘

WordPress jQuery is kept external and supplied by WordPress at runtime.

```

While developing:

```bash

npm run watch

```

A one-off watch command is also available:

```bash

npm run dev

```

For a final build:

```bash

npm run build

```

Always make changes to the source files rather than editing `assets/dist` directly.

---

## Master Theme Git Workflow

Git is used to maintain and version the WebsiteNI master starter theme.

Normal client-site development does not require Git.

Do not commit:

```text

node_modules/

.DS_Store

```

The following should be committed in the master starter theme:

```text

package.json

package-lock.json

vite.config.mjs

postcss.config.mjs

assets/dist/

```

Compiled Vite assets are deliberately kept in the master theme so it can be added directly to a WordPress project with working CSS and JavaScript already available.

---

## Changelog

Major starter-theme changes should be documented in:

```text

CHANGELOG.md

```

Use the changelog for:

- Build-system changes

- Dependency upgrades

- Theme architecture changes

- Removed legacy functionality

- New reusable WebsiteNI functionality

- Changes future developers need to know about