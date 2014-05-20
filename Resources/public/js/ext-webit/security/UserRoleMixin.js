Ext.define('Webit.security.UserRoleMixin',{
	rolesProperty: 'roles',
	hasRole: function(role) {
		var roles = this.get(this.rolesProperty);
		if(Ext.isArray(roles)) {
			return Ext.Array.contains(roles,role);
		}
		
		return false;
	}
});
