<?php
namespace Ec\Qr\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class CartAddItem implements ObserverInterface
{

    protected $checkoutSession;
    protected $ecOrder;
    protected $apiHelper;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Ec\Qr\Model\EcOrderFactory $ecOrder,
        \Ec\Qr\Helper\Api $apiHelper
    ){
        $this->checkoutSession = $checkoutSession;
        $this->ecOrder = $ecOrder;
        $this->apiHelper = $apiHelper;
    }


    public function execute(Observer $observer)
    {
        $item = $observer->getItem();
        if ($item->getSku() === 'ec-qr-product' && $item->getQty() > 1) {
            $item->setQty(1);
            $item->save();
        }
    }
}
