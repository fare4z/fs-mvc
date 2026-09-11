<header class="bg-primary text-white text-center py-5 bg-gradient">
    <div class="container">
        <h1>Dashboard</h1>
    </div>
</header>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                      
<h3>Jumlah Data : <?= $totalUsers ?> Orang.</h3>
                        <h4 class="mb-3">Senarai Pengguna</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Nama</th>
                                        <th>No. IC</th>
                                        <th>Program</th>
                                        <th>Role</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <?php if (!empty($users)) { ?>
                                    <?php
                                    $bil = 1;
                                    foreach ($users as $row) {
                                        $name = htmlspecialchars($row['name']);
                                        $nric = htmlspecialchars($row['nric']);
                                        $program = htmlspecialchars($row['program']);
                                        $role = htmlspecialchars($row['role']);
                                        $id = $row['id'];
                                        
                                    ?>
                                        <tr>
                                            <td><?= $bil ?></td>
                                            <td><?= $name ?></td>
                                            <td><?= $nric ?></td>
                                            <td><?= $program ?></td>
                                            <td><?= $role ?></td>
                                            <td>
                                                <a href="index.php?action=edit&&id=<?= $id ?>" class="btn btn-sm btn-warning">Update</a>
                                                <form method="POST" action="index.php?action=delete" onsubmit="return confirm('Padam rekod ini?')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $id ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>

                                            </td>
                                        </tr>
                                    <?php $bil++;
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">Tiada Data</td>
                                    </tr>
                                <?php } ?>
                            </table>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

