<?php

namespace App\Helpers;

class JsonApiQueryBuilder
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
            ],
            'group-0' => [
                'group' => [
                    'conjunction' => 'AND',
                    'memberOf' => 'root-group'
                ]
            ]
        ];
    }

    public function where(string $path, $operator = '=', $value = null, string $group = '0')
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->addCondition($path, $operator, $value, $group);
        return $this;
    }

    public function orWhere(string $path, $operator = '=', $value = null, string $group = '0')
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->addGroup($group, 'OR');
        $this->addCondition($path, $operator, $value, $group);
        return $this;
    }

    public function get()
    {
        return ['filter' => $this->filterParams];
    }

    protected function addCondition(string $path, string $operator, $value, string $group = '0')
    {
        $filterIndex = count($this->filterParams);
        $this->filterParams["filter-{$filterIndex}-{$group}"] = [
            'condition' => [
                'path' => $path,
                'operator' => $operator,
                'value' => $value,
                'memberOf' => "group-{$group}"
            ]
        ];
    }

    protected function addGroup(string $group, string $conjunction)
    {
        $this->filterParams["group-{$group}"] = [
            'group' => [
                'conjunction' => $conjunction,
                'memberOf' => 'root-group'
            ]
        ];
    }
}
