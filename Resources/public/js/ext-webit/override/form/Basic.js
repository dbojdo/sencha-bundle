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
		console.info(values);
        var findRecord = function(fieldName, r) {
        	var arName = fieldName.split('.');
        	var length = arName.length;
        	var found = r;
        	Ext.each(arName,function(f, i) {
        		if(i < length-1) {
        			found = r.get(f);
        			if(Ext.isEmpty(found)) {
        				found = false;
        				return false;
        				var cls = Ext.getClassName(r);
        				Ext.Error.raise(Ext.String.format('Can not find Ext.data.Model instance for field "{0}" in "{1}")',f,cls));
        			}
        		}
        	});
        	
        	return found;
        };
        var arEdited = [];
        for(var fieldName in values) {
        	var r = findRecord(fieldName, record);
        	if(r == false) {
        		continue;
        	}
        	if(Ext.Array.contains(arEdited,r) == false) {
        		if(r instanceof Ext.data.Model == false) {
        			var cls = Ext.getClassName(record);
        			Ext.Error.raise(Ext.String.format('Found value is not an Ext.data.Model (Property "{0}" of "{1}")',fieldName,cls));
        		}
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

