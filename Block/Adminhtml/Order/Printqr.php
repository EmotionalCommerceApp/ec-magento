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

    protected $apiHelper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Ec\Qr\Model\EcOrderFactory $ecOrderFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Ec\Qr\Helper\Api $apiHelper
    ) {
        $this->context = $context;
        $this->ecOrderFactory = $ecOrderFactory;
        $this->request = $request;
        $this->apiHelper = $apiHelper;

        parent::__construct($context);
    }

    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getTemplateHtml()
    {
        $orderId = $this->request->get('order_id');

        $ecOrder = $this->ecOrderFactory->create()->load($orderId, 'order_id');

        if (!$ecOrder->getId()) {
            return '';
        }

        $config = $this->apiHelper->getConfig();

        $template = str_replace(
            '{{qr}}',
            '<img width="'.$config['width'].'" height="'.$config['height'].'" src="'.$ecOrder->getQr().'" />',
            $config['template']
        );

        return $template;
    }

}
