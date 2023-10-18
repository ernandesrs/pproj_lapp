<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Filter
{
    /**
     * Defaults
     *
     * @var array
     */
    private $defaults = [
        'page' => [
            'value' => 1,
            'rules' => ['nullable', 'numeric']
        ],
        'limit' => [
            'value' => 50,
            'rules' => ['nullable', 'numeric', 'min:1', 'max:50']
        ],
        'search' => [
            'value' => null,
            'rules' => ['nullable', 'string']
        ],
        'order' => [
            'order|created_at' => [
                'value' => 'desc',
                'rules' => ['nullable', 'in:asc,desc']
            ],
            'order|updated_at' => [
                'value' => null,
                'rules' => ['nullable', 'in:asc,desc']
            ]
        ]
    ];

    /**
     * Model
     *
     * @var Model
     */
    private $model;

    /**
     * Request
     *
     * @var Request
     */
    private $request;

    /**
     * Searchable
     *
     * @var string
     */
    private $searchable = null;

    /**
     * Constructor
     *
     * @param string $modelClass
     * @param Request|null $request
     */
    public function __construct(string $modelClass, ?Request $request)
    {
        $this->model = new $modelClass;
        $this->request = $request;
    }

    /**
     * Add searchable fields
     *
     * @param string $fields
     * @return Filter
     */
    protected function addSearchable(string $field)
    {
        $this->searchable = $this->searchable ? ',' . $field : $field;
        return $this;
    }

    /**
     * Add sortable field
     *
     * @param string $field
     * @return Filter
     */
    protected function addSortable(string $field)
    {
        $this->defaults['order'][str_starts_with($field, 'order|') ? $field : 'order|' . $field] = [
            'value' => null,
            'rules' => ['nullable', 'in:asc,desc']
        ];
        return $this;
    }

    /**
     * Filter
     *
     * @return mixed
     */
    public function filter()
    {
        $this->validate();

        $this->prepare();

        if ($search = $this->defaults['search']) {
            $this->model = $this->model->whereRaw("MATCH({$this->searchable}) AGAINST('{{$search}}')");
        }

        foreach ($this->defaults['order'] as $orderKey => $orderValue) {
            if (!is_null($orderValue)) {
                $key = str_replace('order|', '', $orderKey);
                $this->model = $this->model->orderBy($key, $orderValue);
            }
        }

        return $this->model->offset($this->defaults['page'])->paginate($this->defaults['limit']);
    }

    /**
     * 
     * * *
     * 
     */


    /**
     * Validate
     *
     * @return void
     */
    private function validate()
    {
        $rules = [];

        // make validation rules
        foreach ($this->defaults as $key => $value) {
            if ($value['rules'] ?? null) {
                $rules[$key] = $value['rules'];
            } else {
                foreach ($value as $subKey => $subValue) {
                    $rules[$subKey] = $subValue['rules'];
                }
            }
        }

        // make validator
        $validator = \Validator::make($this->request->all(), $rules);

        if ($validator->fails()) {
            session()->flash('validator_errors', $validator->errors());
            throw new \App\Exceptions\InvalidDataException('Filtering fail. Some filter field value is invalid.');
        }

        foreach ($validator->validated() as $k => $v) {
            if (str_contains($k, '|')) {
                [$group,] = explode('|', $k);
                $this->defaults[$group][$k]['value'] = $v;
            } else {
                $this->defaults[$k]['value'] = $v;
            }
        }
    }

    /**
     * Prepare
     *
     * @return void
     */
    private function prepare()
    {
        foreach ($this->defaults as $key => $value) {
            if ($value['rules'] ?? null) {
                $this->defaults[$key] = $value['value'];
            } else {
                foreach ($value as $subKey => $subValue) {
                    [$group,] = explode('|', $subKey);

                    $this->defaults[$group][$subKey] = $subValue['value'];
                }
            }
        }
    }
}