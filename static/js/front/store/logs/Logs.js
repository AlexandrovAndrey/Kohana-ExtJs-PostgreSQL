Ext.define('MyApp.store.logs.Logs', {
	extend : 'Ext.data.Store',
    model: 'MyApp.model.logs.Logs',
    autoSync: true,
	proxy: {
         type: 'ajax',
         url: 'main/getLogs',
         reader: {
             type: 'json',
             rootProperty: 'data'
         }
     },
    autoLoad: true,
    remoteFilter:true,
	remoteSort:true
 });