# BEAR.SsrModule
JavaScript server side rendering (SSR) module interface for BEAR.Sunday


## Prerequisites

 * php7.1
 * [V8Js](http://php.net/v8js) (Optional)

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

Here is a very minimalistic JS application. Export `render` function to render.
Use [koriym/js-ui-skeletom](https://github.com/koriym/Koriym.JsUiSkeleton) to create Javascript UI application.

```javascript
const render = state => (
  `Hello ${state.name}`
)
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

render.js
```javascript
const render = (preloadedState, metas) => {
  return
  `<html>
    <head>
      <title>${escape(metas.title)}</title>
    </head>
    <body>
      <script>window.__PRELOADED_STATE__ = ${serialize(preloadedState)}</script>
    <body>
  </html>`
};
export default render;
```
```
