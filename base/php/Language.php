<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 01.09.2014
 * Time: 21:17
 */

class Language implements base_interface_Singleton
{
    const DEUTSCH = 'de';

    const ENGLISH = 'en';

    /**
     * @var null|Language
     */
    protected static $_instance = null;

    /**
     * @var array
     */
    protected $possibleLanguages = [
        self::DEUTSCH,
        self::ENGLISH
    ];

    /**
     * @var string
     */
    protected $selectedLanguage = self::DEUTSCH;

    public static function get()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * set a language for displaying
     *
     * @param $language
     * @throws BaseException
     */
    public function setSelectedLanguage($language)
    {
        if (in_array($language, $this->getPossibleLanguages()) === false) {
           throw new BaseException(TMS(BaseException::LANGUAGE_NOT_SUPPORTED, array('language' => $language)));
        }
        $this->selectedLanguage = $language;
    }

    /**
     * get the selected language
     *
     * @return string
     */
    public function getSelectedLanguage()
    {
        return $this->selectedLanguage;
    }

    /**
     * get all possible languages
     *
     * @return array
     */
    public function getPossibleLanguages()
    {
        return $this->possibleLanguages;
    }
} 