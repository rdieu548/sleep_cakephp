<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;

class UsersController extends AppController
{
    public function register() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($user->getErrors()) {
                // Gérer les erreurs
            } else {
                // Enregistrer l'utilisateur
                $this->Flash->success(__('Inscription réussie.'));
                return $this->redirect(['action' => 'login']);
            }
        }
        $this->set(compact('user'));
    }
} 