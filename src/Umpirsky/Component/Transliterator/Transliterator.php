<?php

/*
 * This file is part of the Umpirsky components.
 *
 * (c) Saša Stamenković <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umpirsky\Component\Transliterator;

/**
 * Transliterator is used to convert text from
 * cyrillic to latin and vice versa.
 *
 * Usage:
 *
 *     $transliterator = new Transliterator(Settings::LANG_RU);
 *     $transliterator->cyr2Lat('Русский'); // returns 'Russkij'
 *     $transliterator->lat2Cyr('Russkij'); // returns 'Русский'
 *     $transliterator->setLang(Settings::LANG_SR);
 *     $transliterator->cyr2Lat('Ниш'); // returns 'Niš'
 *     $transliterator->lat2Cyr('Niš'); // returns 'Ниш'
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 * @see http://en.wikipedia.org/wiki/Transliteration
 */
class Transliterator {
	/**
	 * Transliterator settings.
	 *
	 * @var Settings
	 */
	protected $settings;
	
    /**
     * Mapping loader.
     *
     * @var DataLoader
     */
    protected $dataLoader;

    /**
     * Cyrillic mapping.
     *
     * @var array
     */
    protected $cyrMap;

    /**
     * Latin mapping.
     *
     * @var array
     */
    protected $latMap;

    /**
     * Path to map files.
     *
     * @var string
     */
    protected $mapBasePath;

    /**
     * Transliterator constructor.
     *
     * @param string $lang ISO 639-1 language code
     * @param string $system transliteration system
     * @see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     */
    public function __construct($lang, $system = Settings::SYSTEM_DEFAULT) {
    	$this->settings = new Settings($lang, $system);
    	$this->dataLoader = new DataLoader();
        $this->setMapBasePath(__DIR__ . DIRECTORY_SEPARATOR . 'data');
    }
    
    /**
     * Set language.
     *
     * @param string $lang ISO 639-1 language code
     * @return Transliterator fluent interface
     * @see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     */
    public function setLang($lang) {
        $this->settings->setLang($lang);
        $this->clearCharMaps();
        return $this;
    }
    
    /**
     * Set transliteration system.
     *
     * @param string $system transliteration system
     * @return Transliterator fluent interface
     */
    public function setSystem($system) {
    	$this->settings->setSystem($system);
        $this->clearCharMaps();
        return $this;
    }

    /**
     * Clear char maps.
     *
     * @return Transliterator fluent interface
     */
    public function clearCharMaps() {
        $this->cyrMap = $this->latMap = null;

        return $this;
    }

    /**
     * Transliterates cyrillic text to latin.
     *
     * @param string $text cyrillic text
     * @return    string    latin text
     */
    public function cyr2Lat($text) {
        return $this->transliterate($text, true);
    }

    /**
     * Transliterates latin text to cyrillic.
     *
     * @param string $text latin text
     * @return string cyrillic text
     */
    public function lat2Cyr($text) {
        return $this->transliterate($text, false);
    }

    /**
     * Transliterates cyrillic text to latin and vice versa
     * depending on $direction parameter.
     *
     * @param string $text latin text
     * @param bool $direction if true transliterates cyrillic text to latin, if false latin to cyrillic
     * @return string transliterated text
     */
    public function transliterate($text, $direction) {
        if ($direction) {
            return str_replace($this->getCyrMap(), $this->getLatMap(), $text);
        } else {
            return str_replace($this->getLatMap(), $this->getCyrMap(), $text);
        }
    }

    /**
     * Get cyrillic char map.
     *
     * @return array cyrillic char map
     */
    public function getCyrMap() {
        if (null === $this->cyrMap) {
            $this->cyrMap = $this->getTransliterationMap(Settings::ALPHABET_CYR);
        }

        return $this->cyrMap;
    }

    /**
     * Get latin char map.
     *
     * @return array latin char map
     */
    public function getLatMap() {
        if (null === $this->latMap) {
            $this->latMap = $this->getTransliterationMap(Settings::ALPHABET_LAT);
        }

        return $this->latMap;
    }

    /**
     * Get trasnsliteration char map.
     *
     * @param string $alphabet
     * @return array trasnsliteration map
     */
    protected function getTransliterationMap($alphabet) {
        return $this->dataLoader->getTransliterationMap(
            $this->getMapFilePath(),
            $alphabet
        );
    }

    /**
     * Set cyrillic char map.
     *
     * @param array $cyrMap cyrillic char map
     * @return Transliterator fluent interface
     */
    public function setCyrMap(array $cyrMap) {
        $this->cyrMap = $cyrMap;

        return $this;
    }

    /**
     * Set latin char map.
     *
     * @param array $latMap latin char map
     * @return Transliterator fluent interface
     */
    public function setLatMap(array $latMap) {
        $this->latMap = $latMap;

        return $this;
    }

    /**
     * Set base path to map files.
     *
     * @param string $mapBasePath path to map files
     * @return Transliterator fluent interface
     */
    public function setMapBasePath($mapBasePath) {
        $this->mapBasePath = $mapBasePath;

        return $this;
    }

    /**
     * Get base path to map files.
     *
     * @return string path to map files
     */
    public function getMapBasePath() {
        return $this->mapBasePath;
    }
    
    /**
     * Get path to map file depending on current settings.
     *
     * @return string path to map file
     */
    protected function getMapFilePath() {
        return sprintf(
            '%s.php',
            $this->mapBasePath .
            DIRECTORY_SEPARATOR . 
            $this->settings->getLang().
            DIRECTORY_SEPARATOR .
            $this->settings->getSystem()
        );
    }
}