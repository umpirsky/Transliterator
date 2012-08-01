Transliterator
==============

Transliterator is a PHP library for text transliteration.

Transliteration is a subset of the science of hermeneutics. It is a form of translation, and is the practice of converting a text from one script into another.

Basic Usage
-----------

```php
<?php
$transliterator = new Transliterator(Settings::LANG_RU);
$transliterator->cyr2Lat('Русский');                        // 'Russkij'
$transliterator->lat2Cyr('Russkij');                        // 'Русский'

$transliterator->setLang(Settings::LANG_SR);
$transliterator->cyr2Lat('Ниш');                            // 'Niš'
$transliterator->lat2Cyr('Niš');                            // 'Ниш'
```

Languages and Transliteration Systems Supported
-----------------------------------------------

- [Russian](http://en.wikipedia.org/wiki/Romanization_of_Russian)
    * ISO R 9 1968
    * GOST 1971
    * GOST 1983
    * GOST 2002
    * ALA LC
    * British Standard
    * BGN PCGN
    * Passport 2003
- [Serbian](http://en.wikipedia.org/wiki/Serbian_Cyrillic_alphabet)
- [Macedonian](http://en.wikipedia.org/wiki/Romanization_of_Macedonian)
    * ISO 9 1995
    * BGN PCGN
    * ISO 9 R 1968 National Academy
    * ISO 9 R 1968 b
- [Belarusian](http://en.wikipedia.org/wiki/Romanization_of_Belarusian)
    * ALA LC
    * BGN PCGN
    * ISO 9
    * National 2000
- [Ukrainian](http://en.wikipedia.org/wiki/Romanization_of_Ukrainian)
    * ALA LC
    * British
    * BGN PCGN
    * ISO 9
    * National
    * GOST 1971
    * GOST 1986
    * Derzhstandart 1995
    * Passport 2004
    * Passport 2007
    * Passport 2010
- [Greek](http://en.wikipedia.org/wiki/Romanization_of_Greek)
- [Bulgarian](http://en.wikipedia.org/wiki/Romanization_of_Bulgarian)

