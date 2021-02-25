<?php
namespace Ec\Qr\Controller\Index;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * Show Contact Us page
     *
     * @return void
     */
    protected $_objectManager;
    protected $_storeManager;
    protected $_filesystem;
    protected $_fileUploaderFactory;
    protected $apiHelper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,\Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Ec\Qr\Helper\Api $apiHelper
    ) {
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->apiHelper = $apiHelper;
        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();

        $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $mediapath = $this->_mediaBaseDirectory = rtrim($mediaDir, '/');

        $uploader = $this->_fileUploaderFactory->create(['fileId' => 'video']);
        $uploader->setAllowedExtensions(['mp4', 'mov', 'webm', 'ogg', 'avi']);
        $uploader->setAllowRenameFiles(true);
        $path = $mediapath . '/ecqr/';
        $result = $uploader->save($path);

        $qr = $this->apiHelper->uploadVideo($result['path'] . $result['file']);


        var_dump($qr);die;

        $this->_redirect('checkout/cart');
        $this->messageManager->addSuccess(__('Video Uploaded successfully.'));
    }
}
