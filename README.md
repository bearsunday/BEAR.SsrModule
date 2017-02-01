# BEAR.SsrModule
JavaScript server side rendering (SSR) module interface for BEAR.Sunday


## Prerequisites

 * php7.1
 * [V8Js](http://php.net/v8js)

## Install

### Composer Install

```
composer require bear/ssr-module
```

### Module Install

```php
$buildDir = dirname(__DIR__, 2) . '/var/www/build';
$this->install(new SsrModule($buildDir, 'ssr_app');
```

In this canse, you need to place `ssr-app.bundle.js` file at `$baseDir` directory.

### @Ssr Annotation

```php
/**
 * @Ssr(app="test_ssr")
 */
public function onGet()
{ 
    $this->body = [
        'state' => [
            'name' => 'World'
        ],
        'metas' => [
            'title' => 'page-title'
        ]
    ];

    return $this;
}
```

Annotate `@Ssr` at the method where you want to SSR. Set JS application name to `app`. 

In the annoteted method, We set `state` and `metas`.Then this values are passed as following in JS.

 * `window.__PRELOADED_STATE__` (state)
 * `window.__SSR_METAS__` (metas)

### JS Render Application

Here is a very minimalistic JS application.

```javascript
var name = window.__PRELOADED_STATE__.name;
window.__SERVER_SIDE_MARKUP__ = 'Hello ' + name; // Hello World
```
