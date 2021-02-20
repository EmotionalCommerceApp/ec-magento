<?php
namespace Ec\Qr\Block\Adminhtml;

/**
 * Block for the images upload form
 */
class Config extends \Magento\Backend\Block\Template
{

    /**
     * Product repository API interface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $context;

    /**
     * Product repository API interface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $formKey;

    /**
     * Product repository API interface
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    public $coreSessions;

    /**
     * ConfigFactory
     *
     * @var \Ec\Qr\Model\ConfigFactory
     */
    protected $configFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Ec\Qr\Model\ConfigFactory $configFactory
    ) {
        $this->context = $context;
        $this->formKey = $formKey;
        $this->coreSession = $coreSession;
        $this->configFactory = $configFactory;

        parent::__construct($context);
    }

    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getActionUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/save');
    }

    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getInstallActionUrl()
    {
        $url = $this->context->getUrlBuilder();

        return $url->getUrl('ecqr/config/install');
    }


    /**
     * Generates and returns a form key
     *
     * @return array
     */
    public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }

    public function getConfig()
    {
          $configFactory = $this->configFactory->create();
          $collection = $configFactory->getCollection();

          $configData = [
              'key' => false,
              'secret' => false,
              'domain' => false,
              'campaign' => false,
              'template' => false,
          ];

          foreach ($collection as $config) {
              $configData[$config->getName()] = $config->getValue();
          }

          return $configData;
    }

}
