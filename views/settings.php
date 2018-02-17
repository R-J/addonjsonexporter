<?php defined('APPLICATION') or die;

echo helpAsset(
    sprintf(
        t('About %s'),
        'addon.json Exporter'
    ),
    t('Shows you the currently used meta information for a plugin in a format you can directly use for the addon.json file')
);
?>

<?= heading('addon.json Exporter') ?>
<section>
    <?= $this->Form->open(), $this->Form->errors() ?>
    <?= $this->Form->simple($this->data('Schema')) ?>
    <?= $this->Form->close() ?>
</section>

<script>
    var plugins = new Array();
    <?php foreach ($this->data('Plugins') as $key => $info): ?>
    plugins[<?= $key ?>] = <?= json_encode($info, JSON_PRETTY_PRINT) ?>;
    <?php endforeach ?>

    var textbox = document.getElementById('Form_addon-dot-json');

    document.getElementById('Form_Plugin').addEventListener('change', function(){
        textbox.value = JSON.stringify(plugins[this.value], null, 4);
    });
</script>
