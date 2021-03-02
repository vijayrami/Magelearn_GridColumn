<?php

namespace Magelearn\GridColumn\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Category extends \Magento\Ui\Component\Listing\Columns\Column
{
	protected $_productRepository;
	protected $_categoryFactory;
	
	public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    	$this->_productRepository = $productRepository;
		$this->_categoryFactory = $categoryFactory;
    }
	
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
        	$fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $productId = $item['entity_id'];
				$categories = [];
				
                $product = $this->_productRepository->getById($productId);
                $cats = $product->getCategoryIds();
				
                if (count($cats)) {
                    foreach ($cats as $cat) {
						$category = $this->_categoryFactory->create()->load($cat);
                        $categories[] = $category->getName();
                    }
                }
                $item[$fieldName] = implode(',', $categories);
            }
        }
        return $dataSource;
    }
}