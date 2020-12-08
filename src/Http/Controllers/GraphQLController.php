<?php

namespace Statamic\Http\Controllers;

use Facades\Statamic\GraphQL\TypeRepository;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Illuminate\Http\Request;

class GraphQLController
{
    public function index(Request $request)
    {
        $result = GraphQL::executeQuery(
            $this->schema(),
            $request->input('query'),
            null,
            null,
            $request->input('variables')
        );

        return $result->toArray();
    }

    protected function schema()
    {
        return new Schema([
            'query' => TypeRepository::query(),
            'types' => TypeRepository::registered(),
            'typeLoader' => function ($name) {
                return TypeRepository::get($name);
            },
        ]);
    }
}