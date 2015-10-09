<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.11.2014
 * Time: 07:40
 */

class base_ui_acp_Navigation extends base_ui_site_Navigation
{
    protected function getNaviStructure()
    {
        return [
            "Benutzer"      => [
                "Alle anzeigen" => "frontend.php?controller=base_pages_search_controller_Tablelist&class=user",
                "Neu Anlegen"   => "frontend.php?controller=base_pages_input_controller_BaseObject&class=user&mode=edit",
            ],
            "Gruppen"       => [
                "Alle anzeigen" => "frontend.php?controller=base_pages_search_controller_Tablelist&class=group",
                "Neu Anlegen"   => "frontend.php?controller=base_pages_input_controller_BaseObject&class=group&mode=edit",
            ],
            "Rechte"        => [
                "Alle anzeigen" => "frontend.php?controller=base_pages_search_controller_Tablelist&class=permission",
                "Neu Anlegen"   => "frontend.php?controller=base_pages_input_controller_BaseObject&class=permission&mode=edit",
            ],
            "Navigation"    => [
                "Kategorien anzeigen"    => "frontend.php?controller=base_pages_search_controller_Tablelist&class=navigationCategory",
                "Neue Kategorie anlegen" => "frontend.php?controller=base_pages_input_controller_BaseObject&class=navigationCategory&mode=edit",
                "Einträge anzeigen"      => "frontend.php?controller=base_pages_search_controller_Tablelist&class=navigationEntry",
                "Neuen Eintrag anlegen"  => "frontend.php?controller=base_pages_input_controller_BaseObject&class=navigationEntry&mode=edit",
            ],
            "News"    => [
                "News anzeigen"    => "frontend.php?controller=base_pages_search_controller_Tablelist&class=news",
                "Neue News anlegen" => "frontend.php?controller=base_pages_input_controller_BaseObject&class=news&mode=edit",
            ],
        ];
    }

    public function display(OutputDevice $od)
    {
        $od->addContent(Html::startTag('div', ['class' => 'leftNavigation']));
        foreach ($this->getNaviStructure() as $category => $entries) {
            $od->addContent(Html::startTag('h3') . $category . Html::endTag('h3'));
            $od->addContent(Html::startTag('div'));
            $od->addContent(Html::startTag('ul'));
            foreach ($entries as $entryName => $url) {
                $od->addContent(Html::startTag('li') . Html::url(HTML_ROOT . "/de/acp/$url", $entryName) . Html::endTag('li'));
            }
            $od->addContent(Html::endTag('ul'));
            $od->addContent(Html::endTag('div'));
        }
//        $od->addContent(Html::startTag('div', ['id' => 'leftNavigation']));
//        $od->addContent(Html::startTag('ul', ['id' => 'leftNavigation']));
//        foreach ($this->getNaviStructure() as $category => $content) {
//            if (is_string($content)) {
//                $od->addContent(Html::startTag('li') . Html::url(HTML_ROOT . "/de/acp/$content", $category) . Html::endTag('li'));
//                continue;
//            }
//            $od->addContent(Html::startTag('li') . $category);
//            $od->addContent(Html::startTag('ul'));
//            foreach ($content as $name => $url) {
//                $od->addContent(Html::startTag('li') . Html::url(HTML_ROOT . "/de/acp/$url", $name) . Html::endTag('li'));
//            }
//            $od->addContent(Html::endTag('ul'));
//            $od->addContent(Html::endTag('li'));
//        }
//        $od->addContent(Html::endTag('ul'));
//        $od->addContent('<br style="clear:both" />');

        $od->addContent(Html::endTag('div'));
    }
}