<?php
declare(strict_types=1);

namespace App\Controller;


class PublishersController extends AppController
{
    
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Authors');
        $this->loadModel('Books');
        $this->loadComponent('Paginator');
        // $this->viewBuilder()->setLayout('publisher');
    }

    public function index()
    {
        $publishers = $this->paginate($this->Publishers);

        $this->set(compact('publishers'));

    }

  
    public function view($id = null)
    {
        $publisher = $this->Publishers->get($id, [
            'contain' => ['Books'],
        ]);

        $this->set(compact('publisher'));
    }

   
    public function add()
    {
        $publisher = $this->Publishers->newEmptyEntity();
        if ($this->request->is('post')) {
            $publisher = $this->Publishers->patchEntity($publisher, $this->request->getData());
            if ($this->Publishers->save($publisher)) {
                $this->Flash->success(__('The publisher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The publisher could not be saved. Please, try again.'));
        }
        $this->set(compact('publisher'));
    }

  
    public function edit($id = null)
    {
        $publisher = $this->Publishers->get($id, [
            'contain' => ['Authors'], // Ensure authors are loaded
        ]);

        // Fetch authors for the selection field
        $authors = $this->Publishers->Authors->find('list');

        if ($this->request->is(['patch', 'post', 'put'])) {
            // Patch the publisher entity
            $publisher = $this->Publishers->patchEntity($publisher, $this->request->getData(), [
                'associated' => ['Authors']
            ]);

            if ($this->Publishers->save($publisher)) {
                // Update the authors_publishers join table
                $this->updateAuthorsAssociations($publisher, $this->request->getData('authors._ids'));

                $this->Flash->success(__('The publisher has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The publisher could not be saved. Please, try again.'));
        }

        $this->set(compact('publisher', 'authors'));
    }

    private function updateAuthorsAssociations($publisher, $newAuthorIds)
    {
        
        $this->Publishers->Authors->unlink($publisher, $publisher->authors);

     
        if (!empty($newAuthorIds)) {
            $authors = $this->Publishers->Authors->find()->where(['id IN' => $newAuthorIds])->toArray();
            $this->Publishers->Authors->link($publisher, $authors);
        }
    }

   
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publisher = $this->Publishers->get($id);
        if ($this->Publishers->delete($publisher)) {
            $this->Flash->success(__('The publisher has been deleted.'));
        } else {
            $this->Flash->error(__('The publisher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
