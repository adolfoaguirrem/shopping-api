<?php

namespace App\Application\Request;

use Symfony\Component\HttpFoundation\Request;
use App\Infrastructure\Exception\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class BaseRequest
 *
 * This class allows us to work with Requests in a similar way to Laravel Request, handles validations and return errors.
 */

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
    }

    public function validate()
    {
        $errors = $this->validator->validate($this);

        if (count($errors) > 0) {

            $show_errors = [];

            foreach ($errors as $message) {
                $show_errors[] = [
                    'property' => $message->getPropertyPath(),
                    'value' => $message->getInvalidValue(),
                    'message' => $message->getMessage(),
                ];
            }

            throw new ValidationException($show_errors);
        }
    }

    public function getContent(): array
    {
        return $this->getRequest()->toArray();
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        $requestFields = $this->getContent();

        foreach (get_object_vars($this) as $attribute => $_) {
            if (isset($requestFields[$attribute])) {
                $this->{$attribute} = $requestFields[$attribute];
            }
        }
    }
}
