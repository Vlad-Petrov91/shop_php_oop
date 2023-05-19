<?php

namespace app\models\entities;

use app\models\Model;

class User extends Model
{
    protected ?int $id;
    protected ?string $login;

    protected ?string $pass;
    protected ?string $name;
    protected ?string $cookieHash;
    protected ?bool $isAdmin;
    protected $props = [
        'login' => false,
        'pass' => false,
        'name' => false,
        'cookieHash' => false
    ];

    public function __construct(string $login = null, string $pass = null, string $name = null, string $cookieHash = null, bool $isAdmin = null)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->name = $name;
        $this->cookieHash = $cookieHash;
        $this->isAdmin = $isAdmin;

    }
}