<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;

class MenuCell extends Cell
{
    public function display()
    {
        $currentUser = $this->request->getAttribute('identity');
        $isAdmin = (bool)$currentUser->is_admin;
        
        $query = $this->fetchTable('Menus')->find();
        
        // Si l'utilisateur n'est pas admin, on cache les menus d'administration
        if (!$isAdmin) {
            $query->where([
                'intitule NOT IN' => ['Menu', 'Utilisateurs']
            ]);
        }
        
        $menus = $query
            ->order(['ordre' => 'ASC'])
            ->all();
        
        $this->set('menus', $menus);
    }
} 