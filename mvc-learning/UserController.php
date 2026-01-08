<?php
class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function showUserTable() {
        $result = $this->userModel->getAllUsers();
        include 'usertable_view.php'; 
    }


        
}