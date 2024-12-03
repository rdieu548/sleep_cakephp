<?php
namespace App\View\Helper;

use Cake\View\Helper;

class AuthenticationHelper extends Helper
{
    public function getIdentity()
    {
        return $this->getView()->getRequest()->getAttribute('identity');
    }

    public function isLoggedIn()
    {
        return $this->getIdentity() !== null;
    }
} 