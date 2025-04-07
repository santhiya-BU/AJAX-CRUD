<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class UsersTable extends Table
{
   
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('user_table');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

    }

  
    public function validationDefault(Validator $validator): Validator
    {
        $validator
        ->notEmptyString('name', 'Name is required')
        ->notEmptyString('email', 'Email is required')
        ->email('email', false, 'Invalid email address')
        ->notEmptyString('password', 'Password is required');


        return $validator;
    }
}
