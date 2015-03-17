<?php
class DivanteCommon_AdSection_Block_Adminhtml_Section extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_section';
        $this->_blockGroup = 'divantecommon_adsection';
        $this->_headerText = Mage::helper('divantecommon_adsection')->__('Advertising sections');
        $this->_addButtonLabel = Mage::helper('divantecommon_adsection')->__('Add Section');
        parent::__construct();
    }

}
