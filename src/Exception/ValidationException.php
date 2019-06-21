<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    /**
     * ValidationException constructor.
     * @param ConstraintViolationListInterface $violations
     */
    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
        parent::__construct($this->getJoinedMessages());
    }

    /**
     * @return string
     */
    private function getJoinedMessages(): string
    {
        $messages = [];
        foreach ($this->violations as $paramName => $violation) {
            $messages[] = $violation->getMessage();
        }
        return implode(', ', $messages);
    }
}
