<?php include __DIR__ . '/../header.php'; ?>
<div class="container p-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <form action="/users/login" method="POST">
                    <h3 class="text-center">Login</h3>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <?php echo $error ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $_POST['email'] ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <input type="submit" value="Submit" class="btn btn-dark">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
