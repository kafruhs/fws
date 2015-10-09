<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.10.2014
 * Time: 07:09
 */

class Datatype
{
    /**
     */
    const ALPHANUMERIC = 'Alphanumeric';

    /**
     */
    const NUMERIC = 'Numeric';

    const KEY = 'Key';

    const DATETIME = 'Datetime';

    const LK = 'Lk';

    const PASSWORD = 'Password';

    const TEXT = 'Text';

    /**
     * @var Fieldinfo
     */
    protected $fi;

    public function __construct(Fieldinfo $fi)
    {
        $this->fi = $fi;
    }

    /**
     * transform a human readable value to an internal one
     *
     * @param  mixed $value
     * @return mixed
     */
    final public function toInternal($value)
    {
       $this->validate($value);
       return $this->toInternalValue($value);
    }

    /**
     * if value is requested from db, a validation is not needed
     *
     * @param $value
     * @return mixed
     */
    public function fromDB($value)
    {
        return $this->toInternalValue($value);
    }

    /**
     * is overwritten in the different child classes
     *
     * @param $value
     * @return mixed
     */
    protected function toInternalValue($value)
    {
        return $value;
    }

    /**
     * transform a intern value to an db value one
     *
     * @param  mixed $value
     * @return mixed
     */
    public function toDB($value)
    {
       return $value;
    }

    /**
     * transform the given value to an human readable one
     *
     * @param  mixed $value
     * @return mixed
     * @throws base_exception_Validation
     */
    public function toExternal($value)
    {
        return $value;
    }

    public function fromDBToExternal($value)
    {
        return $value;
    }

    /**
     * validate the value
     *
     * @param  mixed $value
     * @return bool
     * @throws base_exception_Validation
     */
    final public function validate($value)
    {
        if ($this->fi->isMandatory() && empty($value) && $value != $this->fi->getDefaultValue()) {
            throw new base_exception_Validation(TMS(base_exception_Validation::MANDATORY_FIELD_EMPTY, array('fieldName' => $this->fi->getFieldLabel())));
        }
        $this->validateValue($value);
    }

    /**
     * is overwritten in the different child classes
     *
     * @param $value
     * @return mixed
     */
    protected function validateValue($value)
    {
        return $value;
    }

    /**
     * @return string
     */
    public function getEmptyValue()
    {
        $value = $this->fi->getDefaultValue();
        if (empty($value)) {
            return '';
        }
        return $value;
    }

    public function getJSColModelElement()
    {
        $colModel = new base_js_ColModelElement();
        $colModel->setName($this->fi->getFieldName())
            ->setIndex($this->fi->getFieldName())
            ->setWidth($this->fi->getDisplayedLength())
            ->setClasses($this->fi->getFieldName())
            ->setEditableTrue();
        return $colModel;
    }
}