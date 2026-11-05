<?php

require_once APP_PATH . '/core/Controller.php';

class NosotrosController extends Controller
{
    public function index(): void
    {
        $this->view('nosotros/index');
    }
}