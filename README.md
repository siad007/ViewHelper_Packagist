Packagist API Client for ZF2
============================

Packagist API Client and View-Helpers for Zend Framework 2

## Project Status

[![Build Status](https://travis-ci.org/siad007/ViewHelper_Packagist.png?branch=master)](https://travis-ci.org/siad007/ViewHelper_Packagist) [![Coverage Status](https://coveralls.io/repos/siad007/ViewHelper_Packagist/badge.png?branch=master)](https://coveralls.io/r/siad007/ViewHelper_Packagist?branch=master) [![Latest Stable Version](https://poser.pugx.org/siad007/packagist/v/stable.png)](https://packagist.org/packages/siad007/packagist) [![Latest Unstable Version](https://poser.pugx.org/siad007/packagist/v/unstable.png)](https://packagist.org/packages/siad007/packagist) [![Total Downloads](https://poser.pugx.org/siad007/packagist/downloads.png)](https://packagist.org/packages/siad007/packagist)

[![Dependency Status](https://www.versioneye.com/user/projects/51be2d942912f70002002482/badge.png)](https://www.versioneye.com/user/projects/51be2d942912f70002002482)

## Usage View Helper

### Fetch

```php
<?php
// fetch a list of all vendor-names/package-names (inside a view script)
echo $this->packagist()->fetch();

// will output something like
0x20h/monoconf
11ya/excelbundle
11ya/phpexcel
2085020/api_pingdom
2085020/zendframework1
...

// optional use of an other separator than <br />
echo $this->packagist()->fetch('|');
```

### Display

```php
<?php
// Displays a package (inside a view script)
echo $this->packagist()->display('siad007/packagist');

// will output something like
<ul>
    <li>siad007/packagist</li>
        <li>A Zend Framework module using the Packagist API</li>
        <li>zf2, ZendFramework</li>
        <li>1.0.0(1.0.0.0)</li>
        <li>BSD-3-Clause</li>
        <ul>
            <li>Siad Ardroumli, siad.ardroumli@gmail.com</li>
        </ul>
        ...
</ul>
```

### Search

```php
<?php
// for a query based search (inside a view script)
echo $this->packagist()->search(array('q' => 'ViewHelper_Packagist'));

// will output something like
<ul id="packagistList">
    <ul class="packagistRow">
        <li class="packagistName">
            <a href="https://packagist.org/packages/siad007/ViewHelper_Packagist">siad007/ViewHelper_Packagist</a>
        </li>
        <li class="packagistDescription">View Helper for Zend Framework 2 using the Packagist API</li>
        <li class="packagistDownloads">123</li>
        <li class="packagistFavors">0</li>
    </ul>
    ...
</ul>

// for a tag based search
echo $this->packagist()->search(array('tags' => 'zf1'));

// for multiple tags
echo $this->packagist()->search(array('tags' => array('zf1', 'view helper')));

// for a tag and query based search
echo $this->packagist()->search(array('q' => 'view helper', 'tags' => 'zf1'));

// or the most 15 popular packages
echo $this->packagist()->search(array('page' => '1', 'q' => ''));
```

## License

BSD 3-Clause
