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
	protected static $transliteratorSr;

	/**
     * Ru Transliterator.
     *
     * @var Transliterator
     */
	protected static $transliteratorRu;

	/**
     * Ru Transliterator (GOST 1971 system).
     *
     * @var Transliterator
     */
	protected static $transliteratorRuGOST1971;

	/**
     * Ru Transliterator (ISO/R 9:1968 system).
     *
     * @var Transliterator
     */
	protected static $transliteratorRuISOR91968;

	public static function setUpBeforeClass() {
		self::$transliteratorSr = new Transliterator(Transliterator::LANG_SR);
		self::$transliteratorRu = new Transliterator(Transliterator::LANG_RU);
		self::$transliteratorRuGOST1971 = new Transliterator(Transliterator::LANG_RU, Transliterator::TRANS_RU_GOST_1971);
		self::$transliteratorRuISOR91968 = new Transliterator(Transliterator::LANG_RU, Transliterator::TRANS_RU_ISO_R_9_1968);
	}

    /**
     * @dataProvider testSerbianProvider
     */
	public function testSerbian($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorSr->transliterate($actual, $direction));
	}

	/**
     * @dataProvider testRussianProvider
     */
	public function testRussian($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->transliterate($actual, $direction));
	}

	/**
     * @dataProvider testRussianGOST1971Provider
     */
	public function testRussianGOST1971($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRuGOST1971->transliterate($actual, $direction));
	}

	/**
     * @dataProvider testRussianISOR91968Provider
     */
	public function testRussianISOR91968($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRuISOR91968->transliterate($actual, $direction));
	}

    public static function testSerbianProvider() {
        return array(
            array('Ниш', 'Niš', false),
            array('Тест са белим знацима.', 'Test sa belim znacima.', false),
            array('Љ', 'Lj', false),
            array('ČĆŠĐLjNjčćšđljnj', 'ЧЋШЂЉЊчћшђљњ', true),
            array('ЧЋШЂЉЊчћшђљњ', 'ČĆŠĐLjNjčćšđljnj', false),
            array('Srbija', 'Србија', true),
            array('А а Б б В в Г г Д д Е е Ж ж З з И и К к Л л М м Н н О о П п Р р С с Т т У у Ф ф Х х Ц ц Ч ч Ш ш Ј ј Љ љ Њ њ Ћ ћ Ђ ђ Џ џ', 'A a B b V v G g D d E e Ž ž Z z I i K k L l M m N n O o P p R r S s T t U u F f H h C c Č č Š š J j Lj lj Nj nj Ć ć Đ đ Dž dž', false),
            array('A a B b V v G g D d E e Ž ž Z z I i K k L l M m N n O o P p R r S s T t U u F f H h C c Č č Š š J j Lj lj Nj nj Ć ć Đ đ Dž dž', 'А а Б б В в Г г Д д Е е Ж ж З з И и К к Л л М м Н н О о П п Р р С с Т т У у Ф ф Х х Ц ц Ч ч Ш ш Ј ј Љ љ Њ њ Ћ ћ Ђ ђ Џ џ', true)
        );
    }

    public static function testRussianProvider() {
        return array(
            array('Ю ю', 'Ju ju', false),
            array('Я я', 'Ja ja', false),
            array('Транслитерация русского алфавита латиницей', 'Transliteracija russkogo alfavita latinicej', false),
            array('Ju ju', 'Ю ю', true),
            array('Ja ja', 'Я я', true),
            array('Transliteracija russkogo alfavita latinicej', 'Транслитерация русского алфавита латиницей', true),
    	);
    }

    public static function testRussianGOST1971Provider() {
        return array(
            array('Ю ю', 'Yu yu', false),
            array('Я я', 'Ya ya', false)
    	);
    }

    public static function testRussianISOR91968Provider() {
        return array(
            array('Ю ю', 'Ju ju', false),
           	array('Я я', 'Ja ja', false)
    	);
    }

}