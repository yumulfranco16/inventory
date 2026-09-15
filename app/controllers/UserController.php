<?php
require_once __DIR__ . '/../models/User.php';
class UserController {
    private $user;
    public function __construct($conn){$this->user=new User($conn);}
    private function requireLogin(){
        if(session_status()===PHP_SESSION_NONE) session_start();
        if(!isset($_SESSION['user_id'])){header('Location:index.php?action=login');exit;}
    }
    private function requireAdmin(){
        $this->requireLogin(); if(($_SESSION['role']??'user')!=='admin'){http_response_code(403); die('Access denied. Administrator privileges are required.');}
    }
    public function index(){ $this->requireAdmin(); $users=$this->user->getAll(); require __DIR__.'/../views/users/index.php'; }
    public function create(){
        $this->requireAdmin(); $error=null;
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $username=trim($_POST['username']??''); $password=$_POST['password']??''; $confirm=$_POST['confirm_password']??'';
            $role=$_POST['role']??'user'; $status=$_POST['status']??'active';
            if(strlen($username)<3) $error='Username must be at least 3 characters.';
            elseif(strlen($password)<6) $error='Password must be at least 6 characters.';
            elseif($password!==$confirm) $error='Passwords do not match.';
            elseif(!in_array($role,['admin','user'],true) || !in_array($status,['active','inactive'],true)) $error='Invalid role or status.';
            elseif($this->user->findByUsername($username)) $error='Username already exists.';
            elseif($role==='admin' && $status==='active' && $this->user->create($username,$password,$role,$status)) { header('Location:index.php?action=users');exit; }
            elseif($this->user->create($username,$password,$role,$status)) { header('Location:index.php?action=users');exit; }
            else $error='Failed to create user.';
        }
        require __DIR__.'/../views/users/create.php';
    }
    public function edit(){
        $this->requireAdmin(); $id=(int)($_GET['id']??0); $target=$this->user->find($id); if(!$target) die('User not found.'); $error=null;
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $username=trim($_POST['username']??''); $role=$_POST['role']??'user'; $status=$_POST['status']??'active';
            if(strlen($username)<3) $error='Username must be at least 3 characters.';
            elseif(!in_array($role,['admin','user'],true)||!in_array($status,['active','inactive'],true)) $error='Invalid role or status.';
            elseif(($existing=$this->user->findByUsername($username)) && (int)$existing['id']!==$id) $error='Username already exists.';
            elseif($id===(int)$_SESSION['user_id'] && ($status==='inactive'||$role!=='admin')) $error='You cannot deactivate yourself or remove your own administrator role.';
            elseif($target['role']==='admin' && $target['status']==='active' && ($role!=='admin'||$status!=='active') && $this->user->countAdmins($id)<1) $error='At least one active administrator must remain.';
            elseif($this->user->update($id,$username,$role,$status)) { header('Location:index.php?action=users');exit; }
            else $error='Failed to update user.';
            $target['username']=$username; $target['role']=$role; $target['status']=$status;
        }
        require __DIR__.'/../views/users/edit.php';
    }
    public function changePassword(){
        $this->requireLogin(); $isAdmin=($_SESSION['role']??'user')==='admin'; $targetId=(int)($_GET['id']??$_SESSION['user_id']);
        if(!$isAdmin && $targetId!==(int)$_SESSION['user_id']){http_response_code(403);die('Access denied.');}
        $target=$this->user->find($targetId); if(!$target) die('User not found.'); $error=null;
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $password=$_POST['password']??''; $confirm=$_POST['confirm_password']??'';
            if(strlen($password)<6)$error='Password must be at least 6 characters.';
            elseif($password!==$confirm)$error='Passwords do not match.';
            elseif($this->user->updatePassword($targetId,$password)){header('Location:index.php?action=' . ($isAdmin?'users':'dashboard'));exit;}
            else $error='Failed to change password.';
        }
        require __DIR__.'/../views/users/change_password.php';
    }
    public function toggleStatus(){
        $this->requireAdmin(); if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:index.php?action=users');exit;}
        $id=(int)($_POST['id']??0); $target=$this->user->find($id);
        if(!$target || $id===(int)$_SESSION['user_id']) die('You cannot change your own status here.');
        $new=$target['status']==='active'?'inactive':'active';
        if($target['role']==='admin' && $target['status']==='active' && $new==='inactive' && $this->user->countAdmins($id)<1) die('At least one active administrator must remain.');
        if($this->user->update($id,$target['username'],$target['role'],$new)){header('Location:index.php?action=users');exit;} die('Unable to update user status.');
    }
    public function delete(){
        $this->requireAdmin(); if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:index.php?action=users');exit;}
        $id=(int)($_POST['id']??0); $target=$this->user->find($id);
        if(!$target) die('User not found.'); if($id===(int)$_SESSION['user_id'])die('You cannot delete your current account.');
        if($target['role']==='admin' && $target['status']==='active' && $this->user->countAdmins($id)<1)die('At least one active administrator must remain.');
        if($this->user->delete($id)){header('Location:index.php?action=users');exit;} die('Unable to delete user.');
    }
}
