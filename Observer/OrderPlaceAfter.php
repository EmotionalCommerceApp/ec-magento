<?php
namespace Ec\Qr\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class OrderPlaceAfter implements ObserverInterface
{

    protected $checkoutSession;
    protected $ecOrder;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Ec\Qr\Model\EcOrderFactory $ecOrder
    ){
        $this->checkoutSession = $checkoutSession;
        $this->ecOrder = $ecOrder;;
    }


    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        $qrData = $this->checkoutSession->getData('ec_qr');

        $ecOrder = $this->ecOrder->create();
        $ecOrder->setData(
            [
                'url' => $qrData['url'],
                'order_id' => $order->getId(),
                'qr' => $qrData['qr'],
            ]
        );
        $ecOrder->save();
    }
}
