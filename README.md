<h3 align="center">
    <a href="https://github.com/umpirsky">
        <img src="https://farm2.staticflickr.com/1709/25098526884_ae4d50465f_o_d.png" />
    </a>
</h3>
<p align="center">
  <a href="https://github.com/umpirsky/Symfony-Upgrade-Fixer">symfony upgrade fixer</a> &bull;
  <a href="https://github.com/umpirsky/Twig-Gettext-Extractor">twig gettext extractor</a> &bull;
  <a href="https://github.com/umpirsky/wisdom">wisdom</a> &bull;
  <a href="https://github.com/umpirsky/centipede">centipede</a> &bull;
  <a href="https://github.com/umpirsky/PermissionsHandler">permissions handler</a> &bull;
  <a href="https://github.com/umpirsky/Extraload">extraload</a> &bull;
  <a href="https://github.com/umpirsky/Gravatar">gravatar</a> &bull;
  <a href="https://github.com/umpirsky/locurro">locurro</a> &bull;
  <a href="https://github.com/umpirsky/country-list">country list</a> &bull;
  <b>transliterator</b>
</p>

Transliterator [![Build Status](https://secure.travis-ci.org/umpirsky/Transliterator.svg?branch=master)](http://travis-ci.org/umpirsky/Transliterator)
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
    * GOST 1971 (GOST 16876-71 table 2)
    * GOST 1983
    * GOST 2000 (GOST 7.79-2000, system B; ISO (1995))
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

