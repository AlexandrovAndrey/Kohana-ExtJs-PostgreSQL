Ext.define('MyApp.view.logs.LogsGrid', {
    extend : 'Ext.grid.Panel',
    title: 'Логи',    
    iconCls: 'x-fa fa-users',
    columns: [{
        text: 'IP',
        dataIndex: 'ip',
        sortable: false,
        flex: 1
    }, {
        text: 'Браузер',
        dataIndex: 'browser',
        flex: 1
    }, {
        text: 'OC',
        dataIndex: 'os',
        flex: 1
    }, {
        text: 'URL, с которого зашёл первый раз',
        dataIndex: 'url_from',
        sortable: false,
        flex: 1
    }, {
        text: 'URL, на который зашел последний раз',
        dataIndex: 'url_to',
        sortable: false,
        flex: 1
    }],
    initComponent : function(){
        this.store = this.buildStore();
        this.callParent();        
    },
    buildStore: function(){
        var store = Ext.getStore('storeLogsId');
        if (store) {
            store.destroy();         
        }; 

        return Ext.create('MyApp.store.logs.Logs', {storeId: 'storeLogsId', pageSize: 100});
    },
    tbar: [
        Ext.create('Ext.form.Panel', {    
            id: 'logsFormFilterId',
            bodyStyle : 'background:none',
            border: false,
            items: [{
                xtype: 'textfield',
                fieldLabel: 'IP',
                labelWidth: '10px',
                name: 'ip'
            }]
        }
    ),{
        text:'Найти',
        handler: function () {
            var form = Ext.ComponentQuery.query('#logsFormFilterId')[0];
            var fields = form.getForm().getFields().items;
            var filters = []; 
            Ext.each(fields, function(field){
                filters.push(
                    new Ext.util.Filter({              
                        "property": field.getName(),
                        "value": field.getValue() 
                    })
                );
            });            

            Ext.getStore('storeLogsId').addFilter(filters);
        }            
    },{
        text:'Очистить',
        handler: function () {
            var form = Ext.ComponentQuery.query('#logsFormFilterId')[0];
            var fields = form.getForm().getFields().items;
            Ext.each(fields, function(field){
                field.reset();
            });
            Ext.getStore('storeLogsId').clearFilter();
        }            
    },{
        text:'Заполнить из файлов',
        handler: function () {
            var request = Ext.Ajax.request({
                url: 'main/saveLogs',
                method: 'GET',          
                success: function(response){
                    var store = Ext.getStore('storeLogsId');
                    store.reload();
                }
            })
        }            
    }]
})