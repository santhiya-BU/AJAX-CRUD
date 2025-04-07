<?php
declare(strict_types=1);

namespace App\Controller;


class AuthorsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Books');
        $this->loadModel('Publishers');
        $this->loadModel('Authors');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $authors = $this->paginate($this->Authors->find('all', ['contain' => ['Publishers']]));
        $this->set(compact('authors'));
    }

    public function view($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => ['Publishers'], // Load associated publishers
        ]);

        $this->set(compact('author'));
    }

   
    public function add()
    {
        $author = $this->Authors->newEmptyEntity();
        if ($this->request->is('post')) {
            $author = $this->Authors->patchEntity($author, $this->request->getData());
            if ($this->Authors->save($author)) {
                $this->Flash->success(__('The author has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The author could not be saved. Please, try again.'));
        }
        $this->set(compact('author'));
    }

   
    public function edit($id = null)
    {
        $author = $this->Authors->get($id, [
            'contain' => ['Publishers'], // Ensure publishers are loaded to show in the edit form
        ]);
        
        // Fetch the list of publishers for the dropdown
        $publishers = $this->Authors->Publishers->find('list');

        if ($this->request->is(['patch', 'post', 'put'])) {
            // Patch the author entity
            $author = $this->Authors->patchEntity($author, $this->request->getData(), [
                'associated' => ['Publishers'] // Patch the associated publishers as well
            ]);

            // Save the author first
            if ($this->Authors->save($author)) {
                // Now update the authors_publishers relationship table
                $this->updatePublishersAssociations($author, $this->request->getData('publishers._ids'));

                $this->Flash->success(__('The author has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The author could not be saved. Please, try again.'));
        }

        $this->set(compact('author', 'publishers'));
    }

    private function updatePublishersAssociations($author, $newPublisherIds)
    {
        // Remove existing associations
        $this->Authors->Publishers->unlink($author, $author->publishers);

        // If new publishers were selected, link them
        if (!empty($newPublisherIds)) {
            $publishers = $this->Authors->Publishers->find()->where(['id IN' => $newPublisherIds])->toArray(); // Convert to array
            $this->Authors->Publishers->link($author, $publishers);
        }
    }


   
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $author = $this->Authors->get($id);
        if ($this->Authors->delete($author)) {
            $this->Flash->success(__('The author has been deleted.'));
        } else {
            $this->Flash->error(__('The author could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
