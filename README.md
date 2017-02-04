# BEAR.SsrModule
JavaScript server side rendering (SSR) module interface for BEAR.Sunday


## Prerequisites

 * php7.1
 * [V8Js](http://php.net/v8js)

# Install

### Composer Install

```
composer require bear/ssr-module
```

### Module Install

```php
$buildDir = dirname(__DIR__, 2) . '/var/www/build';
$this->install(new SsrModule($buildDir, 'index_ssr');
```

In this canse, you need to place `index_ssr.bundle.js` file at `$baseDir` directory. This JS is used server side rendring (SSR) only.

## @Ssr Annotation


### Basic

```php
/**
 * @Ssr(app="index_ssr")
 */
public function onGet()
{ 
    $this->body = [
        'name' => 'World'
    ];

    return $this;
}
```

Annotate `@Ssr` at the method where you want to SSR. Set JS application name to `app`.

### JS Render Application

Here is a very minimalistic JS application. The resource body were passed as `window.__PRELOADED_STATE__`.
You need to set final result string as `window.__SERVER_SIDE_MARKUP__ `.

```javascript
var name = window.__PRELOADED_STATE__.name;
window.__SERVER_SIDE_MARKUP__ = 'Hello ' + name; // Hello World
```

### State and metas

In SSR application, you sometime want to deal two kind of data.
One is for client side which means you are OK to be a public in HTML. One is server side only.

You can separate `state` and `meta` data by custom attribute in `@Ssr` annotation.
`metas` are only used in server side.

```php
/**
 * @Ssr(
 *   app="index_ssr",
 *   state={"name", "age"},
 *   meta={"title"}
 * )
 */
public function onGet()
{ 
    $this->body = [
        'name' => 'World',
        'age' => 4.6E8;
        'title' => 'Age of the World'
    ];

    return $this;
}
```

`state` also works to declara of which keys are used for state. `Exception` thrown when necessary keys are not found in resource body.

```javascript
var title = window.__SSR_METAS__.title // Age of the World
```