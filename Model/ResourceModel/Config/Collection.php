<?php
namespace EmotionalCommerceApp\Qr\Model\ResourceModel\Config;

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
            'EmotionalCommerceApp\Qr\Model\Config',
            'EmotionalCommerceApp\Qr\Model\ResourceModel\Config'
        );
    }

}
