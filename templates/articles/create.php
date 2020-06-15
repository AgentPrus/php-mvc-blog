<?php include __DIR__ . '/../header.php'; ?>
<div class="col">
    <div class="row">
        <div class="container py-4">
            <h1>Create a new article</h1>
            <?php if(!empty($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
            <?php endif ?>
            <form action="/articles/create" method="post">
                <div class="form-group">
                    <label for="name">Enter article name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= $_POST['name'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="text">Enter article text</label>
                    <textarea name="text" id="text" class="form-control" cols="30" rows="10">
                        <?= $_POST['text'] ?? '' ?>
                    </textarea>
                </div>
                <input type="submit" value="Create" class="btn btn-dark btn-block">
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
