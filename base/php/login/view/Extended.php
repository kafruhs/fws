<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 09.11.2014
 * Time: 19:36
 */

class base_login_view_Extended extends base_ui_view_LeftSideNavigation
{
    /**
     * implements the content of the viewed page
     *
     * @param OutputDevice $od
     */
    protected function addPageContent(OutputDevice $od)
    {
        $table = new base_html_model_Table();
        $form = new base_html_model_Form();

        $cellUsernameLabel = new base_html_model_table_Cell();
        $cellUsernameLabel->setContent($form->label('Benutzername', 'userName'));

        $cellUsernameInput = new base_html_model_table_Cell();
        $cellUsernameInput->setContent($form->textInput('userName'));

        $cellPasswordLabel = new base_html_model_table_Cell();
        $cellPasswordLabel->setContent($form->label('Passwort', 'password'));

        $cellPasswordInput = new base_html_model_table_Cell();
        $cellPasswordInput->setContent($form->passwordInput('password'));

        $row = new base_html_model_table_Row();
        $row->addCell($cellUsernameLabel);
        $row->addCell($cellUsernameInput);

        $row1 = new base_html_model_table_Row();
        $row1->addCell($cellPasswordLabel);
        $row1->addCell($cellPasswordInput);

        $table->addRow($row);
        $table->addRow($row1);

        $od->addContent($form->start(HTML_ROOT . '/de/ajax.php?class=base_login_ajax_DoLogin', 'post', array('class' => 'ajaxForm', 'id' => 'login')));
        $od->addContent($table->toString());
        $od->addContent($form->submitButton('login', 'Einloggen'));
        $od->addContent($form->end());
    }

    /**
     * @return Custom_ui_model_navigation_Default
     */
    public function getNavigation()
    {
        return new Custom_ui_model_navigation_Default();
    }

    public function getHeader()
    {
        return new Custom_ui_model_header_Default();
    }


}