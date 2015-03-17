<?php
/**
 * @method DivanteCommon_AdSection_Model_Block setSectionId(int $id)
 * @method int getSectionId()
 * @method DivanteCommon_AdSection_Model_Block setAdditionalIdentifier(string $identifier)
 * @method string|null getAdditionalIdentifier()
 * @method DivanteCommon_AdSection_Model_Block setType(int $type)
 * @method int getType()
 * @method DivanteCommon_AdSection_Model_Block setAction(string $action)
 * @method string getAction()
 * @method DivanteCommon_AdSection_Model_Block setPosition(int $position)
 * @method int getPosition()
 * @method DivanteCommon_AdSection_Model_Block setResource(string $resource)
 * @method int getIsActive()
 * @method DivanteCommon_AdSection_Model_Block setStoreId(int $id)
 * @method int getStoreId()
 */
class DivanteCommon_AdSection_Model_Block extends Mage_Core_Model_Abstract
{

    const HTML_TYPE = 1;
    const IMAGE_TYPE = 2;
    const SWF_TYPE = 3;
//    const HTML_AND_IMAGE_TYPE = 4;

    protected function _construct()
    {
        $this->_init('divantecommon_adsection/block');
        parent::_construct();
    }

    /**
     * @param DivanteCommon_AdSection_Model_Section $section
     * @return DivanteCommon_AdSection_Model_Block
     */
    public function setSection(DivanteCommon_AdSection_Model_Section $section)
    {
        return $this->setSectionId($section->getId());
    }

    /**
     * @return bool|DivanteCommon_AdSection_Model_Section
     */
    public function getSection()
    {
        $section = false;
        if($this->getSectionId()) {
            /* @var $section DivanteCommon_AdSection_Model_Section */
            $section = Mage::getModel('divantecommon_adsection/section')->load($this->getSectionId());
        }

        return $section && $section->getId() ? $section : false;
    }

    /**
     * @param $status
     * @return DivanteCommon_AdSection_Model_Block
     */
    public function setIsActive($flag)
    {
        return $this->setData('is_active', (int)((bool) $flag));
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (bool) $this->getIsActive();
    }

    public function getResource($attribute = false)
    {
        return $attribute ? $this->getData('resource') : parent::getResource();
    }

    public function getAdminResourcePreview()
    {
        switch($this->getType()) {
//            case self::HTML_AND_IMAGE_TYPE:
            case self::IMAGE_TYPE:
                return "<a href=\"{$this->getAction()}\"><img width='150' src=\"{$this->getResource(true)}\" /></a>";
            case self::SWF_TYPE:
                return 'FLASH';
            default:
                return nl2br(substr(strip_tags($this->getResource(true)), 0, 100));
        }
    }
}
