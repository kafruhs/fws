<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.10.2014
 * Time: 07:44
 */

class base_setup_view_Navigation extends base_ui_model_navigation_SideNavigation
{
    const STATE_FINISHED = 'finished';

    const STATE_EDIT     = 'edit';

    const STATE_NEW      = 'new';

    /**
     * @return base_ui_site_Link[]
     */
    protected function getNavigationEntries()
    {
        $linkSettings = new base_ui_site_Link();
        $linkSettings->setControllerName('base_setup_controller_Settings');
        $linkSettings->setDisplayName('Settings');
        $links[] = $linkSettings;

        $linkConfiguration = new base_ui_site_Link();
        $linkConfiguration->setControllerName('base_setup_controller_Configuration');
        $linkConfiguration->setDisplayName('Konfiguration');
        $links[] = $linkConfiguration;

        $linkDatabase = new base_ui_site_Link();
        $linkDatabase->setControllerName('base_setup_controller_Database');
        $linkDatabase->setDisplayName('Datenbank');
        $links[] = $linkDatabase;

        $linkTables = new base_ui_site_Link();
        $linkTables->setControllerName('base_setup_controller_Tables');
        $linkTables->setDisplayName('Tabellen');
        $links[] = $linkTables;

        $linkFieldInfo = new base_ui_site_Link();
        $linkFieldInfo->setControllerName('base_setup_controller_FieldInfo');
        $linkFieldInfo->setDisplayName('Feldinformationen');
        $links[] = $linkFieldInfo;

        $linkDataImport = new base_ui_site_Link();
        $linkDataImport->setControllerName('base_setup_controller_DataImport');
        $linkDataImport->setDisplayName('Datenimport');
        $links[] = $linkDataImport;

        $linkFinished = new base_ui_site_Link();
        $linkFinished->setControllerName('base_setup_controller_Finished');
        $linkFinished->setDisplayName('Ende');
        $links[] = $linkFinished;

        return $links;
    }

    private function _getSetupSteps()
    {
        return array(
            'settings',
            'configuration',
            'database',
            'tables',
            'fieldinfo',
            'dataimport',
            'finshed',
        );
    }

    protected function displayListEntries(OutputDevice $od)
    {
        $counter = 0;
        $actualState = array_search(strtolower(Configuration::get()->getEntry('configStep')), $this->_getSetupSteps());
        $entries = '';
        foreach ($this->getNavigationEntries() as $link) {
            $displayName = $link->getDisplayName();
            if ($counter < $actualState) {
                $class = self::STATE_FINISHED;
            } elseif ($counter == $actualState) {
                $class = self::STATE_EDIT;
            } else {
                $entries .= Html::startTag('li', array('class' => 'naviStep', 'id' => "naviStep_{$link->getControllerName()}"));
                $entries .= $displayName;
                $entries .= Html::endTag('li');
                $counter++;
                continue;
            }
            $attributes = array('class' => $class);
            $href = $link->getHtmlTag($attributes);
            $entries .= Html::startTag('li', array('class' => 'naviStep', 'id' => "naviStep_{$link->getControllerName()}"));
            $entries .= $href;
            $entries .= Html::endTag('li');
            $counter++;
        }
        $od->addContent($entries);
    }
}