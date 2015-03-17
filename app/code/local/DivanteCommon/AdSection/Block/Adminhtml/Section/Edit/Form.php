<?php
class DivanteCommon_AdSection_Block_Adminhtml_Section_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('adsection_form');
        $this->setTitle(Mage::helper('divantecommon_adsection')->__("Section"));
    }

    protected function _prepareForm()
    {
        /** @var $model DivanteCommon_AdSection_Model_Section */
        $model = Mage::registry('adsection_section');

        $form = new Varien_Data_Form(array('id' => 'edit_form',
            'action' => $this->getUrl('*/*/save'), 'method' => 'post'));

        $form->setHtmlIdPrefix('option_');
        $fieldset = $form->addFieldset("base_fieldset", array('legend'=>Mage::helper('cms')->__('General Information'), 'class' => 'fieldset-wide'));

        if($model->getId()) {
            $fieldset->addField('section_id', 'hidden', array(
                'name' => 'section_id',
                'required' => false,
                'value' => $model->getId()
            ));
        }

        $fieldset->addField('identifier', 'text', array(
            'name' => 'identifier',
            'label' => $this->__("Identifier"),
            'title' => $this->__("Identifier"),
            'required' => true
        ));

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => $this->__("Name"),
            'title' => $this->__("Name"),
            'required' => true
        ));

        $fieldset->addField('description', 'editor', array(
            'name' => 'description',
            'label' => $this->__("Description"),
            'title' => $this->__("Description"),
            'required' => false
        ));

        $form->setUseContainer(true);
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }


}
