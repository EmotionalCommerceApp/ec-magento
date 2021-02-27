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

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ec\Qr\Helper\Api $apiHelper,
        array $data = []
    ) {
        $this->apiHelper = $apiHelper;
        parent::__construct($context, $data);
    }

    public function getConfig()
    {
        return $this->apiHelper->getConfig();
    }

}
