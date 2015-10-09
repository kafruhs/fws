<?php
/**
 * Created by PhpStorm.
 * User: Mediacenter
 * Date: 01.08.2014
 * Time: 08:33
 */

class BaseException extends Exception
{
    const LANGUAGE_NOT_SUPPORTED = 'base.exception.language.notSupported';

    const HEADLINE = 'base.exception.headline';

    const CLASS_NOT_EXISTS = 'base.exception.classNotExists';

    const CLASS_NOT_INSTANCEOF_BASOBJECT = 'base.exception.classNotInstanceOfBaseObject';

    /**
     * print the backtrace of the exception into the protocol log
     */
    public function debugOut()
    {
        if (isset($_SERVER['argc'])) {
            return;
        }
        $debugTraceArray = $this->getTrace();
        $output = get_class($this) . ': ';
        $output .= $this->getMessage();
        $output .= PHP_EOL . "\t[" . $this->getFile() . '(' . $this->getLine() . ')]';
        foreach ($debugTraceArray as $traceLine) {
            $traceLine = $this->_validateFile($traceLine);
            $traceLine = $this->_validateLine($traceLine);
            $traceLine = $this->_validateFunction($traceLine);
            $output .= PHP_EOL . "\t[" . $traceLine['file'] . ' (' . $traceLine['line'] . ')] ' . $traceLine['function'] . '()';
        }
        Logger::output('protocol.log', $output);
    }

    /**
     * @param $traceLine
     * @return mixed
     */
    private function _validateFile($traceLine)
    {
        if (isset($traceLine['file']) === false) {
            $traceLine['file'] = '** no file set **';
            return $traceLine;
        }
        return $traceLine;
    }

    /**
     * @param $traceLine
     * @return mixed
     */
    private function _validateLine($traceLine)
    {
        if (isset($traceLine['line']) === false) {
            $traceLine['line'] = '** no line set **';
            return $traceLine;
        }
        return $traceLine;
    }

    /**
     * @param $traceLine
     * @return mixed
     */
    private function _validateFunction($traceLine)
    {
        if (isset($traceLine['function']) === false) {
            $traceLine['function'] = '** no function set **';
            return $traceLine;
        }
        return $traceLine;
    }
}