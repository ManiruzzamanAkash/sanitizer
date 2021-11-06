# PHP Sanitizer

Sanitize and escape every values in your PHP Application.

---


This solution will make PHP developer life easy, very easy and developers would be able to create a secure application quickly and effortlessly.

Let's see inside of this.


## Requirement
**Requires PHP:** 7.1 or later

**Stable tag:** 0.0.6


## How to install

```shell
composer require maniruzzaman/sanitizer
```

## Documentation

Instantiation and loading.
```php
// at top of the class autoload
use Maniruzzaman\Sanitizer\Sanitize;

// instantiate anywhere if needed
$sanitize = new Sanitize();
```

#### Sanitize Text

**Example 1: Sanitize text with script:**
```php
$string  = 'Text with script <script>alert("you are hacked...")</script>';
Sanitize::text($string);
//Output: Text with issuealert("you are hacked...")
```


**Example 2: Sanitize text with html texts:**
```php
$string  = 'Text with script <strong>This is strong text</strong>';
Sanitize::text($string);
//Output: Text with script This is strong text
```

#### Sanitize Attribute

**Example 3: Sanitize attribute to filter out unnecessary strings:**
```php
$string  = 'https://devsenv.com<script>welcome</script>';

$sanitize = new Sanitize();
$sanitize->attr($string);
//Output: https:://devsenv.com
```

#### More is coming...

## Release Notes:

#### Release version `0.0.5`
- Fixed some autoloading issue with documenting

#### Release version `0.0.4`
- Fixed autoloading functions

#### Release version `0.0.3`
- Removed some unused autoload dependency

#### Release version `0.0.2`
- Added `Url` Sanitization


#### Release version `0.0.1`
- Release some simple escaping functions.
- Added `text` sanitization
- Added `attribute` sanitization

## License
The Library is open-sourced software licensed under the <a href="https://opensource.org/licenses/MIT">MIT license</a>.

## Support
Do you wanna support me to buy a coffee? Please be one of my patreon -
https://www.patreon.com/maniruzzaman
