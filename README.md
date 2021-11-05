# PHP Sanitizer

Sanitize and escape every values in your PHP Application.

---


This solution will make PHP developer life easy, very easy and developers would be able to create a secure application quickly and effortlessly.

Let's see inside of this.


## Requirement
**Requires PHP:** 5.6
**Stable tag:** 0.0.1

## How to install

```bash
composer require maniruzzaman/sanitizer
```

## How to use

```php
$unsanitized_value = "<br>Unsanitized";

$sanitize = new Sanitize();
$sanitize->text($unsanitized_value); // Unsanitized
```

## Release Note: `v0.0.1`


## License
**License:** GPLv2 or later
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html
