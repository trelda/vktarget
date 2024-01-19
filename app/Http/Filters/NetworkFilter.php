<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;

class NetworkFilter extends AbstractFilter {
    public const ID = 'id';
    public const URL = 'url';
    public const TYPE = 'type';

    /**
     * Summary of getCallbacks
     * @return array
     */
    protected function getCallbacks(): array
    {
        return [
            self::ID => [$this, 'id'],
            self::URL => [$this, 'url'],
            self::TYPE => [$this, 'type'],
        ];
    }

    public function id(Builder $builder, $value)
    {
        $builder->where('id', $value);
    }
    public function url(Builder $builder, $value)
    {
        $builder->where('url', 'like', "%{$value}%");
    }

    public function type(Builder $builder, $value)
    {
        $builder->where('type', 'like', "%{$value}%");
    }
}