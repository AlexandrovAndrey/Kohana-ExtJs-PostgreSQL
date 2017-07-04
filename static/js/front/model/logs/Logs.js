Ext.define('MyApp.model.logs.Logs', {
	extend:'Ext.data.Model',
	fields:[
		{name: 'id', type: 'int'},
		{name: 'ip', type: 'string'},
		{name: 'os', type: 'string'},
		{name: 'browser', type: 'string'},
		{name: 'ip', type: 'string'},
		{name: 'url_from', type: 'string'},
		{name: 'url_to', type: 'string'}
	],
	idProperty: 'id'
});