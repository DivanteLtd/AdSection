<?php
class DivanteCommon_AdSection_Block_Adminhtml_Block_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->setId("adBlockGrid");
        $this->setDefaultSort('block_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        /** @var $collection DivanteCommon_AdSection_Model_Resource_Block_Collection */
        $collection = Mage::getModel('divantecommon_adsection/block')->getCollection();

        $collection->getSelect()->joinLeft(array(
            'adsection/section' => $collection->getTable('divantecommon_adsection/section')
        ), '`adsection/section`.`section_id` = `main_table`.`section_id`', array(
            'section_identifier' => 'identifier'
        ));

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        /* @var $adHelper DivanteCommon_AdSection_Helper_Block */
        $adHelper = Mage::helper('divantecommon_adsection/block');

        $this->addColumn('block_id', array(
            'header' => Mage::helper('divantecommon_adsection')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'block_id',
            'type' => 'number'
        ));

        $this->addColumn('resource', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Preview'),
            'align' => 'center',
            'type' => 'text',
            'width' => '200px',
            'filter' => false,
            'getter' => 'getAdminResourcePreview',
            'index' => 'block_id'
        ));

        $this->addColumn('additional_identifier', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Block identifier'),
            'index' => 'additional_identifier',
            'type' => 'text'
        ));

        $this->addColumn('section_identifier', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Section'),
            'index' => 'section_identifier',
            'type' => 'options',
            'options' => Mage::getModel('divantecommon_adsection/section')->getIdsForBlockGrid(),
            'filter_index' => '`adsection/section`.`section_id`'
        ));

        $this->addColumn('type', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Type'),
            'type' => 'options',
            'index' => 'type',
            'options' => $adHelper->getTypesList()
        ));

        $this->addColumn('position', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Position'),
            'index' => 'position',
            'type' => 'number'
        ));

        $this->addColumn('is_active', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Is Active?'),
            'index' => 'is_active',
            'type' => 'options',
            'width' => '20px',
            'options' => array(
                0 => Mage::helper('divantecommon_adsection')->__('No'),
                1 => Mage::helper('divantecommon_adsection')->__('Yes')
            )
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('divantecommon_adsection')->__("Edit"),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                ),
                array(
                    'caption' => Mage::helper('divantecommon_adsection')->__("Activate"),
                    'url' => array('base' => '*/*/activate'),
                    'field' => 'id'
                ),
                array(
                    'caption' => Mage::helper('divantecommon_adsection')->__("Deactivate"),
                    'url' => array('base' => '*/*/deactivate'),
                    'field' => 'id'
                ),
                array(
                    'caption' => Mage::helper('divantecommon_adsection')->__("Delete"),
                    'url' => array('base' => '*/*/delete'),
                    'field' => 'id'
                ),
            ),
            'filter' => false,
            'sortable' => false,
            'in_system' => true
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getBlockId()));
    }

}
