<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.01.2015
 * Time: 11:30
 */

class base_install_Manager implements base_interface_Singleton
{
    /**
     * @var base_install_Manager|null
     */
    private static $_instance = null;

    /**
     * @var base_install_Table[]
     */
    protected $tables;

    /**
     * @var array   array(classname => <path to .csv-file)
     */
    protected $fieldInfos = array();

    /**
     * @var array   array(classname => <path to .csv-file)
     */
    protected $baseObjectData = array();

    /**
     * get a new class instance
     *
     * @return base_install_Manager
     */
    public static function get()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * add a table
     *
     * @param base_install_table $table
     */
    public function addTable(base_install_table $table)
    {
        $this->tables[] = $table;
    }

    /**
     *  execute the table statements to create the tables
     *
     * @param OutputDevice $od
     */
    public function execCreateTables(OutputDevice $od)
    {
        $moduleNames = base_infrastructure_Folder::getFilesFromFolder('modules');
        foreach ($moduleNames as $moduleName) {
            $filePath = ROOT . "/modules/$moduleName/init/tables.php";
            if (file_exists($filePath)) {
                require_once $filePath;
            }
        }
        foreach ($this->tables as $table) {
            $table->insertDatabase();
            base_install_Message::printOut("----- Table '{$table->getName()}' created -----", $od);
        }
    }

    /**
     * import data to fieldinfo table
     *
     * @param OutputDevice $od
     */
    public function execFieldinfoImport(OutputDevice $od)
    {
        $this->_getAllFieldinfoImportFilePaths();
        foreach ($this->fieldInfos as $className => $relevantFile) {
            $importer = new base_importer_csv_Fieldinfo('fieldinfo', $relevantFile, ';');
            $importer->import();
            base_install_Message::printOut("----- Fieldinfo for class '$className' created -----", $od);
        }
    }

    /**
     * import data for extended BaseObjects
     *
     * @param OutputDevice $od
     */
    public function execBaseObjectDataImport(OutputDevice $od)
    {
        $moduleNames = base_infrastructure_Folder::getFilesFromFolder('modules');
        foreach ($moduleNames as $moduleName) {
            $initFolder = "modules/$moduleName/init";
            if (!file_exists(ROOT . '/' . $initFolder)) {
                continue;
            }
            $fileNames = base_infrastructure_Folder::getFilesFromFolder($initFolder);
            $this->_getRelevantFilesForBaseObjects($fileNames, $moduleName);
        }
        foreach ($this->baseObjectData as $relevantFile => $className) {
            $importer = new base_importer_csv_BaseObject($className, $relevantFile, ';');
            $importer->import();
            echo $className;
            base_install_Message::printOut("----- Data for class '$className' created -----", $od);
        }
    }

    /**
     * import data for extended BaseObjects
     *
     * @param OutputDevice $od
     */
    public function execBaseConnectionObjectDataImport(OutputDevice $od)
    {
        $moduleNames = base_infrastructure_Folder::getFilesFromFolder('modules');
        foreach ($moduleNames as $moduleName) {
            $initFolder = "modules/$moduleName/init";
            if (!file_exists(ROOT . '/' . $initFolder)) {
                continue;
            }
            $pathToConnectionObjects = ROOT . '/' . $initFolder . '/connectionObjects.php';
            if (file_exists($pathToConnectionObjects)) {
                include_once $pathToConnectionObjects;
            }

        }
        base_install_Message::printOut("----- Data for connection classes created -----", $od);
    }

    /**
     * import test modules
     *
     * @param OutputDevice $od
     */
    public function execTMSImport(OutputDevice $od)
    {
        $moduleNames = base_infrastructure_Folder::getFilesFromFolder('modules');
        foreach ($moduleNames as $moduleName) {
            $tmsFile = "modules/$moduleName/init/tms.csv";
            if (file_exists(ROOT . '/' . $tmsFile)) {
                $importer = new base_importer_csv_TMSImporter('tms', $tmsFile, ';');
                $importer->import();
                base_install_Message::printOut("----- Text module data created -----", $od);
            }
        }
    }

    /**
     * creates the admin user
     *
     * @param OutputDevice $od
     * @throws base_database_Exception
     */
    public function createAdminUser(OutputDevice $od)
    {
        $user = new User();
        if (!is_null($user->load(1))) {
            return;
        }
        $seq = new Sequence('User');
        $adminData['LK'] = $seq->getNextSequence();
        $adminData['firstEditor'] = 1;
        $dateTime = new base_date_model_DateTime();
        $adminData['firstEditTime'] = $dateTime->toDB();
        $adminData['editor'] = 1;
        $adminData['editTime'] = $dateTime->toDB();
        $adminData['userid'] = 'admin';
        $adminData['password'] = '9118beb30f57be4ef758e0f2e81f12c4';
        $adminData['firstName'] = 'Admin';
        $adminData['lastName'] = 'Admin';
        $adminData['email'] = 'support@faercher-it.de';
        $statement = new base_database_statement_Insert();
        $table = DB::table('user');
        $statement->setTable($table);
        foreach ($adminData as $fieldName => $value) {
            $statement->setColumnValue($table->getColumn($fieldName), DB::term($value));
        }
        $dbObj = base_database_connection_Mysql::get();
        $dbObj->beginTransaction();
        $seq->save();
        $statement->insertDatabase();
        $dbObj->endTransaction();
        base_install_Message::printOut('----- Admin User created -----', $od);
    }
    /**
     * get the files, that are relvant for fieldinfo import
     *
     * @param $fileNames
     * @param $moduleName
     */
    private function _getRelevantFilesForFieldinfo($fileNames, $moduleName)
    {
        foreach ($fileNames as $fileName) {
            echo $fileName . '<br />';
            if (strpos($fileName, '_fields')) {
                $stringParts = explode('_', $fileName);
                $this->fieldInfos[$stringParts[0]] = ROOT . "/modules/$moduleName/init/$fileName";
            }
        }
    }

