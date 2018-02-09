<?php

namespace Transliterator\Tests;

use Transliterator\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testConstructor()
    {
        $setting = new Settings('uk');

        $this->assertInstanceOf('\Transliterator\Settings', $setting);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedException Language identifier should be 2 characters long.
     */
    public function testSetLangWithLangIsTooLong()
    {
        $setting = new Settings('uk');

        $setting->setLang('invalid_language');
    }
}