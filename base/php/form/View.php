<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.12.2014
 * Time: 15:49
 */

class base_form_View
{
    const SAVE_AND_NEW = 'saveAndNew';

    const SAVE_AND_EDIT = 'saveAndEdit';

    const SAVE_AND_SEARCH = 'saveAndSearch';

    /**
     * @var base_form_Model
     */
    protected $model;

    protected $elements = array();

    public function __construct(base_form_Model $model)
    {
        $this->model = $model;
    }

    public function showStartTag($attributes = array())
    {
        $attributes['class']  = $this->model->getClass();
        $attributes['id']     = $this->model->getId();
        $attributes['method'] = $this->model->getMethod();
        $attributes['action'] = $this->model->getAction();
        return Html::startTag('form', $attributes);
    }

    public function showBody()
    {
        $table = new base_html_model_Table();
        $table->setCssClass('form ' . strtolower(get_class($this->model->getObj())));
        $obj = $this->model->getObj();
        $lkLabel = $obj->getFieldinfo('LK')->getFieldLabel();
        $hiddenInputs = [];
        foreach ($this->model->getFormElements() as $label => $element) {
            if ($element->getDisplayMode() == DisplayClass::HIDE && $label != $lkLabel) {
                continue;
            }
            if ($label == $lkLabel) {
                $hiddenInputs[] = $element;
                continue;
            }
            $row = new base_html_model_table_Row();
            $labelCell = new base_html_model_table_Cell();
            $labelCell->setCssClass('label');
            $labelCell->setContent($label);
            $valueCell = new base_html_model_table_Cell();
            $valueCell->setCssClass('content');
            $valueCell->setContent($element->display());
            $row->addCell($labelCell);
            $row->addCell($valueCell);
            $table->addRow($row);
        }
        $output = $table->toString();
        /** @var base_form_element_Hidden $hiddenInput */
        foreach ($hiddenInputs as $hiddenInput) {
            $output .= $hiddenInput->display();
        }
        return $output;
    }

//    public function showSubmit()
//    {
//        $element = new base_form_element_Submit(new Fieldinfo('BaseObject'));
//        $element->setValue('Speichern');
//        $element->setFormaction($this->model->getAction() . '&referer=' . self::SAVE_AND_EDIT);
//        $formEnd = $element->display();
//        $element = new base_form_element_Submit(new Fieldinfo('BaseObject'));
//        $element->setValue('Speichern und neu');
//        $element->setFormaction($this->model->getAction() . '&referer=' . self::SAVE_AND_NEW);
//        $formEnd .= $element->display();
//        $element = new base_form_element_Submit(new Fieldinfo('BaseObject'));
//        $element->setValue('Speichern und zurück');
//        $element->setFormaction($this->model->getAction() . '&referer=' . self::SAVE_AND_SEARCH);
//        $formEnd .= $element->display();
//        $formEnd .= Html::endTag('form');
//        return $formEnd;
//
//
//
//
//
//
//
//    }
//
    public function showSubmit()
    {
            $save = '';
        if ($this->model->getDisplayMode() == DisplayClass::EDIT) {
            $save .= Html::startTag('div', ['id' => 'editButtons']);
            $action = $this->model->getAction() . '&referer=' . self::SAVE_AND_EDIT;
            $picture = Html::img('buttons/save.png', ['class' => 'button', 'id' => self::SAVE_AND_EDIT]);
//            $save .= Html::url($action, $picture, ['class' => 'submitLink', 'title' => 'Speichern und auf dieser Seite bleiben']);
            $save .= Html::url($action, 'Speichern', ['class' => 'submitLink', 'title' => 'Speichern und auf dieser Seite bleiben']);

            $action = $this->model->getAction() . '&referer=' . self::SAVE_AND_NEW;
            $picture = Html::img('buttons/save_add.png', ['class' => 'button', 'id' => self::SAVE_AND_NEW]);
//            $save .= Html::url($action, $picture, ['class' => 'submitLink', 'title' => 'Datensatz speichern und einen Neuen anlegen']);
            $save .= Html::url($action, 'Speichern und neu', ['class' => 'submitLink', 'title' => 'Datensatz speichern und einen Neuen anlegen']);

            $action = $this->model->getAction() . '&referer=' . self::SAVE_AND_SEARCH;
            $picture = Html::img('buttons/save_go.png', ['class' => 'button', 'id' => self::SAVE_AND_SEARCH]);
//            $save .= Html::url($action, $picture, ['class' => 'submitLink', 'title' => 'Speichern und zur Ergebnisliste']);
            $save .= Html::url($action, 'Speichern und zur Liste', ['class' => 'submitLink', 'title' => 'Speichern und zur Liste']);
            $save .= Html::endTag('div');
        }
        $save .= Html::endTag('form');
        return $save;
    }
}