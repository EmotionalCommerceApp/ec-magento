<?php
namespace EmotionalCommerceApp\Qr\Model\ResourceModel\EcOrder;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'EmotionalCommerceApp\Qr\Model\EcOrder',
            'EmotionalCommerceApp\Qr\Model\ResourceModel\EcOrder'
        );
    }

}
