# Pulpo18Bundle
___

Symfony Bundle to create nice schema images using free [Pulpo 18 Library](http://www.pulpo18.com/).

Installation
------------

### 1) Download 

`composer require -dev mleczakm/pulpo18bundle`


### 2) Enable Bundle

    // app/AppKernel.php
    
    if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
        // ...
        $bundles[] = new mleczakm\Pulpo18Bundle();
    }
    
Usage
=====

#### Generate Schema Image
 
 Run command
 
     php bin/console pulpo -import-project src/AppBundle -orm Doctrine2 -export-image output.png
    
 to generate schema from AppBundle using Doctrine2 (_Propel_ and _Doctrine_ also available) to *output.png* in main directory of your app.

Known limitations
------------

- works only on Linux x64 machines
- requires Qt platform plugin "xcb"
