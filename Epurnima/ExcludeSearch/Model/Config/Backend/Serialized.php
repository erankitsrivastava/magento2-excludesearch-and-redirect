<?php
namespace Epurnima\ExcludeSearch\Model\Config\Backend;

use Magento\Framework\App\Config\Value;

class Serialized extends Value
{

    public function beforeSave()
    {
        $value = $this->getValue();
        if (is_array($value)) {
            if(isset($value['__empty']))unset($value['__empty']);
            $this->setValue(json_encode($value));
        }
        parent::beforeSave();
//
//        $value = $this->getValue();
//        $value = $this->_catalogInventoryMinsaleqty->makeStorableArrayFieldValue($value);
//        $this->setValue($value);
    }
    protected function _afterLoad()
    {
        $value = $this->getValue();
        if (!!$value && !is_array($value)) {
            $this->setValue(json_decode($value, true));
        }
        parent::_afterLoad();
    }
}
