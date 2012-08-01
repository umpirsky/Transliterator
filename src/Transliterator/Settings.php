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
 * Keeps language,transliteration system and base path settings.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Settings {
    /**
     * Serbian (српски) ISO 639-1 code.
     */
    const LANG_SR = 'sr';

    /**
     * Macedonian (македонски) ISO 639-1 code.
     */
    const LANG_MK = 'mk';

    /**
     * Russian (русский) ISO 639-1 code.
     */
    const LANG_RU = 'ru';

    /**
     * Belarusian (беларуская) ISO 639-1 code.
     */
    const LANG_BE = 'be';

    /**
     * Ukrainian (українська) ISO 639-1 code.
     */
    const LANG_UK = 'uk';

    /**
     * Bulgarian (български) ISO 639-1 code.
     */
    const LANG_BG = 'bg';

    /**
     * Greek (ελληνικά) ISO 639-1 code.
     */
    const LANG_EL = 'el';

    /**
     * Usually scholarly or some default transliteration system.
     */
    const SYSTEM_DEFAULT = 'default';

    /**
     * ISO 9 transliteration system.
     */
    const SYSTEM_ISO_9 = 'ISO_9';

    /**
     * ISO 9 (1995) transliteration system.
     */
    const SYSTEM_ISO_9_1995 = 'ISO_9_1995';

    /**
     * ISO/R 9:1968 transliteration system.
     */
    const SYSTEM_ISO_R_9_1968 = 'ISO_R_9_1968';

    /**
     * ISO 9 (R:1968, b) transliteration system.
     */
    const SYSTEM_ISO_9_R_1968_b = 'ISO_9_R_1968_b';

    /**
     * ISO 9 (R:1968) + National Academy transliteration system.
     */
    const SYSTEM_ISO_9_R_1968_National_Academy = 'ISO_9_R_1968_National_Academy';

    /**
     * GOST 1971 transliteration system.
     */
    const SYSTEM_GOST_1971 = 'GOST_1971';

    /**
     * GOST 1983 transliteration system.
     */
    const SYSTEM_GOST_1983 = 'GOST_1983';

    /**
     * GOST 1986 transliteration system.
     */
    const SYSTEM_GOST_1986 = 'GOST_1986';

    /**
     * GOST 2002 transliteration system.
     */
    const SYSTEM_GOST_2002 = 'GOST_2002';

    /**
     * ALA-LC transliteration system.
     */
    const SYSTEM_ALA_LC = 'ALA_LC';

    /**
     * BGN/PCGN transliteration system.
     */
    const SYSTEM_BGN_PCGN = 'BGN_PCGN';

    /**
     * Passport 2003 transliteration system.
     */
    const SYSTEM_Passport_2003 = 'Passport_2003';

    /**
     * Passport 2004 transliteration system.
     */
    const SYSTEM_Passport_2004 = 'Passport_2004';

    /**
     * Passport 2007 transliteration system.
     */
    const SYSTEM_Passport_2007 = 'Passport_2007';

    /**
     * Passport 2010 transliteration system.
     */
    const SYSTEM_Passport_2010 = 'Passport_2010';

    /**
     * National transliteration system.
     */
    const SYSTEM_National = 'National';

    /**
     * National 2000 transliteration system.
     */
    const SYSTEM_National_2000 = 'National_2000';

    /**
     * British transliteration system.
     */
    const SYSTEM_British = 'British';

    /**
     * British Standard transliteration system.
     */
    const SYSTEM_British_Standard = 'British_Standard';

    /**
     * British Standard transliteration system.
     */
    const SYSTEM_Derzhstandart_1995 = 'Derzhstandart_1995';

    /**
     * Cyrillic alphabet ID
     */
    const ALPHABET_CYR = 'cyr';

    /**
     * Latin alphabet ID
     */
    const ALPHABET_LAT = 'lat';

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
     * Path to map files.
     *
     * @var string
     */
    protected $mapBasePath;

    /**
     * Settings constructor.
     *
     * @param string $lang ISO 639-1 language code
     * @param string $system transliteration system
     * @see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     */
    public function __construct($lang, $system = self::SYSTEM_DEFAULT) {
        $this->setLang($lang)
          ->setSystem($system)
          ->setMapBasePath(__DIR__ . DIRECTORY_SEPARATOR . 'data');
    }

    /**
     * Get path to map file depending on current settings.
     *
     * @return string path to map file
     */
    public function getMapFilePath() {
        return sprintf(
            '%s.php',
            $this->mapBasePath .
            DIRECTORY_SEPARATOR .
            $this->getLang().
            DIRECTORY_SEPARATOR .
            $this->getSystem()
        );
    }

    /**
     * Set base path to map files.
     *
     * @param string $mapBasePath path to map files
     * @return Transliterator fluent interface
     */
    public function setMapBasePath($mapBasePath) {
        $this->mapBasePath = rtrim($mapBasePath, DIRECTORY_SEPARATOR);

        return $this;
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
     * @return Settings fluent interface
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
     * @return Settings fluent interface
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
            self::LANG_UK,
            self::LANG_BG,
            self::LANG_EL
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
                    self::SYSTEM_ISO_R_9_1968,
                    self::SYSTEM_GOST_1971,
                    self::SYSTEM_GOST_1983,
                    self::SYSTEM_GOST_2002,
                    self::SYSTEM_ALA_LC,
                    self::SYSTEM_British_Standard,
                    self::SYSTEM_BGN_PCGN,
                    self::SYSTEM_Passport_2003
                ));
            break;
            case self::LANG_BE:
                return array_merge($default, array(
                    self::SYSTEM_ALA_LC,
                    self::SYSTEM_BGN_PCGN,
                    self::SYSTEM_ISO_9,
                    self::SYSTEM_National_2000
                ));
            break;
            case self::LANG_MK:
                return array_merge($default, array(
                    self::SYSTEM_ISO_9_1995,
                    self::SYSTEM_BGN_PCGN,
                    self::SYSTEM_ISO_9_R_1968_National_Academy,
                    self::SYSTEM_ISO_9_R_1968_b
                ));
            break;
            case self::LANG_UK:
                return array_merge($default, array(
                    self::SYSTEM_ALA_LC,
                    self::SYSTEM_British,
                    self::SYSTEM_BGN_PCGN,
                    self::SYSTEM_ISO_9,
                    self::SYSTEM_National,
                    self::SYSTEM_GOST_1971,
                    self::SYSTEM_GOST_1986,
                    self::SYSTEM_Derzhstandart_1995,
                    self::SYSTEM_Passport_2004,
                    self::SYSTEM_Passport_2007,
                    self::SYSTEM_Passport_2010
                ));
            break;
            case self::LANG_BG:
                return $default;
            break;
            case self::LANG_EL:
                return $default;
            break;
        }

        return $default;
    }
}