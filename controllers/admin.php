<?php

require_once __DIR__ . '/Controller.php';

class Admin extends Controller
{
    public function page(): void
    {
        $this->render('admin/page', [
            'title' => 'Admin - Page',
        ]);
    }

    public function users(): void
    {
        $this->render('admin/users', [
            'title' => 'Admin - Utilisateurs',
        ]);
    }
}
