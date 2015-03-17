<?php
class DivanteCommon_AdSection_Model_Observer_Section
{
    public function populateAutoValues(Varien_Event_Observer $observer)
    {
        /** @var $section DivanteCommon_AdSection_Model_Section */
        $section = $observer->getData('data_object');
        if(! $section->getCreatedAt()) {
            $section->setCreatedAt(date("Y-m-d H:i:s"));
        }
        $section->setUpdatedAt(date("Y-m-d H:i:s"));
    }
}
