<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.08.2015
 * Time: 10:38
 */

class base_pages_input_view_BaseObject extends View
{
    public function getPageTitle()
    {
        /** @var BaseObject $obj */
        $obj = $this->controller->getModel()->getObject();
        return "Datenerfassung: " . $obj->getDisplayName();
    }


    /**
     * display the content of this View
     *
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        /** @var base_form_View $formView */
        $formView = $this->controller->getModelData();
        $od->addContent($formView->showStartTag());
        $od->addContent($formView->showBody());
        $od->addContent($formView->showSubmit());
    }

}