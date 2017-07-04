Ext.define('MyApp.view.Viewport',{
	extend : 'Ext.container.Viewport',
	requires: ['MyApp.view.logs.LogsGrid'],
	xtype: 'main_view',	
	layout: 'fit',
	autoScroll: true,
	items:[{
		xtype : 'container',
		layout : {
			type : "vbox",
			align : "stretch" 
		},			
		autoScroll: true,
		items: [
			Ext.create('MyApp.view.logs.LogsGrid')
		]			
	}]	
})			