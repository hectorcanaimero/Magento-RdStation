<?php

namespace Vanguarda\RdStation\Model\Rdstation\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface {
    protected $allNews;

    public function __construct(\Vanguarda\RdStation\Model\Rdstation $allNews) {
        $this->allNews = $allNews;
    }

    public function toOptionArray() {
        $availableOptions = $this->allNews->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}

?>