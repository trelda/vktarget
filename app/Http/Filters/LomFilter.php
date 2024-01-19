<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;

class LomFilter extends AbstractFilter {
    public const ID = 'id';
    public const URL = 'url';
    public const TYPE = 'type';
    public const FOLLOWER_NAME = 'follower_name';
    public const FRIENDS = 'friends';
    public const FOLLOWERS = 'followers';

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
            self::FOLLOWER_NAME => [$this, 'follower_name'],
            self::FRIENDS => [$this, 'friends'],
            self::FOLLOWERS => [$this, 'followers'],
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
    public function follower_name(Builder $builder, $value)
    {
        $builder->where('follower_name', 'like', "%{$value}%");
    }
    public function friends(Builder $builder, $value)
    {
        $builder->where('friends', $value);
    }
    public function followers(Builder $builder, $value)
    {
        $builder->where('followers', $value);
    }
}