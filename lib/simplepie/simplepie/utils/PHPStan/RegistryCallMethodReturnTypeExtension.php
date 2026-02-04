<?php

// SPDX-FileCopyrightText: 2024 Jan Tojnar
// SPDX-License-Identifier: BSD-3-Clause

declare(strict_types=1);

namespace SimplePieUtils\PHPStan;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use PHPStan\Reflection\ReflectionProvider;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;

/**
 * Fixes return type for `Registry::call()` to match the called method.
 */
class RegistryCallMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    /** @var ReflectionProvider */
    private $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getClass(): string
    {
        return 'SimplePie\Registry';
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'call';
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        // The method will be called as `$registry->call($className, $methodName, $arguments)`.
        $args = $methodCall->getArgs();

        if (count($args) < 2) {
            // Not enough arguments to determine the return type.
            return new MixedType();
        }

        $classNameArg = $args[0]->value;
        $methodNameArg = $args[1]->value;
        $argumentsArg = $args[2]->value ?? null;

        $classType = $scope->getType($classNameArg);
        $methodType = $scope->getType($methodNameArg);

        if (!$classType  instanceof ConstantStringType || !$methodType instanceof ConstantStringType) {
            return new MixedType();
        }

        $className = $classType->getValue();
        if (!$this->reflectionProvider->hasClass($className)) {
            return new MixedType();
        }

        $classReflection = $this->reflectionProvider->getClass($className);

        $methodName = $methodType->getValue();
        if (!$classReflection->hasMethod($methodName)) {
            return new MixedType();
        }

        $methodReflection = $classReflection->getMethod($methodName, $scope);

        $argumentTypes = [];
        if ($argumentsArg !== null) {
            $argumentsType = $scope->getType($argumentsArg);

            if ($argumentsType instanceof ConstantArrayType) {
                $argumentTypes = $argumentsType->getValueTypes();
            } elseif ($argumentsType instanceof ArrayType) {
                $argumentTypes = [$argumentsType->getItemType()];
            } else {
                return new MixedType();
            }
        }

        $parametersAcceptor = ParametersAcceptorSelector::selectFromTypes(
            $argumentTypes,
            $methodReflection->getVariants(),
            false
        );

        return $parametersAcceptor->getReturnType();
    }
}
