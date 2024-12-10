<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Mailgun\Mailgun;
use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'add']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/sleep-calculator';
            return $this->redirect($target);
        }
        
        if ($this->request->is('post')) {
            parse_str($this->request->getBody()->getContents(), $postData);
            
            $user = $this->Users->find()
                ->where(['email' => $postData['email']])
                ->first();
                
            if ($user) {
                $hasher = new \Authentication\PasswordHasher\DefaultPasswordHasher();
                if ($hasher->check($postData['password'], $user->password)) {
                    $this->Authentication->setIdentity($user);
                    return $this->redirect('/');
                }
            }
            
            $this->Flash->error('Email ou mot de passe incorrect.');
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
            
            // Définir is_admin à false par défaut
            $user->is_admin = false;
            
            if ($this->Users->save($user)) {
                $this->Flash->success('Inscription réussie. Vous pouvez maintenant vous connecter.');
                return $this->redirect(['action' => 'login']);
            }
            
            if ($user->getErrors()) {
                $this->Flash->error('Impossible de créer le compte. Veuillez corriger les erreurs.');
            }
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
        // Vérifier si l'utilisateur est admin
        if (!$this->Authentication->getIdentity()->get('is_admin')) {
            $this->Flash->error('Accès non autorisé.');
            return $this->redirect(['controller' => 'SleepCalculator', 'action' => 'index']);
        }
        
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
        $currentUser = $this->request->getAttribute('identity');
        
        // Vérifier les permissions
        if (!$currentUser->is_admin && $currentUser->id !== $user->id) {
            $this->Flash->error('Vous n\'avez pas la permission de modifier cet utilisateur.');
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Ne permettre que certains champs selon le rôle
            if (!$currentUser->is_admin) {
                unset($data['is_admin']); // Seuls les admins peuvent changer ce statut
            }
            
            // Gérer le changement de mot de passe
            if (!empty($data['new_password'])) {
                if ($data['new_password'] === $data['confirm_password']) {
                    $data['password'] = $data['new_password']; // Le hachage sera fait automatiquement
                } else {
                    $this->Flash->error('Les mots de passe ne correspondent pas.');
                    $this->set(compact('user'));
                    return;
                }
            }
            
            // Supprimer les champs de mot de passe temporaires
            unset($data['new_password']);
            unset($data['confirm_password']);
            
            $user = $this->Users->patchEntity($user, $data);
            
            if ($this->Users->save($user)) {
                $this->Flash->success('Les modifications ont été enregistrées.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Impossible d\'enregistrer les modifications.');
        }
        
        $this->set(compact('user'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    // Ajouter cette méthode pour définir un utilisateur comme admin
    public function makeAdmin($id = null)
    {
        if (!$this->Authentication->getIdentity()->get('is_admin')) {
            $this->Flash->error('Accès non autorisé.');
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id);
        $user->is_admin = true;
        
        if ($this->Users->save($user)) {
            $this->Flash->success('L\'utilisateur est maintenant administrateur.');
        } else {
            $this->Flash->error('Impossible de modifier les droits de l\'utilisateur.');
        }
        
        return $this->redirect(['action' => 'index']);
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $data);
            $user->actif = true;
            $user->is_admin = false;
            
            if ($this->Users->save($user)) {
                $this->Flash->success('Inscription réussie.');
                return $this->redirect(['action' => 'login']);
            }
            
            $this->Flash->error('Erreur lors de l\'inscription.');
            Log::debug($user->getErrors());
        }
        $this->set(compact('user'));
    }
}
