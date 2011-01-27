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
     * @param string $basePath map files base path
     * @param string $lang language
     * @param string $system transliteration system
     * @param string $alphabet
     * @return  array   map array
     */
    public function getTransliterationMap($basePath, $lang, $system, $alphabet) {
    	// Valdate
        if (!in_array($alphabet, array(self::ALPHABET_CYR, self::ALPHABET_LAT))) {
            throw new \InvalidArgumentException(sprintf('Alphabet "%s" is not recognized.', $alphabet));
        }

        // Load form cache
    	$map = $this->loadFromCache($lang, $system, $alphabet);
    	if (null !== $map) {
    		return $map;
    	}

    	// Load from files
        $map = $this->loadFromFiles($basePath, $lang, $system);

        // Store to cache
        $this->storeToCache($lang, $system, $map);

        return $this->loadFromCache($lang, $system, $alphabet);
    }

    /**
     * Load map from files.
     *
     * @param string $basePath map files base path
     * @param string $lang language
     * @param string $system transliteration system
     * @return  array   map array
     */
    protected function loadFromFiles($basePath, $lang, $system) {
     	$path = sprintf('%s/data/%s/%s.php', $basePath, $lang, $system);
        if (!file_exists($path)) {
            throw new \Exception(sprintf('Map file "%s" does not exist.', $path));
        }

        $map = require($path);
        if (!is_array($map)
        	|| !is_array($map[self::ALPHABET_CYR])
        	|| !is_array($map[self::ALPHABET_LAT])
        ) {
            throw new \Exception(sprintf(
            	'Map file "%s" is not valid, should return an array with %s and %s subarrays.',
            	$path,
            	self::ALPHABET_CYR,
            	self::ALPHABET_LAT
            ));
        }

        return $map;
    }

    /**
     * Load map from cache.
     *
     * @param string $lang language
     * @param string $system transliteration system
     * @param string $alphabet
     * @return array|null char map, null if not found
     */
    protected function loadFromCache($lang, $system, $alphabet) {
    	$mappingCacheId = $this->getCacheId($lang, $system);
    	if (isset($this->mappingCache[$mappingCacheId]) && isset($this->mappingCache[$mappingCacheId][$alphabet])) {
    		return $this->mappingCache[$mappingCacheId][$alphabet];
    	}

    	return null;
    }

    /**
     * Store map to cache.
     *
     * @param string $lang language
     * @param string $system transliteration system
     * @param array char map
     */
    protected function storeToCache($lang, $system, $map) {
    	$mappingCacheId = $this->getCacheId($lang, $system);
    	$this->mappingCache[$mappingCacheId] = $map;
    }

    /**
     * Generate cache ID.
     *
     * @param string $lang language
     * @param string $system transliteration system
     * @return string cache ID
     */
    protected function getCacheId($lang, $system) {
    	return sprintf('%s_%s', $lang, $system);
    }
}