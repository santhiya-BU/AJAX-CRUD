<?php
declare(strict_types=1);

namespace App\Controller;

class BooksController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Books');
        $this->loadModel('Publishers');
        $this->loadModel('Authors');
        $this->loadComponent('Flash');
    }

    
    // public function index()
    // {
    //     $this->paginate = [
    //         'contain' => ['Publishers', 'Authors'],
    //     ];
    //     $books = $this->paginate($this->Books);

    //     $this->set(compact('books'));
    // }

    public function index()
    {
        $query = $this->Books->find('all', ['contain' => ['Authors', 'Publishers']]);

        $filters = $this->request->getQuery();

        // Apply filters dynamically
        if (!empty($filters['title'])) {
            $query->where(['Books.title LIKE' => '%' . $filters['title'] . '%']);
        }
        
        if (!empty($filters['author'])) {
            $query->where(['Authors.name LIKE' => '%' . $filters['author'] . '%']);
        }

        if (!empty($filters['publisher'])) {
            $query->where(['Publishers.name LIKE' => '%' . $filters['publisher'] . '%']);
        }

        $books = $this->paginate($query);
        $this->set(compact('books'));

        if ($this->request->is('ajax')) {
            $this->viewBuilder()->disableAutoLayout();
            $this->render('index');
        }

        
    }

    public function fetch()
{
    $this->request->allowMethod(['get', 'ajax']);
    
    // Disable layout rendering
    $this->viewBuilder()->setLayout(null);

    $query = $this->Books->find('all', [
        'contain' => ['Authors', 'Publishers']
    ]);

    // Search filters
    $title = $this->request->getQuery('title');
    $sort = $this->request->getQuery('sort');
    $year = $this->request->getQuery('year');

    if (!empty($title)) {
        $query->where(['Books.title LIKE' => '%' . $title . '%']);
    }

    if (!empty($year)) {
        $query->where(['Books.published_year' => $year]);
    }

    if (!empty($sort)) {
        $direction = $sort === 'title_asc' ? 'ASC' : 'DESC';
        $query->order(['Books.title' => $direction]);
    }

    $books = $query->all();
    
    // Return JSON response with books
    $this->set([
        'books' => $books,
        '_serialize' => ['books']
    ]);
}

    
    
 
    public function view($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => ['Publishers', 'Authors'],
        ]);

        $this->set(compact('book'));
    }

    public function add()
    {
        $book = $this->Books->newEmptyEntity();
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $publishers = $this->Books->Publishers->find('list', ['limit' => 200])->all();
        
        $authors = $this->Books->Authors->find('list', ['limit' => 200])->all();
        $this->set(compact('book', 'publishers', 'authors'));
    }

  
    public function edit($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $publishers = $this->Books->Publishers->find('list', ['limit' => 200])->all();
       
        $authors = $this->Books->Authors->find('list', ['limit' => 200])->all();
        $this->set(compact('book', 'publishers', 'authors'));
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
