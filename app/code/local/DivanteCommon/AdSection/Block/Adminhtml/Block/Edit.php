<?php
class DivanteCommon_AdSection_Block_Adminhtml_Block_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_objectId = 'block_id';
        $this->_blockGroup = 'divantecommon_adsection';
        $this->_controller = 'adminhtml_block';
        $this->_headerText = $this->__('Adsection Block');
        parent::_construct();
    }

}
