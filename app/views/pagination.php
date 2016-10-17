<?php if ($paginator->getLastPage() > 0): ?>

    <div class="pagination">
        <?php

        /* How many pages need to be shown before and after the current page */
        $showBeforeAndAfter = 3;

        /* Current Page */
        $currentPage = $paginator->getCurrentPage();
        $lastPage = $paginator->getLastPage();

        /* Check if the pages before and after the current really exist */
        $start = $currentPage - $showBeforeAndAfter;

        /*
            Check if first page in pagination goes below 1, and substract that from
            $showBeforeAndAfter var so the pagination won't start with page 0 or below
        */

        if ($start < 1) {
            $diff = $start - 1;
            $start = $currentPage - ($showBeforeAndAfter + $diff);
        }

        $end = $currentPage + $showBeforeAndAfter;

        if ($end > $lastPage) {
            $diff = $end - $lastPage;
            $end = $end - $diff;
        }

        echo "<a href='{$paginator->getUrl(1)}' class='page'>First</a>";

        for ($page = $start; $page <= $end; ++$page) {
            $class = $page == $currentPage ? ' active' : '';
            echo "<a href='{$paginator->getUrl($page)}' class='page{$class}'>{$page}</a>";
        }

        echo "<a href='{$paginator->getUrl($paginator->getLastPage())}' class='page'>Last</a>";

        /*echo $presenter->getPrevious();
        echo $presenter->getPageRange($start, $end);
        echo $presenter->getNext();*/

        ?>
    </div>
<?php endif; ?>