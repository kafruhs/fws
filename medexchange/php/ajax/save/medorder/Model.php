<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.01.2015
 * Time: 08:23
 */

class medexchange_ajax_save_medorder_Model extends base_ajax_Model
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $mails = [];

    /**
     * @return bool
     */
    protected function isExecuteable()
    {
        return true;
    }

    /**
     * execute the actual ajax request
     */
    protected function executeRequest()
    {
        $requestHelper = $this->controller->getRequestHelper();
        $lks = $requestHelper->getParam('LK');
        $amounts = $requestHelper->getParam('orderAmount');

        $dbObj = base_database_connection_Mysql::get();
        $dbObj->beginTransaction();

        for ($i = 0; $i < count($lks); $i++) {
            $lk = $lks[$i];
            $amount = $amounts[$i];
            $medOffer = $this->calcNewOfferAmount($lk, $amount);
            $medOrder = $this->_createMedOrder($medOffer, $amount);
            $this->mails['offer'][$medOffer['firstEditor']][] = $medOrder;
            $this->mails['order'][] = $medOrder;
        }
        $this->msg = $this->errors[0];
        if (count($this->errors) == 0) {
            $dbObj->doCommit();
            $this->_sendMails();
            $this->returnCode = self::PROCEED_TO_NEXT_PAGE;
            $this->msg = "Ihre Bestellung wurde aufgegeben. Bitte überprüfen Sie Ihre Emails.";
            return;
        }
        $dbObj->doRollback();
        $this->returnCode = self::STAY_ON_ACTUAL_PAGE;
//        $this->msg = implode('<br />', $this->errors);
    }

    /**
     * calculae new offerAmount and save the MedOffer object
     *
     * @param $lk
     * @param $amount
     * @return MedOffer
     */
    private function calcNewOfferAmount($lk, $amount)
    {
        $medOffer = Factory::loadObject('medOffer', $lk);
        $medOffer['offerAmount'] = $medOffer['offerAmount'] - $amount;

        try {
            $medOffer->save();
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }
        return $medOffer;
    }

    /**
     * create the new MedOrder object and fill with data from MedOffer
     *
     * @param MedOffer  $medOffer
     * @param int       $amount
     *
     * @return MedOrder
     */
    private function _createMedOrder(MedOffer $medOffer, $amount)
    {
        $obj = Factory::createObject('medOrder');
        $obj['FK_medoffer'] = $medOffer->getLogicalKey();
        $obj['amount'] = $amount;
        $obj['price'] = $medOffer['price'] * (1 - $medOffer['rabatt'] / 100);
        $obj['sellerId'] = $medOffer['firstEditor'];
        $obj['pzn'] = $medOffer['pzn'];
        $obj['name'] = $medOffer['name'] . ' ' . $medOffer['amount'] . ' ' . $medOffer['dosage'];

        try {
            $obj->save();
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }

        return $obj;
    }

    /**
     * send mails to the seller and buyer
     */
    private function _sendMails()
    {
        $sellers = array_keys($this->mails['offer']);
        foreach ($sellers as $seller) {
            $medorders = $this->mails['offer'][$seller];
            $pdf = $this->_createSellerPDF($medorders);
            $this->_createSellerMail($seller, $pdf);
            /** @todo Mailer für Offer/Order bauen, PDF Klasse, ... */
        }
        $medOrders = $this->mails['order'];
        $buyer = $medOrders[0]['firstEditor'];
        $pdf = $this->_createBuyerPDF($medOrders);
        $this->_createBuyerMail($buyer, $pdf);

    }

    /**
     * create the pdf file for the seller
     *
     * @param MedOrder[] $medOrders
     * @return medexchange_pdf_medorder_SellerPDF
     * @throws base_exception_BasePDF
     */
    private function _createSellerPDF(array $medOrders)
    {
        $obj = $medOrders[0];
        $firstEditor = $obj->getField('firstEditor');
        $seller = $obj->getField('sellerId');
        $name = date('YmdHm', time()) . '_' . $firstEditor . '_' . $seller . '.pdf';
        $pdf = new medexchange_pdf_medorder_SellerPDF();
        $pdf->setTableData($medOrders);
        $pdf->createPageIntro();
        $pdf->createTable();
        $pdf->Output($name, 'F', "Transaktion zwischen $firstEditor und $seller");
        return $pdf;
    }

    /**
     * @param $seller
     * @param $pdf
     * @throws Exception
     * @throws phpmailerException
     */
    private function _createSellerMail($seller, medexchange_pdf_medorder_SellerPDF $pdf)
    {
        $mail = new Mailer();
        $mail->Subject = 'Es wurden Artikel von Ihnen gekauft';
        $sellerObj = Factory::loadObject('user', $seller);
        $mail->Body = "Hallo " . $sellerObj['userid'] . "\n\n";
        $mail->Body .= "es wurden Artikel von Ihnen gekauft. Bitte ueberpruefen Sie das Dokument im Anhang.\n\n";
        $mail->Body .= "Mit freundlichen Gruessen \n\nIhr medEXchange-Team";
        $mail->addAddress($sellerObj['email']);
        $mail->addAttachment($pdf->getPath());
        $mail->send();
    }
    /**
     * @param $seller
     * @param $pdf
     * @throws Exception
     * @throws phpmailerException
     */
    private function _createBuyerMail($buyer, medexchange_pdf_medorder_BuyerPDF $pdf)
    {
        $mail = new Mailer();
        $mail->Subject = 'Sie haben Artikel gekauft';
        $buyerObj = Factory::loadObject('user', $buyer);
        $mail->Body = "Hallo " . $buyerObj['userid'] . "\n\n";
        $mail->Body .= "es wurden Artikel von Ihnen gekauft. Bitte ueberpruefen Sie das Dokument im Anhang.\n\n";
        $mail->Body .= "Mit freundlichen Gruessen \n\nIhr medEXchange-Team";
        $mail->addAddress($buyerObj['email']);
        $mail->addAttachment($pdf->getPath());
        $mail->send();
    }

    /**
    * create the pdf file for the seller
    *
    * @param MedOrder[] $medOrders
    * @return medexchange_pdf_medorder_SellerPDF
    * @throws base_exception_BasePDF
    */
    private function _createBuyerPDF(array $medOrders)
    {
        $obj = $medOrders[0];
        $firstEditor = $obj->getField('firstEditor');
        $seller = $obj->getField('sellerId');
        $name = date('YmdHm', time()) . '_' . $firstEditor . '_' . $seller . '.pdf';
        $pdf = new medexchange_pdf_medorder_BuyerPDF();
        $pdf->setTableData($medOrders);
        $pdf->createPageIntro();
        $pdf->createTable();
        $pdf->Output($name, 'F', "Transaktion zwischen $firstEditor und $seller");
        return $pdf;
    }

}