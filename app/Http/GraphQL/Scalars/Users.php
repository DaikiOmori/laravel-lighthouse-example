<?php

namespace App\Http\GraphQL\Scalars;

use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Error\Error;
use GraphQL\Language\AST\ListValueNode;
use GraphQL\Language\AST\ObjectValueNode;
use GraphQL\Language\AST\ObjectFieldNode;

class Users extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param string $value
     * @return string
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     */
    public function parseValue($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * @param Node $valueNode
     * @param array|null $variables
     *
     * @return mixed
     */
    public function parseLiteral($valueNode, array $variables = null)
    {
        // 今回はデータが配列であるかどうかだけをチェックしていますが、実際はもう少ししっかりチェックすることになると思います
        if (!$valueNode instanceof ListValueNode) {
            throw new Error('Query error: Can only parse List got: '.$valueNode->kind, [$valueNode]);
        }

        return $this->argValue($valueNode);
    }

    /**
     * GraphQLが持つ型から最終的な配列データを取得する
     *
     * @param $arg mixed
     * @return array
     */
    private function argValue($arg)
    {
        if ($arg instanceof ListValueNode) {
            return collect($arg->values)->map(function ($node) {
                return $this->argValue($node);
            })->toArray();
        }

        if ($arg instanceof ObjectValueNode) {
            return collect($arg->fields)->mapWithKeys(function ($field) {
                return [$field->name->value => $this->argValue($field)];
            })->toArray();
        }

        if ($arg instanceof ObjectFieldNode) {
            return $this->argValue($arg->value);
        }

        return $arg->value;
    }
}
