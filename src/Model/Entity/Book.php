<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Book extends Entity
{
        
    protected $_accessible = [
        'title' => true,
        'publisher_id' => true,
        'author_id' => true,
        'published_date' => true,
        'created' => true,
        'modified' => true,
        'publisher' => true,
        'author' => true,
    ];
}
