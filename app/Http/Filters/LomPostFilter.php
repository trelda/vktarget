<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;

class LomPostFilter extends AbstractFilter {
    public const ID = 'id';
    public const LOM_NAME = 'lom_name';
    public const POST_LINK = 'post_link';
    public const POST_TYPE = 'post_type';
    public const POST_DATE = 'post_date';

    /**
     * Summary of getCallbacks
     * @return array
     */
    protected function getCallbacks(): array
    {
        return [
            self::ID => [$this, 'id'],
            self::LOM_NAME => [$this, 'lom_name'],
            self::POST_LINK => [$this, 'post_link'],
            self::POST_TYPE => [$this, 'post_type'],
            self::POST_DATE => [$this, 'post_date'],
        ];
    }

    public function id(Builder $builder, $value)
    {
        $builder->where('id', $value);
    }
    public function lom_id(Builder $builder, $value)
    {
        $builder->where('lom_id', 'like', "%{$value}%");
    }
    public function lom_name(Builder $builder, $value)
    {
        $builder->where('lom_name', 'like', "%{$value}%");
    }
    public function post_link(Builder $builder, $value)
    {
        $builder->where('post_link', 'like', "%{$value}%");
    }
    public function post_type(Builder $builder, $value)
    {
        $builder->where('post_type', $value);
    }
    public function post_date(Builder $builder, $value)
    {
        $builder->where('post_date', $value);
    }
}