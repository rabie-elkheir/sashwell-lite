# Sashwell Lite

A calm, type-led WordPress theme for cleaning companies and other local service businesses.

Sashwell Lite puts the phone number and the areas a business covers where visitors look for them,
and keeps the rest of the page to clear type, hairlines and white space. It needs no plugins.

## Features

- Header with a top bar, dropdown and large menus, search, dark mode and a quote button
- Side panel with contact details, opening hours, WhatsApp, areas covered and social links
- Call and WhatsApp bar on phones
- Light and dark mode, chosen by the visitor
- Quiet motion that respects the visitor's reduced-motion setting
- Blog in a list or a grid, featured article, reading time, contents list for long articles
- Ten block patterns and a Landing page template for building a full home page
- Block styles: "Ticked" list and "Text link" button
- All options in Appearance > Customize > Theme options
- Translation ready, self-hosted fonts, no requests to other servers

## Requirements

- WordPress 6.5 or later
- PHP 7.4 or later

## Installation

1. Download the latest release zip.
2. In WordPress, go to Appearance > Themes > Add New Theme > Upload Theme and choose the zip.
3. Activate the theme, then open Appearance > Customize > Theme options.

Full setup notes, including the home page and menus, are in [readme.txt](readme.txt).

## Development

Coding standards: WordPress-Extra, WordPress-Docs and PHPCompatibilityWP (PHP 7.4+), configured in
`phpcs.xml.dist`.

```sh
composer global require wp-coding-standards/wpcs phpcompatibility/phpcompatibility-wp
phpcs
```

Build the distributable zip from a clean checkout (development files are excluded through
`.gitattributes`):

```sh
git archive --format=zip --prefix=sashwell-lite/ -o sashwell-lite.zip HEAD
```

## Licence

Sashwell Lite is licensed under the GNU General Public License v2 or later. See [readme.txt](readme.txt)
for the licences of bundled fonts and other resources.
