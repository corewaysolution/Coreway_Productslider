<?php

namespace Coreway\Productslider\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{
   
    protected $_resultPageFactory; 
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
 
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Coreway_Productslider::add_row');
        $resultPage->getConfig()->getTitle()->prepend(__('Coreway Product Slider'));
 
        return $resultPage;
    }
 
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Coreway_Productslider::grid_list');
    }
}
