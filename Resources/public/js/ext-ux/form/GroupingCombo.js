Ext.define('Ext.ux.form.GroupingCombo', {
    extend: 'Ext.form.field.ComboBox',
    alias: 'widget.groupingcombo',
    constructor: function (args) {
        var me = this,
            groupField = args.groupField || "group",
            groupDisplayField = args.groupDisplayField || groupField,
            displayField = args.displayField || "name";


        args.tpl = new Ext.XTemplate(
            '<tpl for=".">',
            '<tpl if="this.' + groupField + ' != values.' + groupField + '">',
            '<tpl exec="this.' + groupField + ' = values.' + groupField + '"></tpl>',
            '<div class="x-panel-header-default x-panel-header-text-container x-panel-header-text x-panel-header-text-default" title="{' + groupDisplayField + '}">{' + groupDisplayField + '}</div>',
            '</tpl>',
            '<div class="x-boundlist-item">{' + displayField + '}</div>',
            '</tpl>'
        );

        me.callParent(arguments);
    }
});