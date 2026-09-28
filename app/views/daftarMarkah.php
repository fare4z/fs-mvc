<header class="bg-primary text-white text-center py-5 bg-gradient">
    <div class="container">
        <h1>Daftar Markah <?= $name ?></h1>
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
                                <select name="subjek" class="form-select">
                                    <optgroup label="Pilih Subjek">
                                        <option value="">-- Pilih Subjek --</option>
                                        <?php foreach ($subjects as $code => $ktrgnSubjek) { ?>
                                            <option value="<?= $code ?>"><?= $ktrgnSubjek ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="markah" class="form-label fw-medium">Markah</label>
                                <input type="number" class="form-control" name="markah">
                            </div>

                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </form>

                        <hr>
                        <h4 class="mt-4">Markah yang telah didaftar</h4>


                        <table class="table table-bordered">

                            <tr>
                                <td>Nama</td>
                                <td><?= htmlspecialchars($name) ?></td>
                            </tr>
                            <tr>
                                <td>No. IC</td>
                                <td><?= htmlspecialchars($nric) ?></td>
                            </tr>
                            <tr>
                                <td>Program</td>
                                <td><?= htmlspecialchars($program) ?></td>
                            </tr>
                        </table>

                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Subjek</th>
                                    <th>Markah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($marks as $mark) { ?>
                                    <tr>
                                        <td><?= $mark['subjek'] ?> - <?= $subjects[$mark['subjek']] ?></td>
                                        <td><?= $mark['markah'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>