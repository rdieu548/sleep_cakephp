<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Log\Log;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MenusController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Autoriser l'action reorder pour les utilisateurs authentifiés
        $this->Authentication->addUnauthenticatedActions(['reorder']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $menus = $this->paginate($this->Menus);

        $this->set(compact('menus'));
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('menu'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menu = $this->Menus->newEmptyEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $this->set(compact('menu'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The menu could not be saved. Please, try again.'));
        }
        $this->set(compact('menu'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function reorder()
    {
        $this->request->allowMethod(['post']);
        
        // Désactiver le rendu de la vue
        $this->autoRender = false;
        
        // Configuration de la réponse en JSON
        $this->response = $this->response->withType('application/json');
        
        try {
            // Récupérer les données JSON du corps de la requête
            $rawBody = $this->request->getBody()->getContents();
            Log::debug('Raw body: ' . $rawBody);
            
            $orders = json_decode($rawBody, true);
            Log::debug('Decoded orders: ' . print_r($orders, true));
            
            $success = true;
            
            if ($orders) {
                foreach ($orders as $item) {
                    $menu = $this->Menus->get($item['id']);
                    $menu->ordre = $item['ordre'];
                    if (!$this->Menus->save($menu)) {
                        $success = false;
                        break;
                    }
                }
            } else {
                $success = false;
            }
            
            return $this->response->withStringBody(json_encode([
                'success' => $success
            ]));
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'ordre: ' . $e->getMessage());
            return $this->response->withStringBody(json_encode([
                'success' => false,
                'error' => 'Une erreur est survenue: ' . $e->getMessage()
            ]));
        }
    }
}
