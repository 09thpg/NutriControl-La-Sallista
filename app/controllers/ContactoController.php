<?php

require_once APP_PATH . '/core/Controller.php';

class ContactoController extends Controller
{
    public function index(): void
    {
        $this->view('contacto/index');
    }
}