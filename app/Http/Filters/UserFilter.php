<?php

namespace App\Http\Filters;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends AbstractFilter {
    public const ID = 'id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const ROLE = 'role';
    public const TOKEN = 'token';

    /**
     * Summary of getCallbacks
     * @return array
     */
    protected function getCallbacks(): array
    {
        return [
            self::ID => [$this, 'id'],
            self::NAME => [$this, 'name'],
            self::EMAIL => [$this, 'email'],
            self::ROLE => [$this, 'role'],
            self::TOKEN => [$this, 'token'],
        ];
    }

    public function id(Builder $builder, $value)
    {
        $builder->where('id', $value);
    }
    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function email(Builder $builder, $value)
    {
        $builder->where('email', 'like', "%{$value}%");
    }

    public function role(Builder $builder, $value)
    {
        $builder->where('role', $value);
    }
    public function token(Builder $builder, $value)
    {
        $builder->where('token', $value);
    }

}