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
	 * Transliterator.
	 *
	 * @var Transliterator
	 */
	protected static $transliterator;

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
     * Be Transliterator.
     *
     * @var Transliterator
     */
	protected static $transliteratorBe;

	/**
     * Mk Transliterator.
     *
     * @var Transliterator
     */
	protected static $transliteratorMk;

	public static function setUpBeforeClass() {
		self::$transliterator = new Transliterator(Transliterator::LANG_SR);
		self::$transliteratorSr = new Transliterator(Transliterator::LANG_SR);
		self::$transliteratorRu = new Transliterator(Transliterator::LANG_RU);
		self::$transliteratorBe = new Transliterator(Transliterator::LANG_BE);
		self::$transliteratorMk = new Transliterator(Transliterator::LANG_MK);
	}

	/**
     * @expectedException InvalidArgumentException
     */
    public function testWrongLanguage() {
    	$transliterator = new Transliterator('xx');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWrongSystem() {
        $transliterator = new Transliterator(Transliterator::LANG_SR, 'xxx');
    }

	public function testCustomMap() {
        $this->assertEquals(
        	'џАРрХ',
        	self::$transliterator
        		->setCyrMap(array('џ', 'А', 'Р', 'р', 'Х'))
        		->setLatMap(array('u', 'A', 'P', 'p', 'X'))
        		->lat2Cyr('uAPpX')
        );
	}

    /**
     * @dataProvider testSerbianProvider
     */
	public function testSerbian($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorSr->transliterate($actual, $direction));
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

	/**
     * @dataProvider testRussianProvider
     */
	public function testRussian($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_DEFAULT)->transliterate($actual, $direction));
	}

    public static function testRussianProvider() {
        return array(
            array('Ю ю', 'Ju ju', false),
            array('Я я', 'Ja ja', false),
            array('Транслитерация русского алфавита латиницей', 'Transliteracija russkogo alfavita latinicej', false),
            array('Ju ju', 'Ю ю', true),
            array('Ja ja', 'Я я', true),
            array('Transliteracija russkogo alfavita latinicej', 'Транслитерация русского алфавита латиницей', true),
            array('Э э', 'È è', false),
           	array('È è', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testRussianGOST1971Provider
     */
	public function testRussianGOST1971($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_GOST_1971)->transliterate($actual, $direction), sprintf('Used maps: %s %s %s', var_export(self::$transliteratorRu->getCyrMap(), true), PHP_EOL, var_export(self::$transliteratorRu->getLatMap(), true)));
	}

    public static function testRussianGOST1971Provider() {
        return array(
            array('Ю ю', 'Yu yu', false),
            array('Я я', 'Ya ya', false)
    	);
    }

	/**
     * @dataProvider testRussianISOR91968Provider
     */
	public function testRussianISOR91968($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_ISO_R_9_1968)->transliterate($actual, $direction));
	}

    public static function testRussianISOR91968Provider() {
        return array(
            array('Ю ю', 'Ju ju', false),
           	array('Я я', 'Ja ja', false),
           	array('Э э', 'Ė ė', false),
           	array('Ė ė', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testRussianGOST1983Provider
     */
	public function testRussianGOST1983($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_GOST_1983)->transliterate($actual, $direction));
	}

    public static function testRussianGOST1983Provider() {
        return array(
            array('Ю ю', 'Ju ju', false),
           	array('Я я', 'Ja ja', false),
           	array('Э э', 'È è', false),
           	array('È è', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testRussianGOST2002Provider
     */
	public function testRussianGOST2002($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_GOST_2002)->transliterate($actual, $direction));
	}

	public static function testRussianGOST2002Provider() {
        return array(
            array('Ю ю', 'Û û', false),
           	array('Я я', 'Â â', false),
           	array('Э э', 'È è', false),
           	array('È è', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testRussianALALCProvider
     */
	public function testRussianALALC($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_ALA_LC)->transliterate($actual, $direction));
	}

	public static function testRussianALALCProvider() {
        return array(
            array('Ю ю', 'I͡u i͡u', false),
           	array('Я я', 'I͡a i͡a', false),
           	array('Э э', 'Ė ė', false),
           	array('Ė ė', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testRussianBritishStandardProvider
     */
	public function testRussianBritishStandard($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_British_Standard)->transliterate($actual, $direction));
	}

	public static function testRussianBritishStandardProvider() {
        return array(
            array('Ю ю', 'Yu yu', false),
           	array('Я я', 'Ya ya', false),
           	array('Э э', 'É é', false),
           	array('É é', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testRussianBGNPCGNProvider
     */
	public function testRussianBGNPCGN($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_BGN_PCGN)->transliterate($actual, $direction));
	}

	public static function testRussianBGNPCGNProvider() {
        return array(
            array('Ю ю', 'Yu yu', false),
           	array('Я я', 'Ya ya', false),
           	array('Э э', 'E e', false),
           	array('E e', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testRussianPassport2003Provider
     */
	public function testRussianPassport2003($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorRu->setSystem(Transliterator::SYSTEM_RU_Passport_2003)->transliterate($actual, $direction));
	}

	public static function testRussianPassport2003Provider() {
        return array(
            array('Ю ю', 'Yu yu', false),
           	array('Я я', 'Ya ya', false),
           	array('Э э', 'E e', false),
           	array('E e', 'Э э', true)
    	);
    }

	/**
     * @dataProvider testBelarusianProvider
     */
	public function testBelarusian($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorBe->setSystem(Transliterator::SYSTEM_DEFAULT)->transliterate($actual, $direction));
	}

	public static function testBelarusianProvider() {
        return array(
            array('д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', 'd  dž  dz  e  ë  ž  z  i  j  k  l  m  n  o  p  r  s  t  u  ŭ  f  x  c  č  š', false),
	        array('d  dž  dz  e  ë  ž  z  i  j  k  l  m  n  o  p  r  s  t  u  ŭ  f  x  c  č  š', 'д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', true)
    	);
    }

	/**
     * @dataProvider testBelarusianALALCProvider
     */
	public function testBelarusianALALC($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorBe->setSystem(Transliterator::SYSTEM_BE_ALA_LC)->transliterate($actual, $direction));
	}

	public static function testBelarusianALALCProvider() {
		return array(
            array('д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', 'd  dz͡h  dz  e  i͡o  z͡h  z  i  ĭ  k  l  m  n  o  p  r  s  t  u  ŭ  f  kh  ts  ch  sh', false),
            array('d  dz͡h  dz  e  i͡o  z͡h  z  i  ĭ  k  l  m  n  o  p  r  s  t  u  ŭ  f  kh  ts  ch  sh', 'д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', true)
    	);
    }

	/**
     * @dataProvider testBelarusianBGNPCGNProvider
     */
	public function testBelarusianBGNPCGN($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorBe->setSystem(Transliterator::SYSTEM_BE_BGN_PCGN)->transliterate($actual, $direction));
	}

	public static function testBelarusianBGNPCGNProvider() {
		return array(
            array('д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', 'd  dzh  dz  ye  yo  zh  z  i  y  k  l  m  n  o  p  r  s  t  u  w  f  kh  ts  ch  sh', false),
            array('d  dzh  dz  ye  yo  zh  z  i  y  k  l  m  n  o  p  r  s  t  u  w  f  kh  ts  ch  sh', 'д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', true)
    	);
    }

	/**
     * @dataProvider testBelarusianISO9Provider
     */
	public function testBelarusianISO9($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorBe->setSystem(Transliterator::SYSTEM_BE_ISO_9)->transliterate($actual, $direction));
	}

	public static function testBelarusianISO9Provider() {
		return array(
            array('д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', 'd  dž  dz  e  ë  ž  z  ì  j  k  l  m  n  o  p  r  s  t  u  ǔ  f  h  c  č  š', false),
            array('d  dž  dz  e  ë  ž  z  ì  j  k  l  m  n  o  p  r  s  t  u  ǔ  f  h  c  č  š', 'д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', true)
    	);
    }

	/**
     * @dataProvider testBelarusianNational2000Provider
     */
	public function testBelarusianNational2000($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorBe->setSystem(Transliterator::SYSTEM_BE_National_2000)->transliterate($actual, $direction));
	}

	public static function testBelarusianNational2000Provider() {
		return array(
            array('д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', 'd  dž  dz  ie  io  ž  z  i  j  k  l  m  n  o  p  r  s  t  u  ú  f  ch  c  č  š', false),
            array('d  dž  dz  ie  io  ž  z  i  j  k  l  m  n  o  p  r  s  t  u  ú  f  ch  c  č  š', 'д  дж  дз  е  ё  ж  з  і  й  к  л  м  н  о  п  р  с  т  у  ў  ф  х  ц  ч  ш', true)
    	);
    }

	/**
     * @dataProvider testMacedonianProvider
     */
	public function testMacedonian($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorMk->setSystem(Transliterator::SYSTEM_DEFAULT)->transliterate($actual, $direction));
	}

	public static function testMacedonianProvider() {
		return array(
            array('а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', 'a b v g d gj e zh z dz i j k l lj m n nj o p r s t kj u f h c ch dj sh', false),
            array('a b v g d gj e zh z dz i j k l lj m n nj o p r s t kj u f h c ch dj sh', 'а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', true)
    	);
    }

	/**
     * @dataProvider testMacedonianISO91995Provider
     */
	public function testMacedonianISO91995($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorMk->setSystem(Transliterator::SYSTEM_MK_ISO_9_1995)->transliterate($actual, $direction));
	}

	public static function testMacedonianISO91995Provider() {
		return array(
            array('а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', 'a b v g d ǵ e ž z ẑ i ǰ k l l̂ m n n̂ o p r s t ḱ u f h c č d̂ š', false),
            array('a b v g d ǵ e ž z ẑ i ǰ k l l̂ m n n̂ o p r s t ḱ u f h c č d̂ š', 'а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', true)
    	);
    }

	/**
     * @dataProvider testMacedonianBGNPCGNProvider
     */
	public function testMacedonianBGNPCGN($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorMk->setSystem(Transliterator::SYSTEM_MK_BGN_PCGN)->transliterate($actual, $direction));
	}

	public static function testMacedonianBGNPCGNProvider() {
		return array(
            array('а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', 'a b v g d đ e ž z dz i j k l lj m n nj o p r s t ć u f h c č dž š', false),
            array('a b v g d đ e ž z dz i j k l lj m n nj o p r s t ć u f h c č dž š', 'а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', true)
    	);
    }

	/**
     * @dataProvider testMacedonianISO9R1968NationalAcademyProvider
     */
	public function testMacedonianISO9R1968NationalAcademy($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorMk->setSystem(Transliterator::SYSTEM_MK_ISO_9_R_1968_National_Academy)->transliterate($actual, $direction));
	}

	public static function testMacedonianISO9R1968NationalAcademyProvider() {
		return array(
            array('а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', 'a b v g d ǵ e ž z dz i j k l lj m n nj o p r s t ḱ u f h c č dž š', false),
            array('a b v g d ǵ e ž z dz i j k l lj m n nj o p r s t ḱ u f h c č dž š', 'а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', true)
    	);
    }

	/**
     * @dataProvider testMacedonianISO9R1968bProvider
     */
	public function testMacedonianISO9R1968b($expected, $actual, $direction) {
        $this->assertEquals($expected, self::$transliteratorMk->setSystem(Transliterator::SYSTEM_MK_ISO_9_R_1968_b)->transliterate($actual, $direction));
	}

	public static function testMacedonianISO9R1968bProvider() {
		return array(
            array('а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', 'a b v g d ǵ e zh z dz i j k l lj m n nj o p r s t ḱ u f kh ts ch dž sh', false),
            array('a b v g d ǵ e zh z dz i j k l lj m n nj o p r s t ḱ u f kh ts ch dž sh', 'а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш', true)
    	);
    }
}