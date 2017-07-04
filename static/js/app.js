Ext.application({
    name: 'test',	
	paths: {
        'Ext': 'static/js/ext-6.2.0',
        'MyApp': 'static/js/front/'
   	},
	requires: [
        'MyApp.view.Viewport',
	],
    launch: function() {
        Ext.create('MyApp.view.Viewport');
    }    
});