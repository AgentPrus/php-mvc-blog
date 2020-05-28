<?php include __DIR__ . '/../header.php'; ?>

    <!-- Main Content -->
    <section id="content" class="py-4">
        <div class="container">
            <div class="row">
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <a href="articles/<?= $article['id'] ?>"
                                       class="text-dark"><?= $article['name'] ?></a>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="lead"><?= $article['text'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php include __DIR__ . '/../footer.php'; ?>