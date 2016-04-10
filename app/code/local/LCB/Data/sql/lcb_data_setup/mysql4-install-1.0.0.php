<?php

$installer = $this;
$installer->startSetup();
$model = Mage::getModel('lcb_data/install');

Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

/**
 * setup products data
 */
$model->addProducts();

/**
 * setup plugins data
 */
if (Mage::helper('core')->isModuleEnabled('LCB_UsageStory')) {
    $model->addUsageStories();
}

$installer->endSetup();
