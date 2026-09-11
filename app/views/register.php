<header class="bg-primary text-white text-center py-5 bg-gradient">
    <div class="container">
        <h1>Membership</h1>
        <p class="lead">First time registration.</p>
    </div>
</header>

<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Registration Form</h2>
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="index.php?action=register">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Please enter your name">
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label fw-medium">NRIC</label>
                                <input type="text" class="form-control" name="nric" placeholder="Please enter your NRIC">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Please enter your password">
                            </div>

                            <div class="mb-3">
                                <label for="program" class="form-label fw-medium">Program</label>
                                <input type="text" class="form-control" name="program" placeholder="Please enter ur program code">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>