<?php $pager->setSurroundCount(2); ?>

<ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getPrevious(); ?>">&lt;</a>
        </li>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
        <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
            <a class="page-link" href="<?= $link['uri']; ?>">
                <?= $link['title']; ?>
            </a>
        </li>
    <?php endforeach; ?>

    <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getNext(); ?>">&gt;</a>
        </li>
    <?php endif; ?>
</ul>
