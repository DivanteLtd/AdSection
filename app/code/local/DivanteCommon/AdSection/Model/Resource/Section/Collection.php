<?php
class DivanteCommon_AdSection_Model_Resource_Section_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('divantecommon_adsection/section');
        parent::_construct();
    }

}
