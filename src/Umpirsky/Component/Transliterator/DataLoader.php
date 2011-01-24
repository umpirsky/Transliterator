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
 * Loads transliteration maps from files.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 * @package Transliterator
 */
class DataLoader {
	/**
	 * Cyrillic alphabet ID
	 */
	const ALPHABET_CYR = 'cyr';
	
	/**
	 * Latin alphabet ID
	 */
	const ALPHABET_LAT = 'lat';
	
	/**
	 * Mappings cache.
	 *
	 * @var array
	 */
	protected $mappingCache;
	
	/**
     * DataLoader constructor.
     */
    public function __construct() {
    	$this->mappingCache = array();    	
    }
	
    /**
     * Get transliteration map.
     *
     * @param string $lang ISO 639-1 language code
     * @param string $alphabet
     * @return  array   map array
     */
    public function getTransliterationMap($lang, $alphabet) {
        if (!in_array($alphabet, array(self::ALPHABET_CYR, self::ALPHABET_LAT))) {
            throw new \InvalidArgumentException(sprintf('Alphabet "%s" is not recognized.', $alphabet));
        }
    	
    	if (isset($this->mappingCache[$lang]) && isset($this->mappingCache[$lang][$alphabet])) {
    		return $this->mappingCache[$lang][$alphabet];
    	}
    	
        $path = sprintf('%s/data/%s/map.php', __DIR__, $lang);
        if (!file_exists($path)) {
            throw new \Exception(sprintf('Map file "%s" does not exist.', $path));
        }

        $this->mappingCache[$lang] = require($path);
        if (!is_array($this->mappingCache[$lang]) || !is_array($this->mappingCache[$lang][self::ALPHABET_CYR]) || !is_array($this->mappingCache[$lang][self::ALPHABET_LAT])) {
            throw new \Exception(sprintf('Map file "%s" is not valid, should return an array with %s and %s subarrays.', $path, self::ALPHABET_CYR, self::ALPHABET_LAT));
        }

        return $this->mappingCache[$lang][$alphabet];
    }
}