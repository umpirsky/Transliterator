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
 *
 *     $transliterator = new Transliterator(Transliterator::LANG_SR);
 *     $transliterator->cyr2Lat('Ниш'); // Niš
 *     $transliterator->lat2Cyr('Niš'); // Ниш
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 * @package Transliterator
 */
class Transliterator {
	/**
	 * Supported languages ISO 639-1 codes.
	 */
	const LANG_SR = 'sr';
	const LANG_RU = 'ru';

	/**
	 * ISO 639-1 language code.
	 *
	 * @var string
	 */
	protected $lang;
	
	/**
	 * Mapping loader.
	 *
	 * @var DataLoader
	 */
	protected $dataLoader;

	/**
	 * Transliterator constructor.
	 *
	 * @param string $lang ISO 639-1 language code
	 * @see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
	 */
	public function __construct($lang) {
		if (2 !== strlen($lang)) {
			throw new \InvalidArgumentException('Language identifier should be 2 characters long.');
		}

		if (!in_array($lang, array(self::LANG_SR, self::LANG_RU))) {
			throw new \InvalidArgumentException(sprintf('Language "%s" is not supported.', $lang));
		}

		$this->lang = $lang;
		$this->dataLoader = new DataLoader();
	}

	/**
	 * Get language.
	 *
	 * @return	string	current language
	 */
	public function getLang() {
		return $this->lang;
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
	 * @return	string	cyrillic text
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
	 * @return	string	transliterated text
	 */
	public function transliterate($text, $direction) {
		if ($direction) {
			return str_replace($this->getCyr(), $this->getLat(), $text);
		} else {
			return str_replace($this->getLat(), $this->getCyr(), $text);
		}
	}

	/**
	 * Get cyrillic char map.
	 *
	 * @return	array	cyrillic char map
	 */
	protected function getCyr() {
		return DataLoader::getTransliterationMap($this->getLang(), DataLoader::ALPHABET_CYR);
	}

	/**
	 * Get latin char map.
	 *
	 * @return	array	latin char map
	 */
	protected function getLat() {
		return DataLoader::getTransliterationMap($this->getLang(), DataLoader::ALPHABET_LAT);
	}
}