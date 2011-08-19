<html>
    <head>
        <title><?= $page_title ?></title>
        <base href="<?= $this->config->item('base_url') ?>" />
        <script type="text/javascript" src="assets/js/swfobject.js"></script>

    </head>
    <body>
        
        <h1><?= $page_title ?></h1>
        <script type="text/javascript">
            swfobject.embedSWF(
              "assets/swf/open-flash-chart.swf", "test_chart",
              "<?= $chart_width ?>", "<?= $chart_height ?>",
              "9.0.0", "expressInstall.swf",
              {"data-file":"<?= urlencode($data_url) ?>"}
            );
        </script>

        <div id="test_chart"></div>

        <div id="links">
            <?php foreach($links as $title => $url): ?>
				<a href="<?=$url?>"><?=$title?></a>&nbsp;
			<?php endforeach; ?>
        </div>
		
        <h1>JSON</h1>
        <iframe src ="<?= $data_url?>" width="80%" height="200">
            <p>No iframes for your browser</p>
        </iframe>

        <div id="info">
            More info &amp; examples: <a href="http://teethgrinder.co.uk/open-flash-chart-2">Open Flash Chart 2 Home</a>
        </div>

    </body>
</html>
