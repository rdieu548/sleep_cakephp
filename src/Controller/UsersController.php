<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Mailgun\Mailgun;

class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        $this->Authentication->allowUnauthenticated(['login', 'register', 'forgotPassword']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        
        if ($this->request->is('post')) {
            if ($result->isValid()) {
                // Redirection après connexion réussie
                $target = $this->Authentication->getLoginRedirect() ?? '/';
                return $this->redirect($target);
            }
            
            // En cas d'échec de connexion
            $this->Flash->error('Email ou mot de passe incorrect.');
        }

        // Si l'utilisateur est déjà connecté, redirigez-le
        if ($result->isValid()) {
            return $this->redirect('/');  // Redirection vers la page d'accueil
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            
            // Log the hashed password
            Log::debug('Mot de passe haché : ' . $user->password);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Inscription réussie.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('L\'inscription a échoué. Veuillez réessayer.'));
        }
        $this->set(compact('user'));
    }

    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $user = $this->Users->findByEmail($email)->first();
            
            if ($user) {
                try {
                    $newPassword = bin2hex(random_bytes(4)); // Génère un mot de passe aléatoire
                    $user->password = $newPassword; // Le hachage est géré par l'entité
                    
                    if ($this->Users->save($user)) {
                        // Envoyer l'email avec le nouveau mot de passe
                        try {
                            $this->sendNewPasswordEmail($user->email, $newPassword);
                            $this->Flash->success('Un nouveau mot de passe a été envoyé à votre adresse email.');
                            return $this->redirect(['action' => 'login']);
                        } catch (\Exception $e) {
                            Log::error('Erreur envoi email : ' . $e->getMessage());
                            $this->Flash->error('Le mot de passe a été réinitialisé mais l\'envoi de l\'email a échoué.');
                        }
                    }
                } catch (\Exception $e) {
                    $this->Flash->error('Une erreur est survenue. Veuillez réessayer.');
                    Log::error('Erreur mot de passe oublié : ' . $e->getMessage());
                }
            } else {
                $this->Flash->error('Aucun utilisateur trouvé avec cet email.');
            }
        }
    }

    private function sendNewPasswordEmail($userEmail, $newPassword)
    {
        try {
            Log::debug('Début de sendNewPasswordEmail');
            
            // Configuration Mailgun
            $apiKey = "9d222fc94e5f99704f0b6b5200a05906-f55d7446-d4256860";
            $domain = "sandboxb7fe04c41fb94359a12af4667e209fb3.mailgun.org";
            
            Log::debug('Configuration : ' . json_encode([
                'domain' => $domain,
                'to' => $userEmail
            ]));
            
            // Créer une instance du client Mailgun avec debug activé
            $mgClient = Mailgun::create($apiKey, 'https://api.mailgun.net/v3');
            
            Log::debug('Client Mailgun créé');
            
            // Préparer les données
            $params = [
                'from'    => 'WebAPP <mailgun@' . $domain . '>',
                'to'      => $userEmail,
                'subject' => 'Votre nouveau mot de passe - WebAPP',
                'text'    => "Votre nouveau mot de passe est : {$newPassword}",
                'html'    => "<h3>Votre nouveau mot de passe est : <strong>{$newPassword}</strong></h3>"
            ];
            
            Log::debug('Paramètres email : ' . json_encode($params));
            
            try {
                // Envoyer l'email
                $result = $mgClient->messages()->send($domain, $params);
                Log::debug('Résultat Mailgun : ' . json_encode($result));
                Log::debug('Email envoyé avec succès');
                return true;
            } catch (\Mailgun\Exception\HttpClientException $e) {
                Log::error('Erreur HTTP Mailgun : ' . $e->getMessage());
                throw $e;
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur envoi email : ' . $e->getMessage());
            Log::error('Type d\'erreur : ' . get_class($e));
            Log::error('Trace : ' . $e->getTraceAsString());
            throw $e;
        }
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function index()
    {
        $this->paginate = [
            'limit' => 10,  // nombre d'éléments par page
            'order' => [
                'Users.id' => 'asc'
            ]
        ];
        
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success('L\'utilisateur a été supprimé.');
        } else {
            $this->Flash->error('L\'utilisateur n\'a pas pu être supprimé.');
        }
        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Si le mot de passe est vide, on le retire des données à mettre à jour
            if (empty($data['password'])) {
                unset($data['password']);
            }
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('L\'utilisateur a été modifié.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('L\'utilisateur n\'a pas pu être modifié. Veuillez réessayer.'));
        }
        $this->set(compact('user'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }
}
