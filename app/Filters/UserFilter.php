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
        $this->addSearchable('first_name,last_name,username,email')
            ->addSortable('order:first_name')
            ->addSortable('last_name')
            ->addSortable('username')

            ->addComparableFields('email', true)
            ->addComparableFields('email', false)
            ->addComparableFields('username', true)
            ->addComparableFields('username', false);

        parent::__construct(User::class, $request);
    }
}