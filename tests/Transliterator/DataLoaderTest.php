<?php

/*
 * This file is part of the Transliterator package.
 *
 * (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Transliterator\Tests;

use Transliterator\Settings;
use Transliterator\DataLoader;
use Transliterator\Transliterator;
use PHPUnit\Framework\TestCase;

class DataLoaderTest extends TestCase
{
    public function testConstructor()
    {
        $dataLoader = new DataLoader();

        $this->assertInstanceOf('\Transliterator\DataLoader', $dataLoader);
    }

    /**
     * @expectedException       \InvalidArgumentException
     * @expectedExceptionMessage Alphabet "invalid_alphabet" is not recognized.
     */
    public function testGetTransliterationMapWithAlphabetIsNotInArray()
    {
        $dataLoader = new DataLoader();

        $dataLoader->getTransliterationMap('mapped_file', 'invalid_alphabet');
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Map file "invalid_mapped_file" does not exist.
     */
    public function testLoadFromFileIsNotExisted()
    {
        $dataLoader = new DataLoader();

        $dataLoader->getTransliterationMap('invalid_mapped_file', 'cyr');
    }

    /**
     * @expectedException \Exception
    */
    public function testLoadFromFileWithInvalidMapFile()
    {
        $dataLoader = new DataLoader();
        $dataLoader->getTransliterationMap(__DIR__.'/invalid_map.php', 'cyr');
    }
}
