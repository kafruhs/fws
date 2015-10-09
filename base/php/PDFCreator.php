<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.04.2015
 * Time: 17:29
 */

require_once ROOT . '/modules/base/extlib/tcpdf/tcpdf.php';

class PDFCreator extends TCPDF
{
    /**
     * @var BaseObject[]   data of the table
     */
    protected $data = [];

    /**
     * @var int[]
     */
    protected $cellWidths = [];

    /**
     * @var string  Path to the created PDF document
     */
    protected $path;

    public function __construct()
    {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('MedEXchange');
        $this->SetTitle('TCPDF Example 011');
        $this->SetSubject('TCPDF Tutorial');
        $this->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
        $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// set font
        $this->SetFont('Times', '', 10);

// add a page
        $this->AddPage();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param array $data
     * @throws base_exception_BasePDF
     */
    public function setTableData(array $data)
    {
        foreach ($data as $obj) {
            if (!$obj instanceof BaseObject) {
                throw new base_exception_BasePDF(TMS(base_exception_BasePDF::DATA_NO_INSTANCEOF_BASEOBJECT));
            }
        }
        $this->data = $data;
    }

    /**
     * create the table
     */
    public function createTable() {
        $this->_getCellWidth();
        $this->_createTableHeader(current($this->data));
        $this->Ln();
        $this->_createTableBody();
    }

    public function createPageIntro()
    {
        $this->Cell(180, 15, 'Should be overwritten', 0, 1, 'R');
    }

    public function Output($name = 'doc.pdf', $dest = 'F', $description = '')
    {
        DB::beginTransaction();
        $file = Factory::createObject('file');
        $path = ROOT . "/files/order/" . $name;
        $file['name'] = $name;
        $file['link'] = HTML_ROOT . '/files/order/' . $name;
        $obj = $this->data[0];
        if (empty($description)) {
            $description = "PDF vom " . date("d.m.Y H:i:s", time()) . " Uhr zur Objekt-Klasse " . get_class($obj);
        }
        $file['description'] = $description;

        $file->save();
        DB::endTransaction();

        parent::Output($path, $dest);
        $this->path = $path;
    }

    private function _getCellWidth()
    {
        $obj = $this->data[0];
        $fields = $obj->getFieldsForPDF();

        foreach ($fields as $field) {
            $fieldLabel = $obj->getFieldinfo($field)->getFieldLabel();
            $width = $this->GetStringWidth($fieldLabel, '', 'B', 12);
            foreach ($this->data as $object) {
                $width = max($width, $this->GetStringWidth($object->getField($field), '', '', 9));
            }
            $this->cellWidths[$fieldLabel] = $width;
        }
        $this->cellWidths['Gesamt'] = 10;

        $widthSum = array_sum($this->cellWidths);
        if ($widthSum != 180) {
            foreach ($this->cellWidths as $fieldLabel => $width) {
                $this->cellWidths[$fieldLabel] = ($width / $widthSum) * 180;
            }
        }
    }

    /**
     * create the Header of the Table
     *
     * @param BaseObject $obj
     */
    private function _createTableHeader(BaseObject $obj)
    {
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('', 'B');

//        $fieldLabels = [];
//
//        foreach ($obj->getFieldsForPDF() as $fieldName) {
//            $fi = $obj->getFieldinfo($fieldName);
//            $width += $fi->getDisplayedLength();
//            $cellProperties[$fi->getFieldLabel()] = $fi->getDisplayedLength();
//        }

        $i = 0;
        foreach ($this->cellWidths as $label => $width) {
            $this->Cell($width, 7, $label, 0, 0, 'C', 1);
            $i++;
        }
    }

    /**
     * create the Body of the table
     */
    private function _createTableBody()
    {
        $this->SetFont('');
        $fill = false;
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('', '', 8);

        $sum = 0;
        $border = 'T';
        foreach ($this->data as $obj) {
            $align = 'L';
            $fieldsForPDF = $obj->getFieldsForPDF();
            foreach ($fieldsForPDF as $field) {
                $label = $obj->getFieldinfo($field)->getFieldLabel();
                $this->Cell($this->cellWidths[$label], 6, $obj->getField($field), $border, 0, $align, $fill);
                $align = 'R';
            }
            $price = $obj['price'];
            $amount = $obj['amount'];
            $totalPrice = $price * $amount;
            $sum += $totalPrice;
            $price = number_format($totalPrice, 2, ',', '.');
            $this->Cell($this->cellWidths['Gesamt'], 6, $price, $border, 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
            $border = 0;
        }
        $this->Cell(180, 7, '', 'T');
        $this->Ln();
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('', 'B', 12);
        $this->Cell(180, 7, 'Gesamtbetrag: ' . number_format($sum, 2, ',', '.') . " €", 0, 0, 'R');
        $this->Ln(20);
    }
}