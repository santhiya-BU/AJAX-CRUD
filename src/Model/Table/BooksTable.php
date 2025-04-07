<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class BooksTable extends Table
{
   
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('books');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Publishers', [
            'foreignKey' => 'publisher_id',
        ]);
        $this->belongsTo('Authors', [
            'foreignKey' => 'author_id',
        ]);
        $this->belongsToMany('Publishers', [
            'joinTable' => 'books_publishers',
            'foreignKey' => 'book_id',
            'targetForeignKey' => 'publisher_id',
            // 'through' => 'BooksPublishers'
        ]);
        $this->belongsToMany('Authors', [
            'joinTable' => 'authors_books',
            'foreignKey' => 'book_id',
            'targetForeignKey' => 'author_id',
            // 'through' => 'AuthorsBooks',
        ]);
    }


    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->integer('publisher_id')
            ->allowEmptyString('publisher_id');

        $validator
            ->integer('author_id')
            ->allowEmptyString('author_id');

        $validator
            ->date('published_date')
            ->allowEmptyDate('published_date');

        return $validator;
    }

 
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('publisher_id', 'Publishers'), ['errorField' => 'publisher_id']);
        $rules->add($rules->existsIn('author_id', 'Authors'), ['errorField' => 'author_id']);

        return $rules;
    }
}
