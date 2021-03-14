<?php

namespace Ec\Qr\Block;

class Cart extends \Magento\Framework\View\Element\Template
{

    /**
     * apiHelper
     *
     * @var \Ec\Qr\Helper\Api
     */
    protected $apiHelper;
    protected $checkoutSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ec\Qr\Helper\Api $apiHelper,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        $this->apiHelper = $apiHelper;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    public function canShow()
    {
        if ($this->checkoutSession->getData('ec_qr')) {
            return false;
        }

        return true;
    }

    public function getConfig()
    {
        return $this->apiHelper->getConfig();
    }

}
