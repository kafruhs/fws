<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 01.09.2014
 * Time: 19:40
 */

class base_ui_site_HeadSection
{
    const ENCODING_UTF8 = 'utf8';

    const ENCODING_LATIN = 'latin1';

    protected $encoding = self::ENCODING_UTF8;

    protected $doctype = '<!DOCTYPE html>';

    protected $language;

    protected $title;

    protected $description;

    protected $links = [];

    protected $scripts = [];

    public function __construct()
    {
        $this->language = Language::get()->getSelectedLanguage();
    }

    /**
     * get the meta tag for the description of the page. Insert a short but informative text.
     * This text is search by search engines like google
     *
     * @return string
     */
    public function getDescriptionTag()
    {
        return Html::singleTag('meta', array('name' => 'description', 'content' => $this->description));
    }

    /**
     * Insert a short but informative text for the description of the page.
     * This text is search by search engines like google
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * get the doctype of the page.
     * Standard: <!DOCTYPE html> for html5
     *
     * @return string
     */
    public function getDoctypeTag()
    {
        return $this->doctype;
    }

    /**
     * set a new doctype for the page
     * Standard: <!DOCTYPE html> for html5
     *
     * @param string $doctype
     */
    public function setDoctype($doctype)
    {
        $this->doctype = $doctype;
    }

    /**
     * get the encoding of the page
     * Standard: utf8
     *
     * @return string
     */
    public function getEncodingTag()
    {
        return Html::singleTag('meta', array('charset' => $this->encoding));
    }

    /**
     * set the encoding of the page
     *
     * @param string $encoding
     * @throws base_ui_model_Exception
     */
    public function setEncoding($encoding = base_ui_site_HeadSection::ENCODING_UTF8)
    {
        if (in_array($encoding, [self::ENCODING_LATIN, self::ENCODING_UTF8]) === false) {
            throw new base_ui_model_Exception(TMS(base_ui_model_Exception::NO_VALID_ENCODING, array('encoding' => $encoding)));
        }
        $this->encoding = $encoding;
    }

    /**
     * @return string
     */
    public function getHtmlTag()
    {
        return Html::startTag('html', array('lang' => $this->language));
    }

    /**
     * set the language for the page
     *
     * @param string $language
     * @throws BaseException
     */
    public function setLanguage($language)
    {
        if (in_array($language, Language::get()->getPossibleLanguages()) === false) {
            throw new BaseException(TMS(BaseException::LANGUAGE_NOT_SUPPORTED, array('language' => $language)));
        }
        $this->language = $language;
    }

    /**
     * get the title tag of the page
     *
     * @return string
     */
    public function getTitleTag()
    {
        return Html::startTag('title') . $this->title . Html::endTag('title');
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * add a new css file
     *
     * @param $path
     */
    public function addCSSLink($path)
    {
        $this->links[] = Html::singleTag('link', array('rel' => 'stylesheet', 'type' => 'text/css', 'href' => $path));
    }

    public function getCSSLink()
    {
        $this->addCSSLink(HTML_ROOT . '/modules/base/extlib/jquery-multiselect/css/common.css');
        $this->addCSSLink(HTML_ROOT . '/modules/base/extlib/jquery-multiselect/css/ui.multiselect.css');
        $this->addCSSLink(HTML_ROOT . '/modules/base/extlib/jquery-ui/jquery-ui.theme.css');
        $this->addCSSLink(HTML_ROOT . '/modules/base/extlib/jquery-ui/jquery-ui.structure.css');
        $this->addCSSLink(HTML_ROOT . '/modules/base/extlib/jquery-ui/jquery-ui.css');
        $this->addCSSLink(HTML_ROOT . '/modules/base/extlib/jqGrid/css/ui.jqgrid.css');
        $cssFiles = base_infrastructure_Folder::getFilesFromFolder('css');
        foreach ($cssFiles as $file) {
            if ($file == 'custom.css') {
                continue;
            }
            $this->addCSSLink(HTML_ROOT . '/css/' . $file);
        }
        if (file_exists(ROOT . '/css/custom.css')) {
            $this->addCSSLink(HTML_ROOT . '/css/custom.css');
        }
        return implode("\n\t\t", $this->links);
    }

    /**
     * add a new javascript file
     */
    public function addJavaScript($path)
    {
        $this->scripts[] = Html::startTag('script', array('src' => $path, 'type' => 'text/javascript')) . Html::endTag('script');
    }

    /**
     * get all scripts
     *
     * @return string
     */
    public function getScripts()
    {
        $jsFiles = base_infrastructure_Folder::getFilesFromFolder('js');
        $this->addJavaScript(HTML_ROOT . '/modules/base/extlib/jquery-2.1.3.min.js');
        $this->addJavaScript(HTML_ROOT . '/modules/base/extlib/jquery-form.js');
        $this->addJavaScript(HTML_ROOT . '/modules/base/extlib/jquery-validate.min.js');
        $this->addJavaScript(HTML_ROOT . '/modules/base/extlib/jquery-ui/jquery-ui.min.js');
        $this->addJavaScript(HTML_ROOT . '/modules/base/extlib/jquery-multiselect/js/ui.multiselect.js');
        $this->addJavaScript(HTML_ROOT . '/modules/base/extlib/jqGrid/src/i18n/grid.locale-de.js');
        $this->addJavaScript(HTML_ROOT . '/modules/base/extlib/jqGrid/js/jquery.jqGrid.min.js');
        foreach ($jsFiles as $file) {
            $this->addJavaScript(HTML_ROOT . '/js/' . $file);
        }
        return implode("\n\t\t", $this->scripts);
    }

    /**
     * create a string for output with all header information
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $header = $this->getDoctypeTag() . "\n";
        $header .= $this->getHtmlTag() . "\n";
        $header .= Html::startTag('head') . "\n";
        $header .= "\t" . $this->getEncodingTag() . "\n";
        $header .= "\t" . $this->getTitleTag() . "\n";
        $header .= "\t" . $this->getDescriptionTag() . "\n";
        $header .= "\t" . $this->getCSSLink();
        $header .= "\t" . $this->getScripts();
        $header .= Html::endTag('head') . "\n";
        $od->addContent($header);
    }

} 