Ext.define('Ext.cmp.cmp_pm_bundzettel.models.Viewport', {
    extend: 'Ext.app.ViewModel',
    alias: 'viewmodel.cmp_pm_bundzettel',
    data:{
        currentWMState: 'unkown'
    },
    stores: {
        searchtree: {
            type: 'tree',
            proxy: {
                timeout: 600000,
                type: 'ajax',
                reader: 'json',
                url: './cmp_pm_bundzettel/tree'
            },
        
            timeout: 600000,
            // Preload child nodes before expand request
            lazyFill: false,

            listeners: {
                beforeload: 'onReloadTreeBeforeLoad'
            }
        }
    }
});