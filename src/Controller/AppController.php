<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationService;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');

        // Récupérer l'utilisateur connecté
        $this->set('current_user', $this->Authentication->getIdentity());

        // Charger les menus depuis la base de données
        if ($this->Authentication->getIdentity()) {
            try {
                $menusTable = TableRegistry::getTableLocator()->get('Menus');
                $menus = $menusTable->find()
                    ->order(['ordre' => 'ASC'])
                    ->all();
                
                $this->set('menus', $menus);
            } catch (\Exception $e) {
                // Gestion silencieuse des erreurs en production
            }
        }
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();

        // Charge l'identifiant et l'authentificateur
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ]
        ]);

        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'email',
                'password' => 'password',
            ],
            'loginUrl' => '/users/login',
        ]);

        return $service;
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        // Charger les menus
        $menusTable = TableRegistry::getTableLocator()->get('Menus');
        $menus = $menusTable->find('all', ['order' => ['ordre' => 'ASC']]);
        $this->set('menus', $menus);
    }
}
