<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Http\Request;

class UserFilter extends Filter
{
    /**
     * Constructor
     *
     * @param Request|null $request
     */
    public function __construct(?Request $request)
    {
        parent::__construct(User::class, $request);

        $this->addSearchable('first_name,last_name,username,email')
            ->addSortable('order|first_name')
            ->addSortable('last_name')
            ->addSortable('username');
    }
}