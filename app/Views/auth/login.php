<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-center items-center min-h-screen">
    <div class="card w-96">
        <h3 class="text-2xl font-bold text-center mb-6 text-gray-800">Login</h3>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('message')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= site_url('login') ?>" method="post">
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-input" required autofocus>
            </div>
            <div class="mb-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-input" required>
            </div>
            <button type="submit" class="btn-primary w-full">Masuk</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
