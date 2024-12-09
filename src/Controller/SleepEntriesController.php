<?php
declare(strict_types=1);

namespace App\Controller;

class SleepEntriesController extends AppController
{
    public function index()
    {
        $user = $this->request->getAttribute('identity');
        
        $entries = $this->SleepEntries->find()
            ->where(['user_id' => $user->id])
            ->order(['date' => 'DESC'])
            ->all();
            
        $this->set(compact('entries'));
    }
} 