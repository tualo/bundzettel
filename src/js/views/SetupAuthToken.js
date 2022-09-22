Ext.define('Ext.cmp.cmp_pm_bundzettel.views.SetupAuthToken', {
  statics: {
    showInProfileScreen: true,
    profileScreenTitle: 'SV Produktion App-Setup'
  },
	extend: 'Ext.panel.Panel',
  alias: 'widget.cmp_pm_bundzettel_setupauthtoken',
  listeners: {
    boxReady: function(me){
      Tualo.Ajax.request({
        showWait: true,
        url: './cmp_pm_bundzettel/authtoken',
        scope: this,
        json: function(o){
          this.getComponent('qrp').getComponent('qr').setValue(JSON.stringify({
            url:  window.location.protocol+'//'+ window.location.hostname+''+window.location.pathname,
            token: o.token
          },null,0));

        }
      })
    }
  },
  layout: {
    type: 'vbox',
    pack: 'start',
    align: 'stretch'
  },
  items:[
    {
      xtype: 'label',
      html: 'Scannen Sie diesen Code mit der App'
    },
    {
      xtype: 'panel',
      itemId: 'qrp',
      layout: {
          type: 'hbox',
          pack: 'start',
          align: 'stretch'
      },
      items:[
        {
          itemId: 'qr',
          bodyPadding: '5px',
          xtype: 'tualoqrcode',
          width: 200,
          value: ''
        },
        {

          xtype: 'panel',
          html: ''
        }
      ]

    }
  ]
})
