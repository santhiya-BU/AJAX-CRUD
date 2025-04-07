<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class User extends Entity
{
   
    protected $_accessible = [
        'name' => true,
        'email' => true,
        'password' => true,
        'description' => true,
        'role' => true,
        'gender' => true,
        'status' => true,
        'profile_image' => true,
        'dob' => true,

    ];
}
