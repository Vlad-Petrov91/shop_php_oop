<?php

namespace app\models\entities;

use app\models\Model;

class User extends Model
{
    protected ?int $id;
    protected ?string $login;
    protected ?string $pass;
    protected ?string $email;
    protected ?string $name;
    protected ?string $authToken;
    protected ?int $isConfirmed;
    protected ?int $isAdmin;
    protected $props = [
        'login' => false,
        'pass' => false,
        'email' => false,
        'name' => false,
        'authToken' => false,
        'isConfirmed' => false,
        'isAdmin' => false,
    ];

    public function __construct(string $login = null, string $pass = null, string $email = null, string $name = null, string $authToken = null, bool $isConfirmed = null, bool $isAdmin = null)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->email = $email;
        $this->name = $name;
        $this->authToken = $authToken;
        $this->isConfirmed = $isConfirmed;
        $this->isAdmin = $isAdmin;
    }
}