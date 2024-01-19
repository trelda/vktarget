<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;

class PostFilter extends AbstractFilter {
    public const GROUP_ID = 'group_id';
    public const POST_ID = 'post_id';
    public const ADS = 'ads';
    public const CAPTION = 'caption';
    public const DATE = 'date';
    public const TEXT = 'text';
    public const VIEWS = 'views';
    public const LIKES = 'likes';
    public const REPOSTS = 'reposts';
    public const IS_REPOST = 'is_repost';
    /**
     * Summary of getCallbacks
     * @return array
     */
    protected function getCallbacks(): array
    {
        return [
            self::GROUP_ID => [$this, 'group_id'],
            self::POST_ID => [$this, 'post_id'],
            self::ADS => [$this, 'ads'],
            self::CAPTION => [$this, 'caption'],
            self::DATE => [$this, 'date'],
            self::TEXT => [$this, 'text'],
            self::VIEWS => [$this, 'views'],
            self::LIKES => [$this, 'likes'],
            self::REPOSTS => [$this, 'reposts'],
            self::IS_REPOST => [$this, 'is_repost'],
        ];
    }

    public function group_id(Builder $builder, $value)
    {
        $builder->where('group_id', $value);
    }
    public function post_id(Builder $builder, $value)
    {
        $builder->where('post_id',  $value);
    }

    public function views(Builder $builder, $value)
    {
        //$builder->where('views', 'like', "%{$value}%");
        $builder->where('views', $value);
    }
}