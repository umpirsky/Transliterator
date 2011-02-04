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
 * Keeps language and transliteration system settings.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class Settings {
	/**
     * Supported languages ISO 639-1 codes.
     */
    const LANG_SR = 'sr'; // Serbian (српски)
    const LANG_MK = 'mk'; // Macedonian (македонски)
    const LANG_RU = 'ru'; // Russian (русский)
    const LANG_BE = 'be'; // Belarusian (беларуская)
    const LANG_UK = 'uk'; // Ukrainian (українська)
    const LANG_BG = 'bg'; // Bulgarian (български)
    const LANG_EL = 'el'; // Greek (Ελληνικά)

    /**
     * Supported transliteration systems.
     */
    const SYSTEM_DEFAULT = 'default';
    const SYSTEM_RU_ISO_R_9_1968 = 'ISO_R_9_1968';
    const SYSTEM_RU_GOST_1971 = 'GOST_1971';
    const SYSTEM_RU_GOST_1983 = 'GOST_1983';
    const SYSTEM_RU_GOST_2002 = 'GOST_2002';
    const SYSTEM_RU_ALA_LC = 'ALA_LC';
    const SYSTEM_RU_British_Standard = 'British_Standard';
    const SYSTEM_RU_BGN_PCGN = 'BGN_PCGN';
    const SYSTEM_RU_Passport_2003 = 'Passport_2003';
    const SYSTEM_BE_ALA_LC = 'ALA_LC';
    const SYSTEM_BE_BGN_PCGN = 'BGN_PCGN';
    const SYSTEM_BE_ISO_9 = 'ISO_9';
    const SYSTEM_BE_National_2000 = 'National_2000';
    const SYSTEM_MK_ISO_9_1995 = 'ISO_9_1995';
    const SYSTEM_MK_BGN_PCGN = 'BGN_PCGN';
    const SYSTEM_MK_ISO_9_R_1968_National_Academy = 'ISO_9_R_1968_National_Academy';
    const SYSTEM_MK_ISO_9_R_1968_b = 'ISO_9_R_1968_b';
    const SYSTEM_UK_ALA_LC = 'ALA_LC';
    const SYSTEM_UK_British = 'British';
    const SYSTEM_UK_BGN_PCGN = 'BGN_PCGN';
    const SYSTEM_UK_ISO_9 = 'ISO_9';
    const SYSTEM_UK_National = 'National';
    const SYSTEM_UK_GOST_1971 = 'GOST_1971';

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
     * Settings constructor.
     *
     * @param string $lang ISO 639-1 language code
     * @param string $system transliteration system
     * @see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     */
    public function __construct($lang, $system) {
        $this->setLang($lang)
          ->setSystem($system);
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
     * Get transliteration system.
     *
     * @return string current transliteration system
     */
    public function getSystem() {
        return $this->system;
    }

    /**
     * Set transliteration system.
     *
     * @param string $system transliteration system
     * @return Transliterator fluent interface
     */
    public function setSystem($system) {
        if (!in_array($system, $this->getSupportedTranliterationSystems())) {
            throw new \InvalidArgumentException(
                sprintf('Transliteration system "%s" is not supported for "%s" language.',
                    $system,
                    $this->getLang()
                )
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
        return array(
            self::LANG_SR,
            self::LANG_RU,
            self::LANG_BE,
            self::LANG_MK,
            self::LANG_UK
        );
    }

    /**
     * Get suported transliteration systems for current language.
     *
     * @return array of supported transliteration systems
     */
    public function getSupportedTranliterationSystems() {
        $default = array(self::SYSTEM_DEFAULT);

        switch ($this->getLang()) {
            case self::LANG_RU:
                return array_merge($default, array(
                    self::SYSTEM_RU_ISO_R_9_1968,
                    self::SYSTEM_RU_GOST_1971,
                    self::SYSTEM_RU_GOST_1983,
                    self::SYSTEM_RU_GOST_2002,
                    self::SYSTEM_RU_ALA_LC,
                    self::SYSTEM_RU_British_Standard,
                    self::SYSTEM_RU_BGN_PCGN,
                    self::SYSTEM_RU_Passport_2003
                ));
            break;
            case self::LANG_BE:
                return array_merge($default, array(
                    self::SYSTEM_BE_ALA_LC,
                    self::SYSTEM_BE_BGN_PCGN,
                    self::SYSTEM_BE_ISO_9,
                    self::SYSTEM_BE_National_2000
                ));
            break;
            case self::LANG_MK:
                return array_merge($default, array(
                    self::SYSTEM_MK_ISO_9_1995,
                    self::SYSTEM_MK_BGN_PCGN,
                    self::SYSTEM_MK_ISO_9_R_1968_National_Academy,
                    self::SYSTEM_MK_ISO_9_R_1968_b
                ));
            break;
            case self::LANG_UK:
                return array_merge($default, array(
                    self::SYSTEM_UK_ALA_LC,
                    self::SYSTEM_UK_British,
                    self::SYSTEM_UK_BGN_PCGN,
                    self::SYSTEM_UK_ISO_9,
                    self::SYSTEM_UK_National,
                    self::SYSTEM_UK_GOST_1971,
                ));
            break;
        }

        return $default;
    }
}