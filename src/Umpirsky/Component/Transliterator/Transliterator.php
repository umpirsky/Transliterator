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
 *     $transliterator = new Transliterator(Transliterator::LANG_RU);
 *     $transliterator->cyr2Lat('Русский'); // Russkij
 *     $transliterator->lat2Cyr('Russkij'); // Русский
 *     $transliterator->setLang(Transliterator::LANG_SR);
 *     $transliterator->cyr2Lat('Ниш'); // Niš
 *     $transliterator->lat2Cyr('Niš'); // Ниш
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class Transliterator {
	/**
	 * Supported languages ISO 639-1 codes.
	 */
	const LANG_SR = 'sr';
	const LANG_RU = 'ru';

	/**
	 * Supported transliteration systems.
	 */
	const TRANS_RU_GOST_1971 = 'GOST_1971';
	const TRANS_RU_ISO_R_9_1968 = 'ISO_R_9_1968';
	const TRANS_RU_GOST_1983 = 'GOST_1983';
	const TRANS_DEFAULT = 'default';

	/**
	 * ISO 639-1 language code.
	 *
	 * @var string
	 */
	protected $lang;

	/**
	 * Transliteration system.
	 *
	 * @var string
	 */
	protected $system;

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
	public function __construct($lang, $system = self::TRANS_DEFAULT) {
		$this->setLang($lang)
		  ->setSystem($system)
		  ->setMapBasePath(__DIR__)
		  ->dataLoader = new DataLoader();
	}

	/**
	 * Get language.
	 *
	 * @return string current language
	 */
	public function getLang() {
		return $this->lang;
	}

	/**
	 * Set language.
	 *
	 * @param string $lang ISO 639-1 language code
	 * @return Transliterator fluent interface
	 * @see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
	 */
	public function setLang($lang) {
		if (2 !== strlen($lang)) {
			throw new \InvalidArgumentException('Language identifier should be 2 characters long.');
		}

		if (!in_array($lang, $this->getSupportedLanguages())) {
			throw new \InvalidArgumentException(sprintf('Language "%s" is not supported.', $lang));
		}

		$this->lang = $lang;

		return $this;
	}

	/**
	 * Get trnaliteration system.
	 *
	 * @return string current trnaliteration system
	 */
	public function getSystem() {
		return $this->system;
	}

	/**
	 * Set trnaliteration system.
	 *
	 * @param string $system transliteration system
	 * @return Transliterator fluent interface
	 */
	public function setSystem($system) {
		if (!in_array($system, $this->getSupportedTranliterationSystems())) {
			throw new \InvalidArgumentException(
				sprintf('Transliteration system "%s" is not supported for "%s" language.', $system, $this->getLang())
			);
		}

		$this->system = $system;

		return $this;
	}

	/**
	 * Get suported languages.
	 *
	 * @return array of supported languages
	 */
	public function getSupportedLanguages() {
		return array(self::LANG_SR, self::LANG_RU);
	}

	/**
	 * Get suported trnaliteration systems for current language.
	 *
	 * @return array of supported trnaliteration systems
	 */
	public function getSupportedTranliterationSystems() {
		$default = array(self::TRANS_DEFAULT);

		switch ($this->getLang()) {
			case self::LANG_RU:
				return array_merge($default, array(
					self::TRANS_RU_GOST_1971,
					self::TRANS_RU_ISO_R_9_1968,
					self::TRANS_RU_GOST_1983
				));
			break;
		}

		return $default;
	}

	/**
	 * Transliterates cyrillic text to latin.
	 *
	 * @param string $text cyrillic text
	 * @return	string	latin text
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
			$this->cyrMap = $this->dataLoader->getTransliterationMap($this, DataLoader::ALPHABET_CYR);
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
			$this->latMap = $this->dataLoader->getTransliterationMap($this, DataLoader::ALPHABET_LAT);
		}

		return $this->latMap;
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
     * Set path to map files.
     *
     * @param string $mapBasePath path to map files
     * @return Transliterator fluent interface
     */
    public function setMapBasePath($mapBasePath) {
        $this->mapBasePath = $mapBasePath;

        return $this;
    }

    /**
     * Get path to map files.
     *
     * @return string path to map files
     */
    public function getMapBasePath() {
        return $this->mapBasePath;
    }
}