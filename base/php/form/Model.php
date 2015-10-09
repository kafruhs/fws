<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 14:53
 */

class base_form_Model
{
    const METHOD_POST = 'post';

    const METHOD_GET  = 'get';

    const FORM_AJAX   = 'ajaxForm';

    /**
     * @var BaseObject
     */
    protected $obj;

    /**
     * @var string
     */
    protected $class = 'input';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $submitLabel;

    /**
     * @var string
     */
    protected $displayMode;

    /**
     * @var base_form_Input
     */
    protected $elements = array();

    /**
     * @param BaseObject $obj
     */
    public function __construct(BaseObject $obj, $displayMode)
    {
        $this->obj = $obj;
        $this->setDisplayMode($displayMode);
        $this->setFormElements();
    }

    /**
     * set all form elements identified by fieldinfo
     */
    public function setFormElements()
    {
        $fieldinfos = $this->getFieldsForInput();
        foreach ($fieldinfos as $fieldinfo) {
            $input = base_form_element_Factory::createElement($fieldinfo);
            $value = '';
            $defaultValue = $fieldinfo->getDefaultValue();
            if (!empty($defaultValue)) {
                $value = $defaultValue;
            }
            if (isset($this->obj[$fieldinfo->getFieldName()])) {
                $value = $this->obj->getField($fieldinfo->getFieldName());
            }
            $input->setValue($value);
            $input->setDisplayedLength($fieldinfo->getDisplayedLength());
            $input->setName($fieldinfo->getFieldName());
            $dClName = 'base_displayclass_' . ucfirst($fieldinfo->getDisplayClass());
            /** @var DisplayClass $dCl */
            $dCl = new $dClName($this->obj);
            $displaymode = $dCl->getDisplayMode($this->getDisplayMode());
            $input->setDisplayMode($displaymode);
            $this->_addFormElement($input, $fieldinfo->getFieldLabel());
        }
    }

    /**
     * @return base_form_Input[]
     */
    public function getFormElements()
    {
        return $this->elements;
    }

    /**
     * @param base_form_Input $input
     * @param $label
     */
    private function _addFormElement(base_form_Input $input, $label)
    {
        $this->elements[$label] = $input;
    }

    /**
     * @return BaseObject
     */
    public function getObj()
    {
        return $this->obj;
    }

    /**
     * @return string
     */
    public function getSubmitLabel()
    {
        return $this->submitLabel;
    }

    /**
     * @param string $submitLabel
     */
    public function setSubmitLabel($submitLabel)
    {
        $this->submitLabel = $submitLabel;
    }

    /**
     * @return string
     */
    public function getDisplayMode()
    {
        return $this->displayMode;
    }

    /**
     * @param string $displayMode
     * @return string
     */
    public function setDisplayMode($displayMode)
    {
        if (in_array($displayMode, array(DisplayClass::EDIT, DisplayClass::HIDE, DisplayClass::VIEW))) {
            $this->displayMode = $displayMode;
        } else {
            $this->displayMode = DisplayClass::VIEW;
        }
    }


    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     */
    public function addClass($class)
    {
        $this->class .= ' ' .$class;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function addAction($action)
    {
        $this->action .= $action;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @throws base_form_Exception
     */
    public function setMethod($method)
    {
        if (!in_array($method, array(self::METHOD_GET, self::METHOD_POST))) {
            throw new base_form_Exception(TMS(base_form_Exception::NO_VALID_FORM_METHOD));
        }
        $this->method = $method;
    }

    /**
     * this form sends an ajax call
     */
    public function setAjaxForm($ajaxControllerName)
    {
        $this->class  .= ' ' . self::FORM_AJAX;
        $this->action = HTML_ROOT . '/de/ajax.php?controller=' . $ajaxControllerName;
    }

    /**
     * get the fieldinfos for the object in scope
     *
     * @return Fieldinfo[]
     */
    public function getFieldsForInput()
    {
        return $this->obj->getAllFields();
    }



}