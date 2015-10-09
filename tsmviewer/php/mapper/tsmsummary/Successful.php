<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.02.2015
 * Time: 16:40
 */

class tsmviewer_mapper_tsmsummary_Successful extends base_mapper_BaseObject
{

    /**
     * converts a given value to the specified structure
     *
     * @param $value
     * @return mixed
     */
    public function mapFieldValue($value)
    {
        $failed = $this->currentDataSet['failed'];
        $successful = $this->currentDataSet['successful'];

        if ($successful != 'YES' && $failed = 0) {
            return 3;
        }

        if ($successful != 'YES' && $failed != 0) {
            return 2;
        }

        if ($successful == 'YES' && $failed != 0) {
            return 1;
        }

        return 0;
    }
}