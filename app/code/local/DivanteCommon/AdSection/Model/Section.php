<?php
/**
 * @method DivanteCommon_AdSection_Model_Section setIdentifier(string $identifier)
 * @method string getIdentifier()
 * @method DivanteCommon_AdSection_Model_Section setName(string $name)
 * @method string getName()
 * @method DivanteCommon_AdSection_Model_Section setDescription(string $description)
 * @method string getDescription()
 * @method DivanteCommon_AdSection_Model_Section setCreatedAt(string $date)
 * @method string getCreatedAt()
 * @method DivanteCommon_AdSection_Model_Section setUpdatedAt(string $date)
 * @method string getUpdatedAt()
 */
class DivanteCommon_AdSection_Model_Section extends Mage_Core_Model_Abstract
{

    protected $_eventPrefix = 'adsection_section';

    protected function _construct()
    {
        $this->_init('divantecommon_adsection/section');
        parent::_construct();
    }

    /**
     * @return DivanteCommon_AdSection_Model_Resource_Block_Collection
     */
    public function getBlocksCollection($useStoreFilter = false)
    {
        /** @var $collection DivanteCommon_AdSection_Model_Resource_Block_Collection */
        $collection = Mage::getModel('divantecommon_adsection/block')->getCollection();
        $collection->addFieldToFilter('section_id', $this->getId());

        if($useStoreFilter) {
            $stores = array(0, Mage::app()->getStore()->getId());
            $collection->getSelect()->where('store_id IN (?)', $stores);
        }

        return $collection;
    }

    /**
     * @return DivanteCommon_AdSection_Model_Resource_Block_Collection
     */
    public function getActiveBlocksCollection()
    {
        return $this->getBlocksCollection(true)
                ->addFieldToFilter('is_active', 1)
                ->addOrder('position', 'ASC');
    }

    public function getIdsForBlockGrid()
    {
        $list = array();

        /** @var $collection DivanteCommon_AdSection_Model_Resource_Section_Collection */
        $collection = $this->getCollection();
        $collection->addFieldToSelect(array(
            'identifier'
        ));
        foreach($collection->getItems() as $item) {
            /** @var $item DivanteCommon_AdSection_Model_Section */
            $list[$item->getId()] = $item->getIdentifier();
        }

        return $list;
    }

    /**
     * @return DivanteCommon_AdSection_Model_Block
     */
    public function getMostImportantActiveBlock()
    {
        return $this->getActiveBlocksCollection()
            ->addFieldToSelect('*')
            ->setOrder('position', Mage_Core_Model_Resource_Db_Collection_Abstract::SORT_ORDER_ASC)
            ->setPageSize(1)
            ->setCurPage(1)
            ->getFirstItem()
        ;
    }

    /**
     * @param string $identifier
     * @return DivanteCommon_AdSection_Model_Block
     */
    public function getActiveBlockByAdditionalIdentifier($identifier)
    {
        $identifier = (string) $identifier;
        return  $this->getActiveBlocksCollection()
            ->addFieldToFilter('additional_identifier', $identifier)
            ->getFirstItem();
    }

}
