<header class="bg-primary text-white text-center py-5 bg-gradient">
    <div class="container">
        <h1>Welcome to Task Management System</h1>
        <p class="lead">Your simple and effective way to manage tasks efficiently</p>
        <a href="index.php?action=register" class="btn btn-light btn-lg">Get Started</a>

        <?php


        if (isset($_COOKIE['username'])) {
            // echo "Welcome " . $_COOKIE['username'];
        }

        if (isset($_SESSION['firstName'])) {
            echo "Session : " .$_SESSION['firstName'];
        }
        ?>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <i class="fas fa-tasks fa-3x mb-3 text-primary"></i>
                <h3>Organize Your Tasks</h3>
                <p>Keep track of all your tasks in one place. Easily manage what needs to be done.</p>


            </div>
            <div class="col-md-4">
                <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                <h3>Mark as Completed</h3>
                <p>Update your tasks to reflect their current status, and mark them as completed when done.</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-bell fa-3x mb-3 text-warning"></i>
                <h3>Stay Notified</h3>
                <p>Receive timely reminders and stay on top of your tasks with notifications.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-4">Why Choose Our Task Management System?</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Simple & Intuitive</h4>
                <p>Our system is designed with simplicity in mind. You don’t need to be a tech expert to get
                    started.</p>
            </div>
            <div class="col-md-6">
                <h4>Secure & Reliable</h4>
                <p>Your data is secure with us. We prioritize the security and privacy of your information.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h4>Accessible Anywhere</h4>
                <p>Manage your tasks from any device, whether you’re at home, in the office, or on the go.</p>
            </div>
            <div class="col-md-6">
                <h4>Free to Use</h4>
                <p>Get started with no cost. Our system is free to use, with no hidden fees or subscriptions.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Cuti Umum Malaysia 2026</h2>
        <div id="holidays-loading" class="text-center text-muted">
            <i class="fas fa-spinner fa-spin"></i> Memuatkan senarai cuti...
        </div>
        <div id="holidays-error" class="alert alert-danger d-none" role="alert"></div>
        <div class="table-responsive">
            <table id="holidays-table" class="table table-striped table-bordered d-none">
                <thead class="table-primary">
                    <tr>
                        <th>Tarikh</th>
                        <th>Perayaan</th>
                    </tr>
                </thead>
                <tbody id="holidays-body"></tbody>
            </table>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadingEl = document.getElementById('holidays-loading');
        const errorEl = document.getElementById('holidays-error');
        const tableEl = document.getElementById('holidays-table');
        const bodyEl = document.getElementById('holidays-body');

        fetch('https://p4c6e4mu4k5sg4fwnertd2zgwi0hordn.lambda-url.eu-north-1.on.aws/api/holidays?countryCode=MY&year=2026')
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }
                return response.json();
            })
            .then(function (holidays) {
                bodyEl.innerHTML = '';

                holidays.sort(function (a, b) {
                    return new Date(a.date) - new Date(b.date);
                });

                holidays.forEach(function (holiday) {
                    const row = document.createElement('tr');

                    const dateCell = document.createElement('td');
                    dateCell.textContent = holiday.date;

                    const nameCell = document.createElement('td');
                    nameCell.textContent = holiday.title ? (holiday.title.original || holiday.title.en) : holiday.name;

                    row.appendChild(dateCell);
                    row.appendChild(nameCell);
                    bodyEl.appendChild(row);
                });

                loadingEl.classList.add('d-none');
                tableEl.classList.remove('d-none');
            })
            .catch(function (error) {
                loadingEl.classList.add('d-none');
                errorEl.textContent = 'Gagal memuatkan senarai cuti umum: ' + error.message;
                errorEl.classList.remove('d-none');
            });
    });
</script>

