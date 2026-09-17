<?php

namespace App\Controllers;

use App\Models\StudentModel;

class MainController
{
    private $studentModel;

    public function __construct(\mysqli $conn)
    {
        $this->studentModel = new StudentModel($conn);

        //  echo "<pre>";
        //  print_r($_SESSION);
        //  echo "</pre>";

    }

    public function isLoggedIn()
    {
        if (!isset($_SESSION['logged_in'])) {
            header("Location: index.php?action=login");
            exit;
        }
    }

    public function isAdmin()
    {
        if ($_SESSION['role'] != 'admin') {
            $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Restrict Area- Admin Only'];
            header("Location: index.php?action=dashboard");
            exit();
        }

        return true;
    }

    public function home()
    {
        if (isset($_SESSION['logged_in'])) {
            header("Location: index.php?action=dashboard");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/home.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function login()
    {
        if (isset($_SESSION['logged_in'])) {
            header("Location: index.php?action=dashboard");
            exit;
        }

        require_once __DIR__ . '/../views/header.php';
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nric = trim($_POST['nric']);
            $password = $_POST['password'];

            // minta model check dalam database
            $user = $this->studentModel->loginUser($nric, $password);

            if ($user) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $_SESSION['flash_msg'] = [
                    'type' => 'error',
                    'msg' => 'Invalid Credential.'
                ];
            }
        }

        require_once __DIR__ . '/../views/login.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function dashboard()
    {
        $this->isLoggedIn();
        require_once __DIR__ . '/../views/header.php';

        $users = $this->studentModel->getAllUsers();
        $totalUsers = count($users);

        require_once __DIR__ . '/../views/dashboard.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function register()
    {
        // Check user dah login ke belum. Kalau dah login, tak boleh akses register form
        if (isset($_SESSION['logged_in'])) {
            header("Location: index.php?action=dashboard");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $nric = $_POST['nric'];
            $program = $_POST['program'];
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if (strlen($nric) <> 12) {
                $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Please Enter 12 Character only'];

                header("Location: index.php?action=register");
                exit;
            }
            $user = $this->studentModel->getUser($nric);
            if ($user->num_rows >= 1) {
                $_SESSION['flash_msg'] = [
                    'type' => 'error',
                    'msg' => 'Nombor IC sudah wujud.'
                ];
                header("Location: index.php?action=login");
                die;
            }

            $registerUser = $this->studentModel->registerUser($name, $nric, $program, $password);

            // 3. Handle the result
            if ($registerUser) {
                $_SESSION['flash_msg'] = ['type' => 'success', 'msg' => 'Pendaftaran Berjaya. Sila log masuk menggunakan nombor ic dan password yang didaftarkan'];
                header("Location: index.php?action=login&status=registered");
                exit();
            } else {
                $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Pendaftaran Tidak Berjaya'];
                require_once 'views/register.php';
            }
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/register.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php");
    }

    public function delete()
    {
        $this->isAdmin();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST['id'];

            if ($this->studentModel->deleteStudent($id)) {
                $_SESSION['flash_msg'] = ['type' => 'success', 'msg' => 'Padam rekod Berjaya'];
                header("Location: index.php?action=dashboard&status=deleted");
                exit();
            } else {
                $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Padam Rekod Tidak Berjaya'];
            }
        } else {
            $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Padam Rekod Tidak Berjaya'];
            header("Location: index.php?action=dashboard");
        }
    }

    public function editUser()
    {
        $this->isAdmin();

        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars(trim($_POST['name']));
            $nric = htmlspecialchars(trim($_POST['nric']));
            $program = htmlspecialchars(trim($_POST['program']));
            $role = $_POST['role'];
            $profile_picture = $_FILES['profile_picture'];

            if ($this->studentModel->updateUser($id, $name, $nric, $program, $role)) {
                $_SESSION['flash_msg'] = [
                    'type' => 'success',
                    'msg' => 'Rekod Berjaya Dikemaskini',
                ];

                $this->uploadProfilePicture($id, $profile_picture);
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $_SESSION['flash_msg'] = [
                    'type' => 'error',
                    'msg' => 'Failed to update user',
                ];
            }
        }
        $user = $this->studentModel->getUserById($id);
        if (!$user) {
            die("Student not found");
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/edit_user.php';
        require_once __DIR__ . '/../views/footer.php';
    }

    public function uploadProfilePicture($id, $file)
    {
        $targetDir = __DIR__ . '/../../uploads/';
        $targetFile = $targetDir . basename($file['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Buat folder kalau tak wujud lagi

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Pastikan format betul'];
            return false;
        }
        // limit file size 2mb
        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'File lebih 2MB'];
            return false;
        }

        // Benarkan file gambar sahaja
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'JPG JPEG PNG GIF Sahaja'];
            return false;
        }

        // start upload
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // kalau berjaya, update dalam db
            return $this->studentModel->updateDP($id, basename($file['name']));
        } else {
            $_SESSION['flash_msg'] = ['type' => 'error', 'msg' => 'Tak berjaya'];
            return false;
        }
    }

    public function daftarMarkah()
    {
        $id = $_GET['id'];
        $data = $this->studentModel->getUserById($id);

        $name = $data['name'];
        $nric = $data['nric'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subjek = $_POST['subjek'];
            $markah = $_POST['markah'];

            $result = $this->studentModel->addMarkah($nric, $subjek, $markah);
            if ($result) {
                $_SESSION['flash_msg'] = [
                    'type' => 'success',
                    'msg' => 'Rekod Berjaya Dikemaskini',
                ];
            } else {
                $_SESSION['flash_msg'] = [
                    'type' => 'error',
                    'msg' => 'Rekod Tidak Dikemaskini',
                ];
            }

            header("Location: index.php?action=dashboard");
        }

        require_once __DIR__ . '/../views/header.php';
        require_once __DIR__ . '/../views/daftarMarkah.php';
        require_once __DIR__ . '/../views/footer.php';
    }
}
