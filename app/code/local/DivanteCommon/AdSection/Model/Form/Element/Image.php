<?php
/**
 * Created by JetBrains PhpStorm.
 * User: msznurawa
 * Date: 19.02.13
 * Time: 14:45
 * To change this template use File | Settings | File Templates.
 */

class DivanteCommon_AdSection_Model_Form_Element_Image extends Varien_Data_Form_Element_Image {

    /**
     * Dirty hack for hardcoded class name in Varien_Data_Form_Element_Image
     * @param $classname
     * @return Varien_Data_Form_Element_Abstract
     */
    public function setClass($classname) {
        if ('input-file'==$classname) {
            return $this->addClass($classname);
        }
        else {
            return parent::setClass($classname);
        }
    }

}
