<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<urlset>
    <?php foreach ($items as $item) : ?>
        <url>
            <loc><?= $item['loc'] ?></loc>
            <data>
                <display>
                    <pc_url_pattern><?= $item['priority'] ?></pc_url_pattern>
                    <pc_sample><?= $item['lastmod'] ?></pc_sample>
                    <version><?= $item['freq'] ?></version>
                </display>
            </data>
        </url>
    <?php endforeach; ?>
</urlset>

