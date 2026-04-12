<?php
// www/controllers/home.php

require_once __DIR__ . '/Controller.php';
 
class Home extends Controller
{
    public function index(): void
    {
        // Si l'utilisateur est connecté, $isConnect contient ses infos
        // Sinon $isConnect = false
        if (isset($_SESSION['user'])) {
            $isConnect = $_SESSION['user'];
        } else {
            $isConnect = false;
        }
 
        $this->render('main', [
            'isConnect' => $isConnect,
        ]);
    }
}
 