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

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Session\SessionManagerInterface $coreSession
    ) {
        $this->context = $context;
        $this->formKey = $formKey;
        $this->coreSession = $coreSession;

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

        return $url->getUrl('ecqr/configpost');
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
}
