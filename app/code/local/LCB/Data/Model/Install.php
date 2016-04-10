<?php

/**
 * LCB data installers for our plugins and stores
 *
 * @category   LCB
 * @package    LCB_Data
 * @author     Silpion Tomasz Gregorczyk <tom@lcbrq.com>
 */
class LCB_Data_Model_Install extends Mage_Core_Model_Abstract {

    const STORE_ID = false;

    public function __construct()
    {
        Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
    }

    /**
     * Get xml dat afor entity
     * 
     * @param string $type
     * @return type
     */
    public function getData($type)
    {
        $xmlPath = Mage::getModuleDir('data', 'LCB_Data') . DS . "$type.xml";
        $xmlObj = new Varien_Simplexml_Config($xmlPath);
        if (!$xmlObj) {
            Mage::throwException("Entity $type not found in data source");
        }
        return $xmlObj->getNode();
    }

    public function addProducts()
    {
        $products = $this->getData('products');
        foreach ($products as $data) {
            $product = Mage::getModel('catalog/product');
            try {

                if (self::STORE_ID) {
                    $product->setStoreId(self::STORE_ID);
                }

                $product->setAttributeSetId(Mage::getModel('catalog/product')->getDefaultAttributeSetId())
                        ->setTypeId('simple')
                        ->setCreatedAt(strtotime('now'))
                        ->setSku($data->sku)
                        ->setName($data->name)
                        ->setWeight($data->weight)
                        ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                        ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                        ->setPrice($data->price)
                        ->setDescription($data->description)
                        ->setShortDescription($data->short_description)
                        ->save();
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
    }

    public function addUsageStories()
    {
        $stories = $this->getData('usagestory');
        foreach ($stories as $data) {
            $story = Mage::getModel('usagestory/story');
            try {

                if (self::STORE_ID) {
                    $story->setStoreId(self::STORE_ID);
                }

                $story->setName($data->name)
                        ->setTitle($data->title)
                        ->setBio($data->bio)
                        ->setStory($data - story)
                        ->save();
            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }
        }
    }

}
