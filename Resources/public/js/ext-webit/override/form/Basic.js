Ext.define('Webit.override.form.Basic', {
    override: 'Ext.form.Basic', 
    loadRecord: function(record) {
    	var values = {};
    	var findRealValue = function(fieldName) {
    		var value;
    		var arField = fieldName.split('.');
    		
    		var r = record;
    		Ext.each(arField, function(f) {
    			if(r instanceof Ext.data.Model) {
    				value = r.get(f);
    				if(value instanceof Ext.data.Store) {
    					arValue = [];
    					value.each(function(se) {
    						arValue.push(se);
    					});
    					value = arValue;
    				}
    				r = r.get(f);
    			} else {
    				value = r;
    				return false;
    			}
    		});
    		
    		return value;
    	};
    	this.getFields().each(function(field){
    		if(Ext.isEmpty(field.getName())) {
    			return true;
    		}
    		
    		if(Ext.isDefined(values[field.getName()]) == false) {
    			values[field.getName()] = findRealValue(field.getName());
    		}
    	});
			
		this._record = record;
    	return this.setValues(values);
    },
    /**
     * Persists the values in this form into the passed {@link Ext.data.Model} object in a beginEdit/endEdit block.
     * @param {Ext.data.Model} record The record to edit
     * @return {Ext.form.Basic} this
     */
    updateRecord: function(record) {
    	var form = this.owner;
        var values = this.getFieldValues(), name, obj = {};

        var findRecord = function(fieldName, r) {
        	var arName = fieldName.split('.');
        	var length = arName.length;
        	Ext.each(arName,function(f, i) {
        		if(i < length-1) {
        			r = r.get(f);
        		}
        	});
        	
        	return r;
        };
        var arEdited = [];
        for(var fieldName in values) {
        	var r = findRecord(fieldName, record);
        	if(Ext.Array.contains(arEdited,r) == false) {
        		arEdited.push(r);
        		r.beginEdit();
        	}
        	var arName = fieldName.split('.');
        	r.set(arName[arName.length - 1], values[fieldName]);
        }
        
        arEdited.reverse();
        Ext.each(arEdited, function(e){
        	e.endEdit();
        });
        
        return this;
    }
});
