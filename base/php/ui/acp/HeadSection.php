<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 01.09.2014
 * Time: 19:40
 */

class base_ui_acp_HeadSection extends base_ui_site_HeadSection
{
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