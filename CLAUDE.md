# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

BEAR.SsrModule is a JavaScript server-side rendering (SSR) module for BEAR.Sunday framework. It uses V8Js PHP extension to execute JavaScript on the server side via the koriym/baracoa library.

## Commands

```bash
# Run all checks (phpcs + phpstan + phpunit)
composer tests

# PHPUnit only (requires APC CLI enabled)
php -d apc.enable_cli=1 vendor/bin/phpunit

# PHPUnit without V8Js (CI environment)
vendor/bin/phpunit --exclude-group=v8js

# Single test
php -d apc.enable_cli=1 vendor/bin/phpunit --filter testInvoke

# Static analysis
composer sa

# Fix coding standards
composer cs-fix
```

## Architecture

### Core Components

The module uses AOP (Aspect-Oriented Programming) via Ray.Aop to intercept methods with `#[Ssr]` attribute:

1. **`SsrModule`** (`src/SsrModule.php`) - Main DI module that:
   - Binds `SsrInterceptor` to methods with `#[Ssr]` attribute
   - Configures V8Js constructor parameters
   - Sets up Baracoa (the V8Js wrapper)

2. **`SsrInterceptor`** (`src/SsrInterceptor.php`) - AOP interceptor that:
   - Reads `#[Ssr]` attribute metadata (app name, state keys, meta keys)
   - Creates an `Ssr` renderer via `SsrFactoryInterface`
   - Attaches the renderer to the ResourceObject

3. **`Ssr`** (`src/Ssr.php`) - RenderInterface implementation that:
   - Filters ResourceObject body into `state` (public, sent to client) and `metas` (server-only)
   - Calls Baracoa to execute JavaScript rendering

### Attribute Usage

```php
#[Ssr(app: 'app_name', state: ['name', 'age'], metas: ['title'])]
public function onGet(): static
```
- `app`: JS bundle filename (without .bundle.js extension)
- `state`: Keys from body to pass as public state (default: `['*']` = all)
- `metas`: Keys from body for server-side only data

### Cache Modules

- **`CacheSsrModule`** - Base module for cached SSR using `CacheBaracoa`
- **`ApcSsrModule`** - APCu-based cache implementation (requires `$bundleSrcBasePath` constructor parameter)

### Dependencies

- `koriym/baracoa` - V8Js wrapper that executes JavaScript bundles
- `bear/resource` - BEAR.Sunday resource framework
- V8Js PHP extension (optional for development, required for actual SSR execution)

### Testing

Tests requiring V8Js are marked with `#[Group('v8js')]`. CI runs these tests in a Docker container with V8Js pre-installed.
