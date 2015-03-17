<?php
class DivanteCommon_AdSection_Block_Adminhtml_Section_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_objectId = 'section_id';
        $this->_blockGroup = 'divantecommon_adsection';
        $this->_controller = 'adminhtml_section';
        $this->_headerText = $this->__('Adsection Section');
        parent::_construct();
    }

}
