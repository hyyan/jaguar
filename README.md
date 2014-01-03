Jaguar
======

[![Build Status](https://travis-ci.org/hyyan/jaguar.png?branch=master)](https://travis-ci.org/hyyan/jaguar)
[![Latest Stable Version](https://poser.pugx.org/hyyan/jaguar/v/stable.png)](https://packagist.org/packages/hyyan/jaguar)
[![project status](http://stillmaintained.com/hyyan/jaguar.png)](http://stillmaintained.com/hyyan/jaguar)

PHP 5.3 Graphic Library For Super Fast Image Manipulation And Drawing Using The Gd Library

##Requirements##

The Jaguar library has the following requirements:
 - PHP 5.3+
 - Gd2 Bundled Version (2.0.28 or later) with freetype support
 
##Fetures##

 - Supports  for famous formats (JPEG,PNG,GIF,GD2) and new formats can be added easily [see example](http://jaguar.readthedocs.org/en/latest/usage/Canvas.html#adding-new-foramts)
 - Full Drawing API for drawing all kind of shapes from pixels to polygons 
  * Brushes(Styles) supports for drawing complex and creative shapes (Brush,DashlineStyle,FillStyle,ThicklineStyle,...)
  * Advanced Texts drawers (Shadow,Outlined,...)
  * Advanced Borders drawers (in,out,fit,...)
 - Gradients Generator (Radial,Linear,Rectangle,Diamnond,...)
 - Actions (filters) framework with about 100 non pixel based actions which are superfast (no for loop) including
   advanced filters like:
  * Posterize
  * BlackAndWhite
  * Overlay
  * More than (30) Edge Detection filter including (Soble,Prewitt,Emboss,Gradient,laplacian,...)
  * PartialBlur
  * Antique
  * Multiply
  * Bevel
  * Screen
  * Wavy
  * ....... 
(And list goes on) ....
  
##Instalation##

Installation via composer

```json
{
   "require-dev": {
        "hyyan/jaguar": "1.*"
   }
}
```

##Sample Usage#

```php
use Jaguar\Canvas,
    Jaguar\Transformation,
    Jaguar\Dimension,
    Jaguar\Action\Posterize;
    
$transformation = new Transformation(new Canvas('/path/to/image'));
$transformation->resize(new Dimension(300,300))
               ->apply(new Posterize(40))
               ->watermark(new Canvas('/path/to/watermark'))
               ->getCanvas()
               ->save('/save/somewhere')
               ->show(); // send the result to the browser
```


## Documentation ##

 - [Hosted by Read The Docs](http://jaguar.readthedocs.org/)
 
##License##

Jaguar is open-sourced package licensed under the MIT License.

##Contributions##

Your contributions are more than welcome !

Start by forking Jaguar repository, write your feature, fix bugs, and send a pull request. If you modify Jaguar API, please update the API documentation in the [Jaguar Docs repository](http://www.github.com/hyyan/jaguar-docs)

