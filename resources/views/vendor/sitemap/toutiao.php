<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<urlset>
    <?php foreach ($items as $item) : ?>
        <url>
            <loc><?= $item['loc'] ?></loc>
            <?php
            
            if ($item['lastmod'] !== null) {
                echo "\t\t".'<lastmod>'.date('Y-m-d', strtotime($item['lastmod'])).'</lastmod>'."\n";
            }

            ?>
        </url>
    <?php endforeach; ?>
</urlset>

