<?php namespace Flag\Framework\Core;

abstract class SecuredController extends Controller {

    protected $loggedUser;

    public function __construct()
    {
        $this->loggedUser = Request::session('user');

        if (is_null($this->loggedUser)) {
            $this->redirect('/login');
        }
    }
}