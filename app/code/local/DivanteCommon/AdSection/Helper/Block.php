<?php
class DivanteCommon_AdSection_Helper_Block extends Mage_Core_Helper_Abstract
{
    /**
     * @return array
     */
    public function getTypesList()
     {
         return array(
             '' => Mage::helper('cms')->__("Select type"),
             DivanteCommon_AdSection_Model_Block::HTML_TYPE => $this->__('Html'),
             DivanteCommon_AdSection_Model_Block::IMAGE_TYPE => $this->__("Image"),
             DivanteCommon_AdSection_Model_Block::SWF_TYPE => $this->__("SWF Flash"),
//             DivanteCommon_AdSection_Model_Block::HTML_AND_IMAGE_TYPE => $this->__("Html+Image"),
         );

     }

    public function getCreateBlockSection($sectionIdentifier, $sectionName, $emptyText = null, $additionalIdentifier = null)
    {
        /* @var $model DivanteCommon_AdSection_Model_Section */
        $model = Mage::getModel('divantecommon_adsection/section');

        /** @var $row DivanteCommon_AdSection_Model_Section */
        $row = $model->load($sectionIdentifier, 'identifier');

        if(!$row || !$row->getId()) {
            $row = $model;
            try {
                $row->setIdentifier($sectionIdentifier)
                    ->setName($sectionName)
                    ->save();
            } catch (Exception $e) {
                return '';
            }
        }
        if($row->getBlocksCollection()->count() == 0) {
            /* @var $block DivanteCommon_AdSection_Model_Block */
            $block = Mage::getModel('divantecommon_adsection/block');
            if($emptyText) {
                $block->setResource((string)$emptyText);
            }
            $block
                ->setSection($row)
                ->setType($block::HTML_TYPE)
                ->setPosition(0)->setIsActive(true)->save();
        } else if($additionalIdentifier) {
            $block = $row->getActiveBlockByAdditionalIdentifier($additionalIdentifier);

            if(! $block || !$block->getId()) {
                $block
                    ->setSection($row)
                    ->setType($block::HTML_TYPE)
                    ->setAdditionalIdentifier($additionalIdentifier)
                    ->setPosition(0)->setIsActive(true)->save();
            }
        }

        return $row;
    }
}
