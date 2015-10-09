<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.11.2014
 * Time: 07:40
 */

class base_ui_site_Navigation implements Renderable
{
    protected $catLKName = [];

    protected $naviStructure = [];

    public function loadNaviStructure()
    {
        $table = DB::table(Factory::createObject('navigationCategory')->getTable());
        $order = DB::order($table->getColumn('sort'), base_database_Order::ASC);
        $columnList = [$table->getColumn('name'), $table->getColumn('LK')];
        $cats = Finder::create('navigationCategory')->setOrder($order)->find($columnList);
        foreach ($cats as $catRow) {
            $entriesForCategory = $this->loadEntriesForCategory($catRow['LK']);
            if (!empty($entriesForCategory)) {
                $this->naviStructure[$catRow['name']] = $entriesForCategory;
                $this->catLKName[$catRow['name']] = $catRow['LK'];
            }
        }
    }

    public function loadEntriesForCategory($catLK)
    {
        $navEntry = Factory::createObject('NavigationEntry');
        $table = DB::table($navEntry->getTable());
        $where = DB::where($table->getColumn('category'), DB::intTerm($catLK));
        $entries = Finder::create('navigationEntry')->setWhere($where)->find();
        $relevantEntries = [];
        foreach ($entries as $entry) {
            if ($this->_isEntitledForEntry($entry)) {
                $relevantEntries[] = $entry;
            }
        }
        return $relevantEntries;
    }


    /**
     * @param OutputDevice $od
     */
    public function display(OutputDevice $od)
    {
        $this->loadNaviStructure();
        $od->addContent(Html::startTag('div', array('class' => 'navigationTop')));
        $this->displayCategories($od);
        $od->addContent(Html::endTag('div'));
        $this->displayEntries($od);
    }

    /**
     * @param OutputDevice $od
     */
    protected function displayCategories(OutputDevice $od)
    {
        $od->addContent(Html::startTag('ul', array('id' => 'naviListTop')));
        $this->displayListEntries($od);
        $od->addContent(Html::endTag('ul'));
    }

    /**
     * @param OutputDevice $od
     */
    protected function displayListEntries(OutputDevice $od)
    {
        $entries = '';
        foreach (array_keys($this->naviStructure) as $categoryName) {
            $entries .= Html::startTag('li', array('class' => 'naviCategory', 'id' => "categoryLK_{$this->catLKName[$categoryName]}"));
            $entries .= $categoryName;
            $entries .= Html::endTag('li');
        }
        if (User::isLoggedIn()) {
            $entries .= Html::startTag('li', array('class' => 'naviCategory', 'id' => "logout"));
            $entries .= Html::url(HTML_ROOT . '/de/logout.php', 'Ausloggen');
            $entries .= Html::endTag('li');
        } else {
            $entries .= Html::startTag('li', array('class' => 'naviCategory', 'id' => "login"));
            $entries .= Html::url(HTML_ROOT . '/de/login.php', 'Einloggen');
            $entries .= Html::endTag('li');
        }
        $od->addContent($entries);
    }

    public function displayEntries(OutputDevice $od)
    {
        $output = '';
        foreach ($this->naviStructure as $catName => $entries) {
            $output .= Html::startTag('div', array('class' => 'naviEntry', 'id' => "entryCategoryLK_{$this->catLKName[$catName]}"));
            $output .= Html::startTag('ul', array('class' => 'naviEntries'));
            foreach ($entries as $entry) {
                $output .= $this->_displayEntry($entry);
            }
            $output .= Html::endTag('ul');
            $output .= Html::endTag('div');
        }
        $od->addContent($output);
    }

    private function _displayEntry(NavigationEntry $entry)
    {
        $string = Html::startTag('li', array('class' => 'naviEntry', 'id' => "entryLK_{$entry->getLogicalKey()}"));
        $string .= Html::url(HTML_ROOT . $entry['url'], $entry['name']);
        $string .= Html::endTag('li');
        return $string;
    }

    private function _isEntitledForEntry($entry)
    {
        if ($entry['permission'] == Permission::getPermissionLKByName(Permission::EVERYBODY)) {
            return true;
        }

        $user = Flat::user();
        if (!$user instanceof User) {
            return false;
        }
        return $user->isEntitled($entry['permission']);

    }

}