<div id="statuses">
    <?php foreach ($statuses as $status): ?>
    <?php print $this->render('blog/status', array('status' => $status)); ?>
    <?php endforeach; ?>
</div>

