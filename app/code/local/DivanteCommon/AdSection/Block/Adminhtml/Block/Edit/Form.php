<?php
class DivanteCommon_AdSection_Block_Adminhtml_Block_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _construct()
    {
        parent::_construct();$this->setId('adsection_form');
        $this->setTitle(Mage::helper('divantecommon_adsection')->__("Block"));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('adsection_block');

        $hiddenElements = (array) $this->getParentBlock()->getData('hidden_elements');

        $form = new Varien_Data_Form(array('id' => 'edit_form',
            'action' => $this->getUrl('*/*/save'), 'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array('tab_id' => $this->getTabId())
        );

        $fieldset = $form->addFieldset("base_fieldset", array('legend'=>Mage::helper('cms')->__('General Information'), 'class' => 'fieldset-wide'));
        $fieldset->addType('image','DivanteCommon_AdSection_Model_Form_Element_Image');
        /** @var $helper DivanteCommon_AdSection_Helper_Block */
        $helper = Mage::helper('divantecommon_adsection/block');

        if($model->getId()) {
            $fieldset->addField('block_id', 'hidden', array(
                'name' => 'block_id',
                'required' => false
            ));
        }

        $fieldset->addField('section_id', 'select', array(
            'name'      => 'section_id',
            'label'     => Mage::helper('cms')->__('Section'),
            'title'     => Mage::helper('cms')->__('Section'),
            'required'  => true,
            'options' => Mage::getModel('divantecommon_adsection/section')->getIdsForBlockGrid()
        ));

        $stores = Mage::app()->getStores();
        foreach($stores as $storeId => &$store) {
            /** @var $store Mage_Core_Model_Store */
            $store = Mage::helper('cms')->__(ucfirst($store->getCode()));
        }
        array_unshift($stores, Mage::helper('cms')->__('All'));

        $fieldset->addField('store_id', 'select', array(
            'name'      => 'store_id',
            'label'     => Mage::helper('cms')->__('Store'),
            'title'     => Mage::helper('cms')->__('Store'),
            'required'  => true,
            'options' => $stores
        ));

        $fieldset->addField('additional_identifier', 'text', array(
            'name' => 'additional_identifier',
            'label'     => Mage::helper('cms')->__('Block special identifier'),
            'title'     => Mage::helper('cms')->__('Block special identifier'),
            'required' => false
        ));

        $fieldset->addField('action', 'text', array(
            'name' => 'action',
            'label'     => array_key_exists('action', $hiddenElements) && (bool) $hiddenElements['action'] ? '' : Mage::helper('cms')->__('Action url'),
            'title'     => Mage::helper('cms')->__('Action url'),
            'required' => false,
            'style' => array_key_exists('action', $hiddenElements) && (bool) $hiddenElements['action']
                ? 'display:none;' : ''
        ));

        $editorValue = $model->getType() == DivanteCommon_AdSection_Model_Block::HTML_TYPE
            ? $model->getResource(true)
            : '';
        $fieldset->addField('resource_' . DivanteCommon_AdSection_Model_Block::HTML_TYPE, 'editor', array(
            'name'      => 'resource_' . DivanteCommon_AdSection_Model_Block::HTML_TYPE,
            'required' => false,
            'class' => 'block_resource',
            'style' => 'display:none;',
            'config'    => $wysiwygConfig,
            'wysiwyg' => true
        ));


        $imageValue = $model->getType() == DivanteCommon_AdSection_Model_Block::IMAGE_TYPE
            ? $model->getResource(true)
            : '';
        $fieldset->addField('resource_' . DivanteCommon_AdSection_Model_Block::IMAGE_TYPE, 'image', array(
            'name'      => 'resource_' . DivanteCommon_AdSection_Model_Block::IMAGE_TYPE,
            'required' => false,
            'class' => 'block_resource',
            'style' => 'display:none;',
            'after_element_html' => "
                <style type=\"text/css\">
                    .delete-image { display: none !important; }
                </style>
            "
        ));

        $fieldset->addField('resource_' . DivanteCommon_AdSection_Model_Block::SWF_TYPE, 'file', array(
            'name'      => 'resource_' . DivanteCommon_AdSection_Model_Block::SWF_TYPE,
            'required' => false,
            'class' => 'block_resource',
            'style' => 'display:none;'
        ));

        $fieldset->addField('type', 'select', array(
            'name'      => 'type',
            'label'     =>  array_key_exists('action', $hiddenElements) && (bool) $hiddenElements['type']
                ? '' : Mage::helper('cms')->__('Type'),
            'title'     => Mage::helper('cms')->__('Type'),
            'required'  => ! (array_key_exists('type', $hiddenElements) && (bool) $hiddenElements['type']),
            'options' => $helper->getTypesList(),
            'style' => array_key_exists('type', $hiddenElements) && (bool) $hiddenElements['type']
                ? 'display:none;' : '',
            'after_element_html' => "
                <script type=\"text/javascript\">
                    function checkType() {
                        $$('.block_resource, .input-file').each(function(e){
                            e.setStyle({display: 'none'});
                        });
                        var actionId = 'resource_' + $('type').value + '';
                        var \$action = $(actionId);
                        if(\$action) {
                            \$action.setStyle({display: 'block'});
                            if($('type').value == '2') {
                                jQuery('.area-map').closest('tr').show();
                            } else {
                                jQuery('.area-map').closest('tr').hide();
                            }
                        }
                    }
                    checkType();
                    $('type').observe('change', function(e) {
                        checkType();
                    });
                </script>
            "
        ));

        $fieldset->addField('area_map', 'textarea', array (
            'name'          =>  "area_map",
            'label'         =>  $this->__('Dodatkowy HTML'),
            'required'      =>  false,
            'class'         => 'area-map'
        ));

        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'style' => array_key_exists('position', $hiddenElements) && (bool) $hiddenElements['position']
                ? 'display:none;' : 'width:100px !important;',
            'label'     =>  array_key_exists('position', $hiddenElements) && (bool) $hiddenElements['position']
                ? '' : Mage::helper('cms')->__('Position'),
            'title'     => Mage::helper('cms')->__('Position'),
            'required'  => false
        ));

        $fieldset->addField("is_active", "Checkbox", array(
            "label" => Mage::helper('cms')->__('Is active?'),
            "name" => "is_active",
            "value" => 1,
            "checked" => (bool) $model->isActive() ? 'checked' : ''
        ));

        if($model->getType() == DivanteCommon_AdSection_Model_Block::HTML_TYPE) {
            $model->setData('action_' . DivanteCommon_AdSection_Model_Block::HTML_TYPE, $model->getResource(true));
        }

        $formValues = $model->getData();
        $formValues['resource_' . DivanteCommon_AdSection_Model_Block::HTML_TYPE] = $editorValue;
        $formValues['resource_' . DivanteCommon_AdSection_Model_Block::IMAGE_TYPE] = $imageValue;
        $form->setUseContainer(true);
        $form->setValues($formValues);
        $this->setForm($form);
        return parent::_prepareForm();
    }


}
