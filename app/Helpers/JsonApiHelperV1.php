<?php

namespace App\Helpers;

class JsonApiHelperV1
{
    protected $filterParams;

    public function __construct()
    {
        $this->resetFilter();
    }

    public function resetFilter()
    {
        $this->filterParams = [
            'root-group' => [
                'group' => [
                    'conjunction' => 'AND'
                ]
            ]
        ];
    }

    public function addCondition(string $path, string $operator, $value, string $group = 'group-0')
    {
        $filterIndex = count($this->filterParams[$group]);
        $this->filterParams[$group]["filter-{$group}-{$filterIndex}"] = [
            'condition' => [
                'path' => $path,
                'operator' => $operator,
                'value' => $value,
                'memberOf' => $group
            ]
        ];
    }

    public function getFilterParams()
    {
        return $this->filterParams;
    }
}
