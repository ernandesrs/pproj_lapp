<?php

namespace App\Filters;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleFilter extends Filter
{
    /**
     * Constructor
     *
     * @param Request|null $request
     */
    public function __construct(?Request $request)
    {
        parent::__construct(Role::class, $request);

        $this->addSearchable('name')
            ->addSortable('name');
    }
}