<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_InfiniteScroll
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\InfiniteScroll\Block;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Block Class Scroll
 */
class Scroll extends Template
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var array
     */
    protected $configModule;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->configModule = $this->getConfig();
    }

    /**
     * @param null $img
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getMedia($img=null)
    {
        $urlMedia = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        if ($img) {
            return $urlMedia . $img;
        }
        return $urlMedia;
    }


    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->_scopeConfig->getValue("scroll", ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param string $cfg
     * @param $value
     * @return array|mixed|null
     */
    public function getConfigModule(string $cfg = '', $value = null)
    {
        $values = $this->configModule;
        if( !$cfg ){
            return $values;
        }

        $config  = explode('/', $cfg);
        $end     = count($config) - 1;
        foreach ($config as $key => $vl)
        {
            if (isset($values[$vl])) {
                if ($key == $end) {
                    $value = $values[$vl];
                } else {
                    $values = $values[$vl];
                }
            }
        }
        return $value;
    }
}
