<?php
/**
 * Created by JetBrains PhpStorm.
 * @copyright  Copyright (c) by Divante
 * @author     Adrian Badowski <abadowski@divante.pl>
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

// Create AdSection table
$installer->run("
    -- DROP TABLE IF EXISTS {$this->getTable('divantecommon_adsection/section')};
    CREATE TABLE {$this->getTable('divantecommon_adsection/section')} (
        `section_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
        `name` VARCHAR(255) NOT NULL ,
        `description` TEXT ,
        `identifier` VARCHAR(255) NOT NULL ,
        `created_at` TIMESTAMP NULL DEFAULT NULL ,
        `updated_at` TIMESTAMP NULL DEFAULT NULL ,
    PRIMARY KEY (`section_id`),
    UNIQUE INDEX `identifier_UNIQUE` (`identifier` ASC)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

//Create AdBlock table
$installer->run("
    -- DROP TABLE IF EXISTS {$this->getTable('divantecommon_adsection/block')};
    CREATE TABLE {$this->getTable('divantecommon_adsection/block')} (
        `block_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
        `section_id` INT(10) UNSIGNED NOT NULL ,
        `type` SMALLINT(2) NOT NULL ,
        `action` VARCHAR(255) NULL DEFAULT NULL ,
        `postion` SMALLINT(3) NOT NULL DEFAULT 0 ,
        `resource` TEXT ,
    PRIMARY KEY (`block_id`) ,
    INDEX `FK_BLOCK_SECTION` (`section_id` ASC) ,
    INDEX `search_index` (`postion` ASC, `type` ASC) ,
    CONSTRAINT `FK_BLOCK_SECTION`
    FOREIGN KEY (`section_id` )
    REFERENCES `adsection_section` (`section_id` )
    ON DELETE CASCADE
    ON UPDATE RESTRICT) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();