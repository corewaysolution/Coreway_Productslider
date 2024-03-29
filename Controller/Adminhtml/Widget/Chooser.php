<?php

namespace Coreway\Productslider\Controller\Adminhtml\Widget;

class Chooser extends \Magento\Backend\App\Action
{
    protected $_layoutFactory;

    protected $_resultRawFactory;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory)
    {
        $this->_layoutFactory = $layoutFactory;
        $this->_resultRawFactory = $resultRawFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $layout = $this->_layoutFactory->create();
        $uniqId = $this->getRequest()->getParam('uniq_id');
        $pagesGrid = $layout->createBlock(
            'Coreway\Productslider\Block\Adminhtml\Block\Widget\Chooser',
            '',
            ['data' => ['id' => $uniqId]]
        );
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->_resultRawFactory->create();
        $resultRaw->setContents($pagesGrid->toHtml());
        return $resultRaw;
    }
}
