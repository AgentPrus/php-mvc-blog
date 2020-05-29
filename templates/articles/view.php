<?php include __DIR__ . '/../header.php'; ?>
<section id="main-content py-4">
    <div class="container">
        <h2 class="dispaly-3"><?=$article->getName() ?></h2>
        <blockquote class="blockquote">
            <p class="mb-0"><?=$article->getText() ?></p>
            <p class="blockquote-footer"><?=$article->getAuthor()->getNickName() ?></p>
        </blockquote>
    </div>
</section>

<?php include __DIR__ . '/../footer.php'; ?>
