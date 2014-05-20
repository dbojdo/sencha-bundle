Ext.define('Webit.Security',{
	singleton: true,
	mixins: {
        observable: 'Ext.util.Observable'
    },
	requires: [
		'Webit.security.Controller',
		'Webit.security.AccessControlable',
		'Webit.security.User',
		'Webit.security.UserRoleMixin'
	],
	user: null,
	getUser: function() {
		return this.user;
	},
	createContext: function(model, data) {
		Webit.Security.user = Ext.create(model, data); 
	}
});
