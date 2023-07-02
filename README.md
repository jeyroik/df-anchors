![tests](https://github.com/jeyroik/df-anchors/workflows/PHP%20Composer/badge.svg?branch=master&event=push)
![codecov.io](https://codecov.io/gh/jeyroik/df-anchors/coverage.svg?branch=master)
<a href="https://codeclimate.com/github/jeyroik/df-anchors/maintainability"><img src="https://api.codeclimate.com/v1/badges/abe676560fcd2cfdafa4/maintainability" /></a>
[![Latest Stable Version](https://poser.pugx.org/jeyroik/df-anchors/v)](//packagist.org/packages/jeyroik/df-anchors)
[![Total Downloads](https://poser.pugx.org/jeyroik/df-anchors/downloads)](//packagist.org/packages/jeyroik/df-anchors)
[![Dependents](https://poser.pugx.org/jeyroik/df-anchors/dependents)](//packagist.org/packages/jeyroik/df-anchors)


# df-anchors
Anchors mechanizm for DF

# usage

Getting anchors by trigger:

```php
//create $trigger
$anchors = $trigger->getAnchors();
```

Getting instance by anchor:

```php
// $anchor->buildType() == EAnchor::Event

$instance = $anchor->getInstance();
```

Rebuilding anchors for trigger:

```php
$trigger->rebuildTriggerAnchor(0);
$trigger->rebuildPersonalAnchor(0);
```