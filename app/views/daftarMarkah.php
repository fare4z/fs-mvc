<header class="bg-primary text-white text-center py-5 bg-gradient">
    <div class="container">
        <h1>Daftar Markah <?= $name?></h1>
    </div>
</header>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" class="form-control">
                            <div class="mb-3">
                                <label for="subjek" class="form-label fw-medium">Subjek</label>
                                <input type="text" class="form-control" name="subjek">
                            </div>

                            <div class="mb-3">
                                <label for="markah" class="form-label fw-medium">Markah</label>
                                <input type="number" class="form-control" name="markah">
                            </div>

                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>