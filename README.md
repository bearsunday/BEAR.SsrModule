# BEAR.SsrModule

[![CI](https://github.com/bearsunday/BEAR.SsrModule/actions/workflows/ci.yml/badge.svg)](https://github.com/bearsunday/BEAR.SsrModule/actions/workflows/ci.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bearsunday/BEAR.SsrModule/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/bearsunday/BEAR.SsrModule/?branch=1.x)

JavaScript server side rendering (SSR) module for BEAR.Sunday

## When to Use This Module

Today, dedicated JavaScript frameworks like Next.js, Nuxt.js, and Remix provide excellent SSR capabilities. However, this module remains valuable when:

- You want to add SSR to an existing BEAR.Sunday application without migrating to a JavaScript framework
- Your team's primary expertise is PHP, and you want to keep the server-side stack unified
- You need fine-grained control over which resource methods use SSR via the `#[Ssr]` attribute

## Prerequisites

 * PHP 8.2+
 * Node.js (for SSR execution)
 * [V8Js](http://php.net/v8js) (Optional - for embedded execution without process overhead)

## Install

### Composer Install

```bash
composer require bear/ssr-module
```

### Module Install

```php
$buildDir = dirname(__DIR__, 2) . '/var/www/build';
$this->install(new SsrModule($buildDir));
```

Place your `{app}.bundle.js` file in the `$buildDir` directory. This JS is used for server side rendering (SSR) only.

## #[Ssr] Attribute

### Basic

```php
use BEAR\SsrModule\Annotation\Ssr;

#[Ssr(app: 'index_ssr')]
public function onGet(): static
{
    $this->body = [
        'name' => 'World',
    ];

    return $this;
}
```

Add the `#[Ssr]` attribute to methods where you want SSR. Set the JS application name with `app`.

### JS Render Application

Here is a minimalistic JS application. Export a `render` function.
Use [koriym/js-ui-skeleton](https://github.com/koriym/Koriym.JsUiSkeleton) to create a JavaScript UI application.

```javascript
const render = state => (
  `Hello ${state.name}`
)
```

### State and Metas

In SSR applications, you may need two kinds of data:
- `state`: Public data sent to the client (included in HTML)
- `metas`: Server-side only data

Separate them using the `state` and `metas` parameters in the `#[Ssr]` attribute:

```php
use BEAR\SsrModule\Annotation\Ssr;

#[Ssr(app: 'index_ssr', state: ['name', 'age'], metas: ['title'])]
public function onGet(): static
{
    $this->body = [
        'name' => 'World',
        'age' => 4.6E8,
        'title' => 'Age of the World',
    ];

    return $this;
}
```

render.js:

```javascript
const render = (preloadedState, metas) => {
  return `<html>
    <head>
      <title>${escape(metas.title)}</title>
    </head>
    <body>
      <script>window.__PRELOADED_STATE__ = ${serialize(preloadedState)}</script>
    </body>
  </html>`;
};
export default render;
```

## Cache Modules

For production, use cache modules to improve performance:

### APCu Cache

```php
$this->install(new ApcSsrModule($buildDir));
```

### Custom Cache

```php
use BEAR\SsrModule\Annotation\SsrCacheConfig;
use Psr\SimpleCache\CacheInterface;

// Bind your PSR-16 cache implementation
$this->bind(CacheInterface::class)
    ->annotatedWith(SsrCacheConfig::class)
    ->to(YourCacheImplementation::class);
$this->install(new CacheSsrModule());
$this->install(new SsrModule($buildDir));
```

## JavaScript Runtime

This module uses [koriym/baracoa](https://github.com/koriym/Koriym.Baracoa) for JavaScript execution, which supports two runtimes:

| Runtime | Pros | Cons |
|---------|------|------|
| **Node.js** (default) | No PHP extension required, easy deployment | Process spawn overhead per render |
| **V8Js** | Embedded execution, no process overhead | Requires PHP extension installation |

Node.js is used automatically when V8Js is not available.

### Performance Note

When combined with BEAR.Sunday's event-driven caching (DonutCache with TTL=0), the Node.js process overhead becomes negligible. The rendered HTML is cached indefinitely and invalidated only when the underlying data changes, so JavaScript execution occurs only on cache misses.
