<?php include __DIR__ . '/../header.php'; ?>

<div class="container py-4">
    <h2 class="display-3 text-center mb-4">Registration</h2>
    <?php if(!empty($error)):?>
    <div class="alert alert-danger">
        <?php echo $error ?>
    </div>
    <?php endif; ?>
    <form action="/users/register" method="POST">
        <div class="form-group">
            <label for="nickname">Nickname</label>
            <input type="text" name="nickname" class="form-control" id="nickname" value="<?php echo $_POST['nickname'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" value="<?php echo $_POST['email'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>
        <input type="submit" value="Register" class="btn btn-primary btn-lg">
    </form>

</div>

<?php include __DIR__ . '/../footer.php'; ?>
