<?php

namespace App\Models;

class StudentModel
{

    private $conn;

    public function __construct($db_connection)
    {
        $this->conn = $db_connection;
    }

    public function loginUser($nric, $password)
    {
        $sql = "SELECT id,name,password, role FROM users WHERE NRIC=?";
        $stmt = $this->conn->prepare($sql);

        // Bind
        $stmt->bind_param("s", $nric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $stmt->close();
                return $user;
            }
        }
        $stmt->close();
        return false;
    }

    public function getAllUsers() {
         $sql = "SELECT id, name, nric, program, role FROM users ORDER BY id ASC";
         $result = $this->conn->query($sql);

         if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
         }
         return []; // kalau tak ada user, return array kosong
    }

    public function getUser($nric) {
         $sql = "SELECT id,name,password, role FROM users WHERE NRIC=?";
        $stmt = $this->conn->prepare($sql);
        // Bind
        $stmt->bind_param("s", $nric);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function registerUser($name, $nric, $program, $password, $role = 'student') {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, nric, program, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("sssss", $name, $nric, $program, $hashed_password, $role);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function deleteStudent($id) {
        $sql = "DELETE FROM users WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$id);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }


}
