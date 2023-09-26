<?php

namespace App\Application\Request;

use App\Application\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class BuyerRequest extends BaseRequest
{

    /**
     * @Assert\NotNull
     */
    protected $name;
}
