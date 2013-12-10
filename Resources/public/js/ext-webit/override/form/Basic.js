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
    setValues: function(values, arrayField) {
        var me = this;

        function setVal(fieldId, val) {
            if (arrayField) {
                fieldId = arrayField + '.' + fieldId;
            }
            var field = me.findField(fieldId);
            if (field) {
                field.setValue(val);
                if (me.trackResetOnLoad) {
                    field.resetOriginalValue();
                }
            } else if(Ext.isObject(val)) {
                me.setValues(val, fieldId);
            }
        }

        if (Ext.isArray(values)) {
            // array of objects
            Ext.each(values, function(val) {
                setVal(val.id, val.value);
            });
        } else {
            // object hash
            Ext.iterate(values, setVal);
        }
        return this;
    },
    /**
     * Persists the values in this form into the passed {@link Ext.data.Model} object in a beginEdit/endEdit block.
     * @param {Ext.data.Model} record The record to edit
     * @return {Ext.form.Basic} this
     */
    updateRecord: function(record) {
    	var form = this.owner;
        var values = this.getFieldValues(), name, obj = {};

        function hasValues(prefix) {
        	var patt = new RegExp('^'+prefix.replace('.','\.')+'\.');
        	var found = 0;
        	for(var k in values) {
        		if(k.match(patt)) {
        			found = 1;
        			return true;
        		}
        	}
        	
        	return found > 0;
        }
        
        function populateObj(record, prefix) {
        	prefix = prefix || '';
        	
            var obj = {}, name;
			record.beginEdit();
            record.fields.each(function(field) {
            	var fieldName = field.name;
            	var valueName = (prefix ? (prefix +'.'+ fieldName) : fieldName);
                if (field.model) {
                	var fieldRecord = record.get(fieldName);
                	if(fieldRecord instanceof Ext.data.Model == false) {
                		var recordData = Ext.isObject(fieldRecord) ? fieldRecord : {};
                		fieldRecord = Ext.create(field.model,recordData);
                	}
                	
                	if(hasValues(valueName)) {
                		populateObj(fieldRecord, valueName);
                		record.set(fieldName,fieldRecord);
                	} else if(Ext.isDefined(values[valueName])) {
						// checkboxes FIX
                		if(Ext.isArray(values[valueName])) {
                			var res = [];
                			Ext.each(form.query('*[name="'+valueName+'"]'),function(cb) {
                				if(cb.getValue()) {
                					res.push(cb.inputValue);
                				}
                			});

                			record.set(fieldName,res);
                		} else {
                			record.set(fieldName, values[valueName]);
                		}
                	}
                } else if (Ext.isDefined(values[valueName])) {
                	record.set(fieldName, values[valueName]);
                }
            });
            
            record.endEdit();
        }
        obj = populateObj(record);
        
        return this;
    }
});

