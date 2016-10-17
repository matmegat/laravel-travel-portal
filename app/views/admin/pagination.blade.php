<div class="pagination-container">

    <?php
    $presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
    ?>

    <?php if ($paginator->getLastPage() > 0): ?>
    <ul class="pagination">
        <?php echo $presenter->render(); ?>
    </ul>
    <?php endif; ?>

</div>
