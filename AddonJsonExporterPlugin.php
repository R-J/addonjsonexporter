<?php

class AddonJsonExporterPlugin extends Gdn_Plugin {
    public function settingsController_addonjsonexporter_create($sender) {
        $sender->permission('Garden.Settings.Manage');

        $sender->setHighlightRoute('dashboard/settings/plugins');
        $sender->setData('Title', t('addon.json Exporter'));

        $availablePlugins = Gdn::pluginManager()->availablePlugins();
        ksort($availablePlugins);

        $plugins = [];

        foreach ($availablePlugins as $pluginKey => $plugin) {
            foreach($plugin as $key => $value) {
                $newKey = strtolower(substr($key, 0, 1)).substr($key, 1);
                $availablePlugins[$pluginKey][$newKey] = $value;
                unset($availablePlugins[$pluginKey][$key]);
            }
            // $plugins[] = json_encode($availablePlugins[$pluginKey], JSON_PRETTY_PRINT);
            $plugins[] = $availablePlugins[$pluginKey];
        }

        $sender->setData([
            'Plugins' => $plugins,
            'Schema' => [
                'Plugin' => [
                    'Control' => 'DropDown',
                    'Items' => array_combine(
                        array_keys(array_keys($plugins)),
                        array_keys($availablePlugins)
                    ),
                    'LabelCode' => 'Available Plugins',
                    'Options' => ['IncludeNull' => true, 'onchange' => 'updateTextBox(this.value)']
                ],
                'addon.json' => [
                    'LabelCode' => 'Plugin Info',
                    'Control' => 'TextBox',
                    'Description' => 'Raw addon.json',
                    'Options' => ['Multiline' => true, 'rows' => 30]
                ]
            ]
        ]);

        $sender->render('settings', '', 'plugins/addonjsonexporter');
    }
}
