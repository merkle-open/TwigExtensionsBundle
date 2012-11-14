# TwigExtensionsBundle
## Install TwigExtensionsBundle

Edit `app/AppKernel.php` and add a new entry to the `$bundles` array:
public function registerBundles()
```php
{
    $bundles = array(
        // ...
        new Terrific\TwigExtensionsBundle\TerrificTwigExtensionsBundle()
        // ...
    );
}
```

Register namespace in `app/autoload.php`:
```php
$loader->registerNamespaces(array(
    // ...
    // 'Name' => __DIR__.'/path/to/parent/of/TwigExtensionsBundle/folder'
    'Terrific' => __DIR__.'/../vendor/bundles'
    // ...
));
```

# Twig Extensions
## Configure and add new Twig Extensions

Configuration (take a look at [Service Conatiner](http://symfony.com/doc/2.0/book/service_container.html) if you want to read more about it) is done in file `TwigExtensionsBundle\Resources\config\services.yml`:

```yml
services:
    terrific.twig.extension.filler:
        class: Terrific\TwigExtensionsBundle\Twig\Extension\FillerExtension
        tags:
            - { name: twig.extension }
```

## FillerExtension
Based on Naneau Text Filler by [Maurice Fonk](http://naneau.nl/).

**Usage:**

`{{ w(2) }}` to get two single random words like "Lorem ipsum".

`{{ p(2) }}` to get two single random paragraphs like "Lorem ipsum dolor ..." paragraphs.

## TextGeneratorExtension
Based on Mathew Tinsley's [PHP Lorem Ipsum](http://tinsology.net/scripts/php-lorem-ipsum-generator/) Script. Converted to a Twig Extension by [Bruno Lorenz](https://github.com/senuphtyz).

**Usage:**

`{{ textgen(2) }}` to get two randowm words like "lorem impsum." with period.
