<?php
namespace Ec\Qr\Controller\Adminhtml\Config;

class Save extends \Magento\Backend\App\Action
{

    /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $resultPageFactory;

    /**
     * Product Model
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * Config Factory
     *
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $configFactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Ec\Qr\Model\ConfigFactory $configFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->messageManager = $messageManager;
        $this->configFactory = $configFactory;
        $this->productRepository = $productRepository;
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $configFactory = $this->configFactory->create();
        $collection = $configFactory->getCollection();

        if (isset($post['price'])) {
            $ecProduct = $this->productRepository->get('ec-qr-product');
            $ecProduct->setPrice($post['price']);
            $this->productRepository->save($ecProduct);
        }

        $domain = $post['domain'];
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www.', '', $domain);
        $domain = explode('.', $domain);
        $post['domain'] = $domain[0];

        unset($post['form_key']);
        foreach ($collection as $config) {
            if (isset($post[$config->getName()])) {
                $config->setValue($post[$config->getName()]);
                $config->save();
                unset($post[$config->getName()]);
            }
        }


        foreach($post as $key => $config) {
            $configModel = $this->configFactory->create();
            $configModel->setData(
                [
                    'name' => $key,
                    'value' => $config,
                ]
            );
            $configModel->save();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config');

        $this->messageManager->addSuccess(__("Module Updated"));
        return $resultRedirect->setPath($url);
    }

}
