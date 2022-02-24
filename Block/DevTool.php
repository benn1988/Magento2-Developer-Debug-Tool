<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_DevTool
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\DevTool\Block;

use Ced\DevTool\Helper\Data;
use Ced\DevTool\Model\Config;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Url;
use Magento\Framework\UrlFactory;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;

class DevTool extends Template
{
    /**
     * @var Data
     */
     protected $_devToolHelper;
     
     /**
      * @var Url
      */
     protected $_urlApp;
     
    /**
     * @var Config
     */
    protected $_config;

    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param Context $context
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        Context $context,
        UrlFactory $urlFactory
    ) {
        $this->_devToolHelper = $context->getDevToolHelper();
        $this->_config = $context->getConfig();
        $this->_urlApp=$urlFactory->create();
        $this->_request = $context->getRequest();
        $this->_storeManager= $context->getStoreManager();
        parent::__construct($context);
    }
    
    /**
     * Function for getting event details
     * @return array
     */
    public function getEventDetails()
    {
        return  $this->_devToolHelper->getEventDetails();
    }
    
    /**
     * Function for getting current url
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->_urlApp->getCurrentUrl();
    }
    
    /**
     * Function for getting controller url for given router path
     * @param string $routePath
     * @return string
     */
    public function getControllerUrl($routePath)
    {
        return $this->_urlApp->getUrl($routePath);
    }
    
    /**
     * Function for getting current url
     * @param string $path
     * @return string
     */
    public function getConfigValue($path)
    {
        return $this->_config->getCurrentStoreConfigValue($path);
    }
    
    /**
     * Function canShowDevTool
     * @return bool
     */
    public function canShowDevTool()
    {
        $isEnabled=$this->getConfigValue('devtool/module/is_enabled');
        if ($isEnabled) {
            $allowedIps=$this->getConfigValue('devtool/module/allowed_ip');
            if (is_null($allowedIps)) {
                return true;
            } else {
                $remoteIp=$_SERVER['REMOTE_ADDR'];
                if (strpos($allowedIps, $remoteIp) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
    
    /**
     * Function for getting front controller url for given router path
     * @param string $routePath
     * @return string
     */
    public function getFrontUrl($routePath)
    {
        return $this->_storeManager->getStore()->getBaseUrl().$routePath;
    }
}
