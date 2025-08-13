<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card p-4 shadow" style="width: 350px;">
        <h3 class="mb-4 text-center">Login</h3>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <form action="/login" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
