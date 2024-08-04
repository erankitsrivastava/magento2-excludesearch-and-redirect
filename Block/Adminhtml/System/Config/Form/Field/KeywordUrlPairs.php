<?php
namespace Epurnima\ExcludeSearch\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\BlockInterface;

class KeywordUrlPairs extends AbstractFieldArray
{
    protected function _prepareToRender()
    {
        $this->addColumn('keyword', ['label' => __('Keyword'), 'class' => 'required-entry']);
        $this->addColumn('url', ['label' => __('URL'), 'class' => 'required-entry']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /*protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $row->setData(
            'option_extra_attrs',
            [
                'option_' . $this->calcOptionHash($row->getData('keyword')) => 'selected="selected"',
                'option_' . $this->calcOptionHash($row->getData('url')) => 'selected="selected"',
            ]
        );
    }*/
}
