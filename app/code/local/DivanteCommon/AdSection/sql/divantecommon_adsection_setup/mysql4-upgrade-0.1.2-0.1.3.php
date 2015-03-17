<?php
/** @var $this Divante_Core_Model_Resource_Mysql4_Setup */
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$installer->run("
    ALTER TABLE `adsection_block` ADD COLUMN `additional_identifier` VARCHAR(255) NULL DEFAULT NULL  AFTER `section_id`;

");
$installer->endSetup();
