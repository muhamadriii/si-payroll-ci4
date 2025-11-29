<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-6 d-none d-lg-block bg-login-image">
    <img src="<?= base_url('img/login.svg') ?>" alt="Login Image" class="img-fluid">
  </div>
  <div class="col-lg-6">
    <div class="p-5">
      <div class="text-center">
        <?php if (session('error')): ?>
          <div class="alert alert-danger"><?= esc(session('error')) ?></div>
        <?php endif; ?>
        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
        <p class="text-gray-900 mb-4">Sign in to continue.</p>
      </div>
      <form class="user" method="post" action="<?= base_url('login') ?>">
        <div class="form-group">
          <input type="text" name="username" class="form-control form-control-user"
            id="exampleInputUsername" aria-describedby="username"
            placeholder="Enter Username...">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control form-control-user"
            id="exampleInputPassword" placeholder="Password">
        </div>
        <!-- <div class="form-group">
          <div class="custom-control custom-checkbox small">
            <input type="checkbox" class="custom-control-input" id="customCheck">
            <label class="custom-control-label" for="customCheck">Remember
              Me</label>
          </div>
        </div> -->
        <button type="submit" class="btn btn-primary btn-user btn-block">
          Login
        </button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>