<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.11.2014
 * Time: 13:09
 */

class base_ui_acp_Header extends base_ui_site_Header
{
    /**
     * display the header div
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $od->addContent(Html::startTag('body'));
        $od->addContent(Html::startTag('div', array('class' => 'acpPageStructure')) . "\n");
        $od->addContent(Html::startTag('div', array('class' => $this->getCssClass())) . "\n");
        $od->addContent($this->getContent());
        $od->addContent(Html::endTag('div'));
    }
}