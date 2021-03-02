<?php

namespace Magelearn\GridColumn\Model\Category;

class CategoryList implements \Magento\Framework\Option\ArrayInterface
{
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $collectionFactory
    ) {
        $this->_categoryCollectionFactory = $collectionFactory;

    }
    public function toOptionArray($addEmpty = true)
    {

        $collection = $this->_categoryCollectionFactory->create()
        			->addAttributeToSelect('name')//->addRootLevelFilter()->load();
        			->addAttributeToFilter('level', ['gt' => 1]) //remove root category 
                	->addAttributeToFilter('is_active', ['gt' => 0]); //for active categories
        $options = [];
        if ($addEmpty) {
            $options[] = ['label' => __('-- Please Select a Category --'), 'value' => ''];
        }
        foreach ($collection as $category) {
            $options[] = ['label' => $category->getName(), 'value' => $category->getId()];
        }
        return $options;
    }
}