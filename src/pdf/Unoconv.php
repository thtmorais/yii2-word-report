<?php

/**
 * @package   yii2-word-report
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2021
 * @version   1.0.0
 */

namespace kartik\wordreport\pdf;

use kartik\wordreport\utils\Converter;
use Yii;

/**
 * Unoconv PDF conversion library
 * @package kartik\wordreport
 */
class Unoconv extends Converter
{
    /**
     * @var string the name of the binary
     */
    public $binary = '/usr/bin/unoconv';

    /**
     * @var string the name of the profile folder location
     */
    public $profile = '/tmp/kv-pdf-unoconv';

    /**
     * Convert the document to PDF using `unoconv` executable
     */
    public function convert()
    {
        $this->validateArgs();
        if (!empty($this->profile)) {
            $profile = trim(Yii::getAlias($this->profile), "/\\");
            $this->setCommand([
                'preExecuteScript' => "export HOME={$profile}"
            ]);
        }
        $this->args['--format'] = 'pdf';
        $this->args['--output'] = Yii::getAlias($this->output);
        $this->args[' '] = Yii::getAlias($this->input);
        $this->runBinary();
    }
}