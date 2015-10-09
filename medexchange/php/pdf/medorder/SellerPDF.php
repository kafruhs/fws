<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.04.2015
 * Time: 09:53
 */

class medexchange_pdf_medorder_SellerPDF extends PDFCreator
{
    public function createPageIntro()
    {
        $obj = $this->data[0];
        $seller = Factory::loadObject('user', $obj['sellerId']);
        $buyer = Factory::loadObject('user', $obj['firstEditor']);
        $this->Cell(180, 15, 'Guten Tag ' . $seller['userid'], 0, 1, 'L');
        $this->Cell(180, 7, 'Es wurden folgende Artikel von ' . $buyer['userid'] . ' gekauft.', 0, 1, 'L');
        $this->Cell(180, 7, 'Bitte setzen Sie sich mit dem Käufer in Verbindung', 0, 1, 'L');
        $this->Ln(15);
    }
}