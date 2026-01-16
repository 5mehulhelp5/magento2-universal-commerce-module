<?php

/**
 * This file is part of the Magebit_UniversalCommerce package.
 *
 * @copyright Copyright (c) 2026 Magebit, Ltd. (https://magebit.com/)
 * @author    Magebit <info@magebit.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Magebit\UniversalCommerce\Model;

use Magebit\UniversalCommerce\Api\Data\ValidatableDataInterface;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterface;
use Magebit\UniversalCommerce\Api\Data\Response\ErrorResponseInterfaceFactory;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterface;
use Magebit\UniversalCommerce\Api\Data\Response\MessageInterfaceFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Request Validator
 * Validates request objects using Symfony Validator and returns UCP format errors
 */
class RequestValidator
{
    /**
     * @var ValidatorInterface|null
     */
    protected ?ValidatorInterface $validator = null;

    /**
     * @param ErrorResponseInterfaceFactory $errorResponseFactory
     * @param MessageInterfaceFactory $messageFactory
     */
    public function __construct(
        protected readonly ErrorResponseInterfaceFactory $errorResponseFactory,
        protected readonly MessageInterfaceFactory $messageFactory,
    ) {
    }

    /**
     * Validate data object
     *
     * @param mixed $dataClass
     * @return ErrorResponseInterface|null
     */
    public function validate(mixed $dataClass): ?ErrorResponseInterface
    {
        if (!($dataClass instanceof ValidatableDataInterface)) {
            return null;
        }

        $errors = $this->getValidator()->validate($dataClass);

        if ($errors->count() > 0) {
            $errorResponse = $this->errorResponseFactory->create();
            $errorResponse->setStatus(ErrorResponseInterface::STATUS_INVALID_REQUEST);

            foreach ($errors as $error) {
                $message = $this->validationErrorToMessage($error);
                $errorResponse->addMessage($message);
            }

            return $errorResponse;
        }

        return null;
    }

    /**
     * Convert validation error to message object
     *
     * @param ConstraintViolationInterface $error
     * @return MessageInterface
     */
    protected function validationErrorToMessage(ConstraintViolationInterface $error): MessageInterface
    {
        $message = $this->messageFactory->create();
        $message->setType(MessageInterface::TYPE_ERROR);
        $message->setCode($this->getErrorCode($error));
        $message->setSeverity(MessageInterface::SEVERITY_RECOVERABLE);
        $message->setContent((string) $error->getMessage());

        return $message;
    }

    /**
     * Get error code from validation error
     *
     * @param ConstraintViolationInterface $error
     * @return string
     */
    protected function getErrorCode(ConstraintViolationInterface $error): string
    {
        // Generate error code from property path
        $propertyPath = $error->getPropertyPath();
        $path = preg_replace('/^rawData/', '', $propertyPath);
        $path = preg_replace('/\[([^\]]+)\]/', '_$1', (string) $path);
        $path = ltrim((string) $path, '._');

        return 'invalid_' . str_replace('.', '_', $path);
    }

    /**
     * Get validator instance
     *
     * @return ValidatorInterface
     */
    protected function getValidator(): ValidatorInterface
    {
        if (!isset($this->validator)) {
            $loader = new StaticMethodLoader();
            $metadataFactory = new LazyLoadingMetadataFactory($loader);

            $this->validator = Validation::createValidatorBuilder()
                ->setMetadataFactory($metadataFactory)
                ->getValidator();
        }

        return $this->validator;
    }
}
