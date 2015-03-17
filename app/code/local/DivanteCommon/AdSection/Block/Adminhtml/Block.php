<?php
class DivanteCommon_AdSection_Block_Adminhtml_Block extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_block';
        $this->_blockGroup = 'divantecommon_adsection';
        $this->_headerText = Mage::helper('divantecommon_adsection')->__('Advertising blocks');
        $this->_addButtonLabel = Mage::helper('divantecommon_adsection')->__('Add Advertising block');
        parent::__construct();
    }
}
