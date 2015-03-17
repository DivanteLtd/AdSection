<?php
/** @var $this Divante_Core_Model_Resource_Mysql4_Setup */
$installer = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
$installer->getConnection()
    ->addColumn($installer->getTable('divantecommon_adsection/block'), 'is_active',
    'TINYINT(1) NOT NULL DEFAULT 0');
$installer->endSetup();
