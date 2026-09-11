<header class="bg-primary text-white text-center py-5 bg-gradient">
    <div class="container">
        <h1>Update User</h1>
    </div>
</header>

<section class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label fw-medium">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo $user['name'];?>">
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-medium">NRIC</label>
                <input type="text" class="form-control" name="nric" value="<?php echo $user['nric'];?>">
            </div>

            <div class="mb-3">
                <label for="program" class="form-label fw-medium">Program</label>
                <input type="text" class="form-control" name="program" value="<?php echo $user['program'];?>">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label fw-medium">Role</label>
                <select name="role" class="form-select">
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="btnUpdate">Update</button>
        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>