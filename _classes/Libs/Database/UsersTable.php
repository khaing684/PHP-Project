<?php

namespace Libs\Database;

use PDOException;

class UsersTable
{
    private $db = null;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function all()
    {
        $statement = $this->db->query("SELECT users.*, roles.name AS role 
        FROM users LEFT JOIN roles 
        ON users.role_id = roles.id");
        return $statement->fetchAll();
    }

    public function insert($data)
    {
        try{
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            $prepare = $this->db->prepare("INSERT INTO users (name, email, phone, address, password, role_id, created_at) VALUES ( :name, :email, :phone, :address, :password, :role_id, NOW() )");

            // $statement = $this->db->prepare($data);
            $prepare->execute($data);

            return $this->db->lastInsertId();

        }catch (PDOException $e){
            return $e->getMessage();
            exit();
        }
    }

    public function suspend($id)
    {
        $statement= $this->db->prepare("UPDATE users SET suspended=1 WHERE id=:id");
        $statement->execute(['id'=> $id]);

        return $statement->rowCount();
    }

     public function unsuspend($id)
    {
        $statement= $this->db->prepare("UPDATE users SET suspended=0 WHERE id=:id");

        $statement->execute(['id'=> $id]);

        return $statement->rowCount();
    }

     public function updateRole($id, $role)
    {
        $statement= $this->db->prepare("UPDATE users SET role_id=:role_id WHERE id=:id");
        $statement->execute(['id'=> $id , 'role_id'=> $role]);

        $statement->execute(['id'=> $id, 'role'=> $role]);

        return $statement->rowCount();
    }

    public function delete($id)
    {
        $statement = $this->db->prepare ("DELETE FROM users WHERE id=:id");

        $statement->execute(['id'=> $id]);

        return $statement->rowCount();
    }

    public function getAll()
    {
        $statement = $this->db->query("SELECT users.*, roles.name AS role, roles.value FROM users LEFT JOIN roles ON users.role_id = roles.id");

        return $statement->fetchAll();
    }

    public function findByEmailAndPassword($email, $password)
    {
        try{
 $statement = $this->db->prepare("SELECT * FROM users WHERE email=:email");
$statement->execute(['email' =>$email]);

$user = $statement->fetch();
if($user){
    if(password_verify($password, $user->password)){
        return $user;
    }
}
           
       return $row ?? false;

    }catch (PDOException $e){
        echo $e->getMessage();
        exit();
    }
}

    public function updatePhoto ($id, $name)
    {
        $statement = $this->db->prepare("UPDATE users SET photo=:name WHERE id= :id");
        $statement->execute(['name' =>$name, 'id' => $id]);

        return $statement->rowCount();
    }
}