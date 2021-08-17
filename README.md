# Shokka Forms

A simple WordPress plugin for creating forms in the block editor.

## Development setup

To set up development environemt you need to:
1. Install development dependencies:
    ```
    npm install
    ```
2. Install phpunit via Composer:
    ```
    $ composer install
    ```
3. Install WP Test test installation:
    ```
    $ bin/install-wp-tests.sh testwp testwp testwp
    ```
    Arguments testwp are: database, db user, db password - in that order.

    !!! Database that you point to will be wiped on each test run, so make sure you are not using database with any relevant information!!!

This will all needed packages.

## Development tools

There are several npm scripts that can be used to validate, format and build code.

Run PHP tests:
    ```
    npm run test:php
    ```

Build assets (js, css) for development environment:
    ```
    npm run build
    ```

Build and watch assets for development:
    ```
    npm run build:watch
    ```

Build assets for use in production environment:
    ```
    npm run build:prod
    ```

Check php code against Coding Standards:
    ```
    npm run lint:php
    ```

Format php code against Coding Standards. This will only fix some issues, make sure that you manually fix remaining issues before making a commit.
    ```
    npm run format:php
    ```

Check JavaScript code against Coding Standards:
    ```
    npm run lint:js
    ```

Format JavaScript code against Coding Standards.
    ```
    npm run format:js
    ```

There are configurations for linters in project root. Make sure you IDE/Code Editor uses those configurations for reporting linting errors.