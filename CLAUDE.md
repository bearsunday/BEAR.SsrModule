# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

BEAR.SsrModule is a JavaScript server-side rendering (SSR) module for BEAR.Sunday framework. It uses V8Js PHP extension to execute JavaScript on the server side via the koriym/baracoa library.

## Commands

### Run Tests
```bash
# Full test suite (includes PHPMD, PHPCS, and PHPUnit)
composer test

# PHPUnit only (requires APC CLI enabled)
php -d apc.enable_cli=1 vendor/bin/phpunit

# Single test
php -d apc.enable_cli=1 vendor/bin/phpunit --filter testInvoke
```

### Code Style
```bash
# Fix coding standards
composer cs-fix
```

## Architecture

### Core Components

The module uses AOP (Aspect-Oriented Programming) via Ray.Aop to intercept methods annotated with `@Ssr`:

1. **`SsrModule`** (`src/SsrModule.php`) - Main DI module that:
   - Binds `SsrInterceptor` to methods with `@Ssr` annotation
   - Configures V8Js constructor parameters
   - Sets up Baracoa (the V8Js wrapper)

2. **`SsrInterceptor`** (`src/SsrInterceptor.php`) - AOP interceptor that:
   - Reads `@Ssr` annotation metadata (app name, state keys, meta keys)
   - Creates an `Ssr` renderer via `SsrFactoryInterface`
   - Attaches the renderer to the ResourceObject

3. **`Ssr`** (`src/Ssr.php`) - RenderInterface implementation that:
   - Filters ResourceObject body into `state` (public, sent to client) and `metas` (server-only)
   - Calls Baracoa to execute JavaScript rendering

### Annotation Usage

```php
/**
 * @Ssr(app="app_name", state={"name", "age"}, metas={"title"})
 */
public function onGet()
```
- `app`: JS bundle filename (without .bundle.js extension)
- `state`: Keys from body to pass as public state (default: `['*']` = all)
- `metas`: Keys from body for server-side only data

### Cache Modules

- **`CacheSsrModule`** - Base module for cached SSR using `CacheBaracoa`
- **`ApcSsrModule`** - APCu-based cache implementation (install on top of SsrModule)

### Dependencies

- `koriym/baracoa` - V8Js wrapper that executes JavaScript bundles
- `bear/resource` - BEAR.Sunday resource framework
- V8Js PHP extension (optional, for actual SSR execution)
