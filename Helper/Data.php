<?php

namespace Vanguarda\RdStation\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper {
	const XML_PATH_RSGITECH_NEWS = 'vanguarda_rdstation/';

	public function getConfigValue($field, $storeCode = null) {
		return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeCode);
	}

	public function getGeneralConfig($fieldid, $storeCode = null) {
		return $this->getConfigValue(self::XML_PATH_RSGITECH_NEWS.'general/'.$fieldid, $storeCode);
	}

	public function getStorefrontConfig($fieldid, $storeCode = null) {
		return $this->getConfigValue(self::XML_PATH_RSGITECH_NEWS.'storefront/'.$fieldid, $storeCode);
	}

}