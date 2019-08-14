<?php
class Gaggle_Flyermenu_Model_Options
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
           /*  array('value' => 'toggle-slide-left', 'label'=>Mage::helper('adminhtml')->__('toggle-slide-left')),
            array('value' => 'toggle-slide-right', 'label'=>Mage::helper('adminhtml')->__('toggle-slide-right')),
			array('value' => 'toggle-slide-top', 'label'=>Mage::helper('adminhtml')->__('toggle-slide-top')),
			array('value' => 'toggle-slide-bottom', 'label'=>Mage::helper('adminhtml')->__('toggle-slide-bottom')),
			array('value' => 'toggle-push-left', 'label'=>Mage::helper('adminhtml')->__('toggle-push-left')),
			array('value' => 'toggle-push-right', 'label'=>Mage::helper('adminhtml')->__('toggle-push-right')),
			array('value' => 'toggle-push-top', 'label'=>Mage::helper('adminhtml')->__('toggle-push-top')),
			array('value' => 'toggle-push-bottom', 'label'=>Mage::helper('adminhtml')->__('toggle-push-bottom')), */
			array('value' => 'slide-menu-left', 'label'=>Mage::helper('adminhtml')->__('slide-menu-left')),
			array('value' => 'slide-menu-right', 'label'=>Mage::helper('adminhtml')->__('slide-menu-right')),
			/* array('value' => 'slide-menu-top', 'label'=>Mage::helper('adminhtml')->__('slide-menu-top')),
			array('value' => 'slide-menu-bottom', 'label'=>Mage::helper('adminhtml')->__('slide-menu-bottom')), */
			array('value' => 'push-menu-left', 'label'=>Mage::helper('adminhtml')->__('push-menu-left')),
			array('value' => 'push-menu-right', 'label'=>Mage::helper('adminhtml')->__('push-menu-right')),
			/* array('value' => 'push-menu-top', 'label'=>Mage::helper('adminhtml')->__('push-menu-top')),
			array('value' => 'push-menu-bottom', 'label'=>Mage::helper('adminhtml')->__('push-menu-bottom')), */
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
           /*  'toggle-slide-left'=> Mage::helper('adminhtml')->__('toggle-slide-left'),
            'toggle-slide-right'=> Mage::helper('adminhtml')->__('toggle-slide-right'),
			'toggle-slide-top'=> Mage::helper('adminhtml')->__('toggle-slide-top'),
			'toggle-slide-bottom'=> Mage::helper('adminhtml')->__('toggle-slide-bottom'),
			'toggle-push-left'=> Mage::helper('adminhtml')->__('toggle-push-left'),
			'toggle-push-right'=> Mage::helper('adminhtml')->__('toggle-push-right'),
			'toggle-push-top'=> Mage::helper('adminhtml')->__('toggle-push-top'),
			'toggle-push-bottom'=> Mage::helper('adminhtml')->__('toggle-push-bottom'), */
			'slide-menu-left'=> Mage::helper('adminhtml')->__('slide-menu-left'),
			'slide-menu-right'=> Mage::helper('adminhtml')->__('slide-menu-right'),
			'slide-menu-top'=> Mage::helper('adminhtml')->__('slide-menu-top'),
			'slide-menu-bottom'=> Mage::helper('adminhtml')->__('slide-menu-bottom'),
			'push-menu-left'=> Mage::helper('adminhtml')->__('push-menu-left'),
			'push-menu-right'=> Mage::helper('adminhtml')->__('push-menu-right'),
			'push-menu-top'=> Mage::helper('adminhtml')->__('push-menu-top'),
			'push-menu-bottom'=> Mage::helper('adminhtml')->__('push-menu-bottom'),
        );
    }

}
