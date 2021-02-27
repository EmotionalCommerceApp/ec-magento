<?php
namespace Ec\Qr\Block\Adminhtml\Order;

/**
 * Block for the images upload form
 */
class Printqr extends \Magento\Backend\Block\Template
{

    /**
     * Product repository API interface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $context;

    /**
     * @var \Ec\Qr\Model\EcOrder
     */
    protected $ecOrderFactory;

    protected $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Ec\Qr\Model\EcOrderFactory $ecOrderFactory,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->context = $context;
        $this->ecOrderFactory = $ecOrderFactory;
        $this->request = $request;

        parent::__construct($context);
    }

    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getQrUrl()
    {
        $orderId = $this->request->get('order_id');

        $ecOrder = $this->ecOrderFactory->create()->load($orderId, 'order_id');

        return $ecOrder->getQr();
    }

}
