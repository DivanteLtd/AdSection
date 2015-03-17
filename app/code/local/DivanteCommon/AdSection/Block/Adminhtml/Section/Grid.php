<?php
class DivanteCommon_AdSection_Block_Adminhtml_Section_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->setId("sectionGrid");
        $this->setDefaultSort('section_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        /** @var $collection DivanteCommon_AdSection_Model_Resource_Section_Collection */
        $collection = Mage::getModel('divantecommon_adsection/section')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('section_id', array(
            'header' => Mage::helper('divantecommon_adsection')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'section_id'
        ));

        $this->addColumn('identifier', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Identifier'),
            'index' => 'identifier'
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Name'),
            'index' => 'name'
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Created At'),
            'type' => 'datetime',
            'width' => '100px',
            'index' => 'created_at'
        ));
        $this->addColumn('updated_at', array(
            'header' => Mage::helper('divantecommon_adsection')->__('Updated At'),
            'type' => 'datetime',
            'width' => '100px',
            'index' => 'updated_at'
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
                    'caption' => Mage::helper('divantecommon_adsection')->__("Delete"),
                    'url' => array('base' => '*/*/delete'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'in_system' => true
        ));

        return parent::_prepareColumns();
    }


}
