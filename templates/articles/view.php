<?php include __DIR__ . '/../header.php'; ?>
<section id="main-content py-4">
    <div class="container">
        <h2 class="dispaly-3"><?=$article->getName() ?></h2>
        <p class="lead"><?=$article->getText() ?></p>
    </div>
</section>

<?php include __DIR__ . '/../footer.php'; ?>
