<?php
/** @var $this Divante_Core_Model_Resource_Mysql4_Setup */
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$installer->run("
    ALTER TABLE `adsection_block` ADD COLUMN `area_map` TEXT NULL;
");
$installer->endSetup();
