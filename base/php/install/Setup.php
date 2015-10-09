<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.07.2015
 * Time: 21:15
 */

class base_install_Setup
{
    const COPY_FILES = 'copyfiles';

    const INSTALL_TABLES = 'tables';

    const INSTALL_DB = 'db';

    const CREATE_USER = 'createadmin';

    const DELETE_CACHE = 'deletecache';

    const IMPORT_FIELDINFO = 'fieldinfo';

    const IMPORT_TMS = 'TMS';

    const IMPORT_DATA = 'data';

    /**
     * @var string
     */
    protected $cmd;

    public function __construct()
    {
        $requestHelper = new RequestHelper();
        $this->cmd = $requestHelper->getParam('cmd');
    }

    /**
     * @param OutputDevice $od
     */
    public function execute(OutputDevice $od)
    {
        $manager = base_install_Manager::get();
        if (!$this->_validateCMD()) {
            $this->_executeAll($od, $manager);
            return;
        }

        switch ($this->cmd) {
            case self::COPY_FILES:
                $this->_copyCSS($od, $manager);
                $this->_copyJS($od, $manager);
                $this->_copyPages($od, $manager);
                break;
            case self::CREATE_USER:
                $this->_createAdmin($od, $manager);
                break;
            case self::DELETE_CACHE:
                $this->_deleteCache($od);
                break;
            case self::IMPORT_DATA:
                $this->_createBaseObjectData($od, $manager);
                break;
            case self::IMPORT_FIELDINFO:
                $this->_createFieldinfo($od, $manager);
                break;
            case self::IMPORT_TMS:
                $this->_createTMS($od, $manager);
                break;
            case self::INSTALL_DB:
                $this->_createDB($od);
                break;
            case self::INSTALL_TABLES:
                $this->_createTables($od, $manager);
                break;
        }
    }

    private function _validateCMD()
    {
        $possibleOptions = [
            self::COPY_FILES,
            self::CREATE_USER,
            self::DELETE_CACHE,
            self::IMPORT_DATA,
            self::IMPORT_FIELDINFO,
            self::IMPORT_TMS,
            self::INSTALL_DB,
            self::INSTALL_TABLES
        ];

        if (in_array($this->cmd, $possibleOptions)) {
            return true;
        }
        return false;
    }

    private function _createFolderStructure(OutputDevice $od)
    {
        $folders = [
            'css',
            'de',
            'files/cache',
            'images',
            'js',
            'logs'
        ];

        base_install_Message::printOut("---- Creating Folder Structure ----", $od);

        foreach ($folders as $folder) {
            if (file_exists(ROOT . "/$folder")) {
                base_install_Message::printOut("----- Folder '$folder'  already exists-----", $od);
                continue;
            }
            mkdir(ROOT . "/$folder", 0777, true);
            base_install_Message::printOut("----- Folder '$folder' created -----", $od);
        }

        base_install_Message::printOut("---- Folder structure created ----", $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    private function _deleteCache(OutputDevice $od)
    {
        base_install_Message::printOut("---- delete cache ----", $od);
        rmdir(ROOT . "/files/cache");
        mkdir(ROOT . "/files/cache");
        base_install_Message::printOut("---- cache deleted ----", $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     */
    private function _createDB(OutputDevice $od)
    {
        $dbName = Configuration::get()->getEntry('dbName');
        base_install_Message::printOut("---- Creating Database $dbName ----", $od);
        $statement = new base_install_CreateDB();
        $statement->insertDatabase();
        base_install_Message::printOut("---- Database $dbName created ----", $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _createTables(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut("---- Creating Tables ----", $od);
        $manager->execCreateTables($od);
        base_install_Message::printOut("---- Tables created----", $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _createTMS(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut("---- Creating Text module data ----", $od);
        $manager->execTMSImport($od);
        base_install_Message::printOut("----  Text module data created ----", $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _createFieldinfo(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut('---- Creating Fieldinfos ----', $od);
        $manager->execFieldinfoImport($od);
        base_install_Message::printOut('---- Fieldinfos created ----', $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _createAdmin(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut('---- Creating Admin User ----', $od);
        $manager->createAdminUser($od);
        User::login('admin', 'serves');
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _createBaseObjectData(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut('---- Filling Baseobject tables ----', $od);
        $manager->execBaseObjectDataImport($od);
        base_install_Message::printOut('---- Baseobject tables filled ----', $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _createConnectionObjects(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut('---- Filling BaseConnectionObject tables ----', $od);
        $manager->execBaseConnectionObjectDataImport($od);
        base_install_Message::printOut('---- BaseConnectionObject tables filled ----', $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _copyPages(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut('---- Copy pages ----', $od);
        $manager->copyPages($od);
        base_install_Message::printOut('---- Pages created ----', $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _copyCSS(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut('---- Create CSS ----', $od);
        $manager->copyCSS($od);
        base_install_Message::printOut('---- CSS created ----', $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param base_install_Manager $manager
     */
    private function _copyJS(OutputDevice $od, base_install_Manager $manager)
    {
        base_install_Message::printOut('---- Create JS ----', $od);
        $manager->copyJS($od);
        base_install_Message::printOut('---- JS created ----', $od);
        $od->addContent('----------------------------------------------------------------------------<br />');
    }

    /**
     * @param OutputDevice $od
     * @param $manager
     */
    private function _executeAll(OutputDevice $od, $manager)
    {
        $this->_createFolderStructure($od);
        $this->_copyPages($od, $manager);
        $this->_copyCSS($od, $manager);
        $this->_copyJS($od, $manager);
        $this->_createDB($od);
        $this->_createTables($od, $manager);
        $this->_createTMS($od, $manager);
        $this->_createFieldinfo($od, $manager);
        $this->_createAdmin($od, $manager);
        $this->_createBaseObjectData($od, $manager);
        $this->_createConnectionObjects($od, $manager);
    }


}