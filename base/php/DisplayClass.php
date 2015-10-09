<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 15:23
 */
abstract class DisplayClass
{
    const EDIT = 'edit';

    const VIEW = 'view';

    const HIDE = 'hide';

    /**
     * @var BaseObject
     */
    protected $obj;

    public function __construct(BaseObject $obj)
    {
        if ($this->checkObjClass($obj) == false) {
            throw new base_displayclass_Exception(TMS(base_displayclass_Exception::NOT_SUPPORTED_CLASS, array('class' => get_class($obj), 'displayClass' => get_class($this))));
        }
        $this->obj = $obj;
    }

    /**
     * checks for the correct class to avoid errors
     *
     * @param BaseObject $obj
     * @return bool
     */
    public function checkObjClass(BaseObject $obj)
    {
        return $obj instanceof BaseObject;
    }

    /**
     * get the displayMode for the actual field in scope
     *
     * @param $displayMode string
     * @return string
     */
    abstract public function getDisplayMode($displayMode);
}