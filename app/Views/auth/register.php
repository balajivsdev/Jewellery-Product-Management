
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Register</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo site_url('register/save'); ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="username" class="form-control" value="<?= old('username') ?>">
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>">
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirm" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                        <p class="mt-3 text-center">Already have an account? <a href="<?=base_url('login')?>">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
