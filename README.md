yii2-markdocs-module
====================

Renders markdown files from URLs or local files in views.

You can either display the documentation of your online GitHub repo nicely rendered in a custom theme. Or provide application documention in the backend from local files.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Run

```
composer require schmunk42/yii2-markdocs-module "*"
```


Requirements
------------

- configured `pheme/yii2-settings` module and component
- configured RBAC access control, permission: `docs_default`

Usage
-----

### Settings module

Section: `schmunk42.markdocs`

Keys

- `markdownUrl`
- `forkUrl`
- `defaultIndexFile`
- `cachingTime`

### Render Markdown `markdocs/default`

Can render local files or raw data from an URL.

### Render API documentation `markdocs/html`

Example command for `dmstr/phd5-app`

    $ php -dmemory_limit=512M vendor/bin/apidoc api \
        --template=online \
        --exclude=yiisoft,Test,Tests,test,tests,ezyang,phpdocumentor,nikic,php_codesniffer,phptidy,php-cs-fixer,faker \
        src/,vendor/ \
        runtime/html

---

#### ![dmstr logo](http://t.phundament.com/dmstr-16-cropped.png) Built by [dmstr](http://diemeisterei.de)        
