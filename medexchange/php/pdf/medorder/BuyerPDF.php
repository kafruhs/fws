<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.04.2015
 * Time: 10:02
 */

class medexchange_pdf_medorder_BuyerPDF extends PDFCreator
{
    public function createPageIntro()
    {
        $obj = $this->data[0];
        $seller = Factory::loadObject('user', $obj['sellerId']);
        $buyer = Factory::loadObject('user', $obj['firstEditor']);
        $this->Cell(180, 15, 'Guten Tag ' . $buyer['userid'], 0, 1, 'L');
        $this->Cell(180, 7, 'Sie haben folgende Artikel gekauft.', 0, 1, 'L');
        $this->Cell(180, 7, 'Bitte setzen Sie sich mit den Verkäufern in Verbindung', 0, 1, 'L');
        $this->Ln(15);
    }
}