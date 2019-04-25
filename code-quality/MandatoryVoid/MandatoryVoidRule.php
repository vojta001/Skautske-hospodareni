<?php

namespace CodeQuality\MandatoryVoid;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use function assert;

class MandatoryVoidRule implements Rule
{
    public function getNodeType() : string
    {
        return ClassMethod::class;
    }

    public function processNode(Node $node, Scope $scope) : array
    {
        assert($node instanceof ClassMethod);

        if($node->name->toLowerString() === '__construct') {
            return [];
        }

        $class = $scope->getClassReflection()->getName();
        $method = new \ReflectionMethod($class, $node->name);

        if($method->isAbstract()) {
            return [];
        }


        if($this->returnsNullOrNothing($node) && $method->getReturnType() != 'void') {
            return [
                sprintf(
                    'Void method %s::%s() doesn\'t use :void return type.',
                    $class,
                    $node->name
                ),
            ];
        }
        return [];
    }

    private function returnsNullOrNothing(ClassMethod $node)
    {
        $statements = $node->getStmts();

        if($statements === NULL) {
            return TRUE;
        }

        $traverser = new \PhpParser\NodeTraverser();

        $visitor = new ReturnTypeVisitor();
        $traverser->addVisitor($visitor);

        $traverser->traverse($statements);

        return $visitor->returnsNullOrNothing();
    }
}