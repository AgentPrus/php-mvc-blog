<?php include __DIR__ . '/../header.php'; ?>

<div class="container py-4">
    <h2 class="display-3 text-center mb-4">Registration</h2>
    <form action="">
        <div class="form-group">
            <label for="nickname">Nickname</label>
            <input type="text" class="form-control" id="nickname">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password">
        </div>
        <input type="submit" value="Register" class="btn btn-primary btn-lg">
    </form>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
