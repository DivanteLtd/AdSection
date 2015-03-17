<?php

class DivanteCommon_AdSection_Model_Resource_Section extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('divantecommon_adsection/section', 'section_id');
    }

}
