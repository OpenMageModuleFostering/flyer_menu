<?php
class Gaggle_Flyermenu_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Titlename"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("titlename", array(
                "label" => $this->__("Titlename"),
                "title" => $this->__("Titlename")
		   ));

      $this->renderLayout(); 
	  
    }
	/*******Function for getting updated price********/
	 public function priceUpdateAction() {
		if($ids=$this->getRequest()->getParam('product_ids'))
		{
			$ids=explode(',',$ids);
		}
		$price=array();
		foreach($ids as $id)
		{
			$product=Mage::getModel('catalog/product')->load($id);
			if($product->getTypeId()=='simple')
			{
				$price[$product->getId()]=$product->getFinalPrice();
			}
			else
			{
				$price[$product->getId()]='none';
			}
		}
		echo json_encode($price);
	 }
	 /********Function for getting js for add to cart by ajax********/
	 public function gagglecalljsAction() {
		if(Mage::getSingleton('core/session')->getData('flyermenu_wishlist')||
		Mage::getSingleton('core/session')->getData('flyermenucart'))
		{
			echo $this->getLayout()->createBlock('flyermenu/flyermenu')->setTemplate('flyermenu/gagglecall.phtml')->toHtml();
			return;
		}
		echo '';
	 }
	 /*******Function for authenticating loggedin users******/
	 public function authenticateAction(){
		$publicKey = Mage::getBaseDir().DS.'skin'.DS.'frontend'.DS.'base'.DS.'default'.DS.'flyermenu'.DS.'key'.DS.'public.pem';
		$email =$this->getRequest()->getParam('email');
		$retailerId=Mage::getStoreConfig('flyermenu/general/retailer_id',Mage::app()->getStore()->getId());
		$fp=fopen($publicKey,"r");
	    $pub_key_string=fread($fp,8192);
	    fclose($fp);
	    openssl_get_publickey($pub_key);
	    openssl_public_encrypt($email,$crypttext,$pub_key_string); 
		$url=$this->getRequest()->getParam('host').'/provider/validate';
		$regid=$this->getRequest()->getParam('regId');
		$crypttext=base64_encode($crypttext); 
		
		$postFields='pid='.$retailerId.'&e='.$crypttext.'&reg-id='.$regid;

		/*  $postFields=array(
						'pid'=>$retailerId,
						'e'=>$crypttext ,
						'reg-id'=>$regid,
					); 
	 	echo $postFields=json_encode($postFields);
		//$postFields='{"pid":"'.$retailerId.'","e":"'.$crypttext.'","reg-id":"'.$regid.'"}';  */
		echo $postFields;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postFields);
		curl_setopt($httpRequest, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
		curl_setopt($httpRequest, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		$info = curl_getinfo($ch);
	 print_r($server_output);
		print_r($info); 
		if($info)
		{
			echo json_encode(array('success'=>'1'));
		}
		else
		{
			echo json_encode(array('success'=>'0'));			
		}

	 }
	 public function cartAction()
	 {
			if($this->checkProductExistOrNot())
			{
				$this->_redirect('checkout/cart');
				return;
			}
			
			$cart = Mage::getModel('checkout/cart');
			$cart->init();
			$product= Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product'));
			$params = array(
				'product' => $product->getId(),
				'super_attribute' => $this->getRequest()->getParam('super_attribute'),
				'qty' => 1,
			);
			if($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE)
			{
			
				$cart->addProduct($product,$params);
			}
			elseif($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE)
			{
				$cart->addProduct($product , 
													array( 'product_id' => $productId,
															 'qty' => 1,
															 'bundle_option' => $this->getRequest()->getParam('bundle_option'),
															));
			}
			elseif($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED)
			{
				$cart->addProduct($product , 
													array( 'product_id' => $productId,
															 'qty' => 1,
															 'super_group' => $this->getRequest()->getParam('super_group'),
															));
			}
			else
			{
				$cart->addProduct($product , 
													array( 'product_id' => $productId,
															 'qty' => 1,
															));
			}
			
			$cart->save(); 
			$this->_redirect('checkout/cart');
	 }
	 public function checkProductExistOrNot()
	 {
		$product= Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product'));
		$quote = Mage::getSingleton('checkout/session')->getQuote();
		$cartItems = $quote->getAllVisibleItems();
			
		foreach ($cartItems as $item)
			{
				$options=$item->getOptions();
				foreach($options as $op)
				{
					/* if($item->getParentItem())
					echo $item->getParentItem()->getProduct()->getId().'</br>'; */
					if($item->getProduct()->getId()==$product->getId())
					{
						if($op->getCode()=='info_buyRequest')
						{
							$result=$op->getData('value');
							$var1 = unserialize($result);
							
							if($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE)
							{
								$super_attribute=$this->getRequest()->getParam('super_attribute');
								if($var1['super_attribute']==$super_attribute)
								{
									
									return true;
								}
							}
							elseif($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_BUNDLE)
							{
								$bundle_option=$this->getRequest()->getParam('bundle_option');
								if($var1['bundle_option']==$bundle_option)
								{
									return true;
								}
								
							}
							elseif($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_GROUPED)
							{
								$super_group=$this->getRequest()->getParam('super_group');
								if($var1['super_group']==$super_group)
								{
									return true;
								}
								
							}
							else
							{
								return true;
							}
						}
					}
				}
				
			}
			
			return false;
	 }
}