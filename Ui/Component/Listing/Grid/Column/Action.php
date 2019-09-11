<?php

namespace Coreway\Productslider\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Magento\Framework\ObjectManagerInterface;

class Action extends Column
{

    const ROW_EDIT_URL = 'corewayproductslider/index/addrow';

    protected $_urlBuilder;
    protected $_objectManager;
    private $_editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ObjectManagerInterface $objectManager,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::ROW_EDIT_URL
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        $this->_objectManager = $objectManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item)
            {
                $item['name'] = 'Product Slider';
                $name = $this->getData('name');
                if (isset($item['id']))
                {
                    $item[$name]['edit'] = ['href' => $this->_urlBuilder->getUrl($this->_editUrl, ['id' => $item['id']]),
                    'label' => __('Edit'),
                    ];
                }
            }
        }

        return $dataSource;
    }
}
