<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Author extends Entity
{
   
    protected $_accessible = [
        'name' => true,
        'bio' => true,
        'created' => true,
        'modified' => true,
        'books' => true,
    ];
}
