<?php
class Gaggle_Flyermenu_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
     * Config paths for using throughout the code
     */
    const XML_PATH_ACCOUNT = 'flyermenu/general/gaggle_js';
	const XML_PATH_RETAILER_ID = 'flyermenu/general/retailer_id';
	const XML_PATH_STATUS = 'flyermenu/general/status';
    /**
     * Whether GA is ready to use
     *
     * @param mixed $store
     * @return bool
     */
    public function getHtmlCode($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_ACCOUNT, $store);
    }
	
	public function getImageUrl($product)
	{
		$product=Mage::getModel('catalog/product')->load($product->getId());
		if($product->getImage()!='no_selection')
		{
			
			$image=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/product' .$product->getImage();
		}
		else
		{
			if(Mage::getStoreConfig("catalog/placeholder/image_placeholder")=='')
			{
				$image=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/base/default/images/catalog/product/placeholder/image.jpg';
			}
			else
			{
				$image=Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'placeholder/' .Mage::getStoreConfig("catalog/placeholder/small_image_placeholder");
			}
		}
		return $image;
	}
}
	 