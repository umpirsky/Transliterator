<?php

/*
 * This file is part of the Umpirsky components.
 *
 * (c) Saša Stamenković <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umpirsky\Tests\Component\Transliterator;

use Umpirsky\Component\Transliterator\Transliterator;

class TranslatorTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Sr Transliterator.
	 *
	 * @var Transliterator
	 */
	protected $transliteratorSr;
	
	/**
     * Ru Transliterator.
     *
     * @var Transliterator
     */
	protected $transliteratorRu;
	
	protected function setUp() {
		$this->transliteratorSr = new Transliterator(Transliterator::LANG_SR);		
		$this->transliteratorRu = new Transliterator(Transliterator::LANG_RU);		
	}
	
    /**
     * @dataProvider testSerbianProvider
     */
	public function testSerbian($expected, $actual, $direction) {
        $this->assertEquals($expected, $this->transliteratorSr->transliterate($actual, $direction));
	}
	
    public static function testSerbianProvider() {
        return array(
            array('Ниш', 'Niš', false),
            array('Тест са белим знацима.', 'Test sa belim znacima.', false),
            array('Љ', 'Lj', false),
            array('ČĆŠĐLjNjčćšđljnj', 'ЧЋШЂЉЊчћшђљњ', true),
            array('ЧЋШЂЉЊчћшђљњ', 'ČĆŠĐLjNjčćšđljnj', false),
            array('Srbija', 'Србија', true)
        );
    }
}