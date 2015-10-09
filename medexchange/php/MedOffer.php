<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.03.2015
 * Time: 07:18
 */

class MedOffer extends BaseObject
{
    protected $table = 'medOffer';

    protected $fieldsForOfferPage = array(
        'firstEditor',
        'FK_vendor',
        'name',
        'pzn',
        'price',
        'mwst',
        'offerAmount',
        'rabatt'
    );

    protected $stdSearchColumns = [
        'FK_vendor',
        'name',
        'pzn',
        'price',
        'mwst',
        'offerAmount',
        'rabatt'
    ];

    /**
     * @return array
     */
    public function getFieldsForOfferPage()
    {
        return $this->fieldsForOfferPage;
    }


}