    /**
     * get the files, that are relvant for baseobject's import
     *
     * @param $fileNames
     * @param $moduleName
     */
    private function _getRelevantFilesForBaseObjects($fileNames, $moduleName)
    {
        foreach ($fileNames as $fileName) {
            if (strpos($fileName, '_data')) {
                $stringParts = explode('_', $fileName);
                $this->baseObjectData[ROOT . "/modules/$moduleName/init/$fileName"] = $stringParts[0];
            }
        }
    }

    private function _getAllFieldinfoImportFilePaths()
    {
        $moduleNames = base_infrastructure_Folder::getFilesFromFolder('modules');
        foreach ($moduleNames as $moduleName) {
            $initFolder = "modules/$moduleName/init";
            if (!file_exists(ROOT . "/" . $initFolder)) {
                continue;
            }
            $fileNames = base_infrastructure_Folder::getFilesFromFolder($initFolder);
            $this->_getRelevantFilesForFieldinfo($fileNames, $moduleName);
        }
    }

    public function copyPages(OutputDevice $od)
    {
        foreach (base_infrastructure_Folder::getFilesFromFolder('modules') as $module) {
            if ($module == 'Custom' || !file_exists(ROOT . "/modules/$module/root/de")) {
                continue;
            }

            foreach (base_infrastructure_Folder::getFilesFromFolder("modules/$module/root/de") as $pageToCopy) {
                if (copy(ROOT . "/modules/$module/root/de/$pageToCopy", ROOT . "/de/$pageToCopy")) {
                    base_install_Message::printOut("----- Die Datei '/modules/$module/root/de/$pageToCopy' wurde erfolgreich kopiert -----", $od);
                }
            }
        }
    }

    public function copyCSS(OutputDevice $od)
    {
        foreach (base_infrastructure_Folder::getFilesFromFolder('modules') as $module) {
            if ($module == 'Custom' || !file_exists(ROOT . "/modules/$module/root/css")) {
                continue;
            }

            foreach (base_infrastructure_Folder::getFilesFromFolder("modules/$module/root/css") as $cssFileToCopy) {
                if (copy(ROOT . "/modules/$module/root/css/$cssFileToCopy", ROOT . "/css/$cssFileToCopy")) {
                    base_install_Message::printOut("----- Die Datei '/modules/$module/root/css/$cssFileToCopy' wurde erfolgreich kopiert -----", $od);
                }
            }
        }

        if (!is_dir(ROOT . '/modules/Custom/root/css')) {
            return;
        }

        foreach (base_infrastructure_Folder::getFilesFromFolder("modules/Custom/root/css") as $cssFileToCopy) {
            if (copy(ROOT . "/modules/Custom/root/css/$cssFileToCopy", ROOT . "/css/$cssFileToCopy")) {
                base_install_Message::printOut("----- Die Datei '/modules/Custom/root/css/$cssFileToCopy' wurde erfolgreich kopiert -----", $od);
            }
        }
    }

    public function copyJS(OutputDevice $od)
    {
        foreach (base_infrastructure_Folder::getFilesFromFolder('modules') as $module) {
            if ($module == 'Custom' || !file_exists(ROOT . "/modules/$module/root/js")) {
                continue;
            }

            foreach (base_infrastructure_Folder::getFilesFromFolder("modules/$module/root/js") as $jsFileToCopy) {
                if (copy(ROOT . "/modules/$module/root/js/$jsFileToCopy", ROOT . "/js/$jsFileToCopy")) {
                    base_install_Message::printOut("----- Die Datei '/modules/$module/root/js/$jsFileToCopy' wurde erfolgreich kopiert -----", $od);
                }
            }
        }

        if (!is_dir(ROOT . '/modules/Custom/root/js')) {
            return;
        }

        foreach (base_infrastructure_Folder::getFilesFromFolder("modules/Custom/root/js") as $jsFileToCopy) {
            if (copy(ROOT . "/modules/Custom/root/js/$jsFileToCopy", ROOT . "/js/$jsFileToCopy")) {
                base_install_Message::printOut("----- Die Datei '/modules/Custom/root/js/$jsFileToCopy' wurde erfolgreich kopiert -----", $od);
            }
        }
    }
}