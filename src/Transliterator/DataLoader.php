<?php

/*
 * This file is part of the Transliterator package.
 *
 * (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Transliterator;

/**
 * Loads transliteration maps from files.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class DataLoader
{
    /**
     * Mappings cache.
     *
     * @var array
     */
    protected $mappingCache;

    /**
     * DataLoader constructor.
     */
    public function __construct()
    {
        $this->mappingCache = array();
    }

    /**
     * Get transliteration map.
     *
     * @param  string $path     path to map file
     * @param  string $alphabet
     * @return array  map array
     */
    public function getTransliterationMap($path, $alphabet)
    {
        // Valdate
        if (!in_array($alphabet, array(Settings::ALPHABET_CYR, Settings::ALPHABET_LAT))) {
            throw new \InvalidArgumentException(sprintf('Alphabet "%s" is not recognized.', $alphabet));
        }

        // Load form cache
        $map = $this->loadFromCache($path, $alphabet);
        if (null !== $map) {
            return $map;
        }

        // Load from file
        $map = $this->loadFromFile($path);

        // Store to cache
        $this->storeToCache($path, $map);

        return $this->loadFromCache($path, $alphabet);
    }

    /**
     * Load map from file.
     *
     * @param  string $path path to map file
     * @return array  map array
     */
    protected function loadFromFile($path)
    {
        if (!file_exists($path)) {
            throw new \Exception(sprintf('Map file "%s" does not exist.', $path));
        }

        $map = require($path);
        if (!is_array($map)
            || !is_array($map[Settings::ALPHABET_CYR])
            || !is_array($map[Settings::ALPHABET_LAT])
        ) {
            throw new \Exception(sprintf(
                'Map file "%s" is not valid, should return an array with %s and %s subarrays.',
                $path,
                Settings::ALPHABET_CYR,
                Settings::ALPHABET_LAT
            ));
        }

        return $map;
    }

    /**
     * Load map from cache.
     *
     * @param  string     $id       cache ID
     * @param  string     $alphabet
     * @return array|null char map, null if not found
     */
    protected function loadFromCache($id, $alphabet)
    {
        if (isset($this->mappingCache[$id]) && isset($this->mappingCache[$id][$alphabet])) {
            return $this->mappingCache[$id][$alphabet];
        }

        return null;
    }

    /**
     * Store map to cache.
     *
     * @param string $id cache ID
     * @param array char map
     */
    protected function storeToCache($id, $map)
    {
        $this->mappingCache[$id] = $map;
    }
}
