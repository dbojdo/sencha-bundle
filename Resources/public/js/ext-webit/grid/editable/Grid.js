Ext.define('Webit.grid.editable.Grid',{
	extend: 'Ext.grid.Panel',
	alias: 'widget.webit_grid_editable_grid',
	requires: [
	    'Webit.grid.editable.ButtonDelete'
	],
	/**
	 * 
	 * @type String
	 * window or row
	 */
	editmode: 'window',
	editWindowConfig: null,
	newWindowConfig: null,
	rowEditing: {
  	clicksToMoveEditor: 2,
  	pluginId: 'rowEditing',
  	errorSummary: false,
  	autoCancel: true,
  	saveBtnText: 'Zapisz',
  	cancelBtnText: 'Anuluj'
	},
	buttonsVisibility: {
	},
	dockedItems: [{
		xtype: 'toolbar',
		dock: 'right',
		itemId: 'edit',
		items: [{
			iconCls: 'fam-silk-add',
			itemId: 'add',
			tooltip: 'Dodaj'
		},{
			iconCls: 'fam-silk-pencil',
			itemId: 'edit',
			tooltip: 'Edytuj',
			disabled: true
		},{
			xtype: 'webit_grid_editable_buttondelete',
			disabled: true
		}]
	}],
	getModelDefaults: function() {
		return {};
	},
	getEditWindowConfig: function() {
		return this.editWindowConfig;
	},
	getNewWindowConfig: function() {
		if(this.newWindowConfig) {
			return this.newWindowConfig;
		}
		
		return this.getEditWindowConfig();
	},
	initComponent: function() {
		this.addEvents('recordSave','recordDelete');

		var plugins = [];
		if(this.editmode == 'row') {
			var rowEditing = Ext.create('Ext.grid.plugin.RowEditing', this.rowEditing);
			plugins.push(rowEditing);
		}
		Ext.apply(this,{
			plugins: plugins
		});
		
		this.callParent();
		
		for(key in this.buttonsVisibility) {
			this.down('toolbar button[itemId="'+key+'"]').setVisible(this.buttonsVisibility[key]);
		}
	}
});