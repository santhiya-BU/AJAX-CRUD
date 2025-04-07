<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Publisher extends Entity
{
    
    protected $_accessible = [
        'name' => true,
        'address' => true,
        'phone' => true,
        'created' => true,
        'modified' => true,
        'books' => true,
    ];
}
