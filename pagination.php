<nav class="pagination">
    <ul>
        <?php
            if(array_key_exists(($pageNum - 1), $pages))
            {
                $prevPage = $pageNum - 1;
                echo "
                    <li id='prePage' class='pageItem'>
                        <a class='pageLink' href='?page={$prevPage}' tabindex='-1'>Previous</a>
                    </li>
                ";
            }
        ?>

        <?php
            if(array_key_exists(($pageNum + 1), $pages))
            {
                $nextPage = $pageNum + 1;
                echo "
                    <li id='nextPage' class='pageItem'>
                        <a class='pageLink' href='?page={$nextPage}'>Next</a>
                    </li>
                ";
            }
        ?>
    </ul>
</nav>