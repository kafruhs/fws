<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.03.2015
 * Time: 07:49
 */

class medexchange_importer_csv_Aposoft extends base_importer_csv_BaseObject
{
    protected $mapping = array(
        'Hersteller Name' => 'FK_vendor',
        'TaxEK' => 'price',
        'MwST' => 'mwst',
        'PZN' => 'pzn',
        'Status' => 'type',
        'Artikelbezeichnung' => 'name',
        'Menge' => 'amount',
        'Mengeneinheit' => 'unit',
        'Darreichungsform' => 'dosage',
    );

    protected function loadData($filePath, $delimiter, $hasHeader)
    {
        if(!file_exists($filePath) || !is_readable($filePath)) {
            return;
        }

        $header = null;
        if ($handle = fopen($filePath, 'r')) {
            while ($row = fgetcsv($handle, 1000, $delimiter)) {
                if(!$header && $hasHeader) {
                    foreach ($row as $cell) {
                        if (array_key_exists($cell, $this->mapping)) {
                            $header[] = $this->mapping[$cell];
                        } else {
                            $header[] = $cell;
                        }
                    }
                    continue;
                }

                if (!$header) {
                    $header = $this->obj->getColNamesForImport();
                }
                $lastElement = array_pop($row);
                if (!$lastElement == "") {
                    $row[] = $lastElement;
                }
                $data = array_combine($header, $row);
                $data = $this->removeValuesFromData($data);
                $data = $this->addValuesToData($data);
                $this->data[] = $data;
            }
            fclose($handle);
        }
    }

    protected function removeValuesFromData(array $data)
    {
        foreach (array_keys($data) as $originalValue) {
            $originalNames = array_values($this->mapping);
            if (!in_array($originalValue, $originalNames)) {
                unset($data[$originalValue]);
            }
        }
        return $data;
    }

}