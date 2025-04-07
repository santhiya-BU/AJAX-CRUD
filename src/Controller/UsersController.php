<?php
declare(strict_types=1);

namespace App\Controller;


class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadModel('Users');
    }

    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    // public function view($id = null)
    // {
    //     $author = $this->Users->get($id); // Load associated publishers

    //     $this->set(compact('users'));
    // }

    public function addEdit($id = null)
    {
        // If there's an ID, we're editing; otherwise, we're adding
        $user = $id ? $this->Users->get($id) : $this->Users->newEmptyEntity();

        // Check if form is submitted (post or put request)
        if ($this->request->is(['post', 'put'])) {
            // Handling file upload (check the correct field name)
            $profilePicture = $this->request->getData('profile_picture');

            // Ensure it's a valid file object
            if ($profilePicture && $profilePicture->getError() === UPLOAD_ERR_OK) {
                $targetPath = 'uploads' . DS . 'profile_pictures' . DS;
                $fileName = uniqid() . '_' . $profilePicture->getClientFilename();
                $targetFile = WWW_ROOT . $targetPath . $fileName;

                // Move the uploaded file to the desired folder
                if ($profilePicture->moveTo($targetFile)) {
                    $user->profile_picture = $targetPath . $fileName;  // Save file path in the database
                } else {
                    $this->Flash->error(__('The file could not be uploaded.'));
                }
            }

            // Patching data into the user entity
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to save the user.'));
        }

        // Ensure the $user variable is always set
        $this->set(compact('user'));
    }



public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('Unable to delete the user.'));
        }
        return $this->redirect(['action' => 'index']);
    }


}