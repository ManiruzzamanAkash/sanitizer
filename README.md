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

// Attribute sanitization
$sanitize->attr("(Attribute Show)");

// Url sanitization
$sanitize->url("https://bad-url.com new");
```

## Release Notes:

#### Release version `0.0.3`
- Removed some unused autoload dependency
- 
#### Release version `0.0.2`
- Added `Url` Sanitization


#### Release version `0.0.1`
- Release some simple escaping functions.
- Added `text` sanitization
- Added `attribute` sanitization

## License
The Library is open-sourced software licensed under the <a href="https://opensource.org/licenses/MIT">MIT license</a>.

