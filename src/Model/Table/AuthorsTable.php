<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class AuthorsTable extends Table
{
   
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('authors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    

        $this->hasMany('Books', [
            'foreignKey' => 'author_id',
        ]);
        $this->belongsToMany('Publishers', [
            'joinTable' => 'authors_publishers',
            'foreignKey' => 'author_id',
            'targetForeignKey' => 'publisher_id',
            // 'through' => 'AuthorsPublishers'
        ]);
        $this->belongsToMany('Books', [
            'joinTable' => 'authors_books',
            'foreignKey' => 'author_id',
            'targetForeignKey' => 'book_id',
            'through' => 'AuthorsBooks'
        ]);
    }

  
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('bio')
            ->allowEmptyString('bio');

        return $validator;
    }
}
