Ext.define('Webit.util.Serializer',{
	statics: {
		idSerializer: function(key) {
			key = key || 'id';
			return function(v, record) {
				var serialize = function(val) {
					if(Ext.isPrimitive(val)) {
						if(Ext.isEmpty(v)) {
							return null;
						}
						
						var obj = {};
						obj[key] = v;
						
						return obj;
					}
					
					if(val instanceof Ext.data.Model) {
						var obj = {};
						obj[key] = val.get(key);
						
						return obj;
					}
					
					if(Ext.isObject(val) && Ext.isDefined(val[key])) {
						var obj = {};
						obj[key] = val[key];
						
						return obj;
					}
					
					return null;
				}

				if(v instanceof Ext.data.Store) {
					var r = [];
					v.each(function(e) {
						r.push(serialize(e));
					});

					return r;
				}
				
				if(Ext.isArray(v)) {
					Ext.each(v,function(e) {
						r.push(serialize(e));						
					});
					
					return r;
				}
				
				return serialize(v);
			}
		},
		modelSerializer: function(deep) {
			deep = deep || false;
			return function(v, rec) {
				var serialize = function(r) {
					var d = {};
					r.fields.each(function(f) {
						if(f.serialize) {
							d[f.name] = f.serialize(r.get(f.name),r);
						} else {
							d[f.name] = r.get(f.name);
						}
					});
					
					return d;
				};
				
				if(v instanceof Ext.data.Store) {
					var values = [];
					v.each(function(r) {
						values.push(serialize(r));
					});
					
					return values;
				}
				
				if(v instanceof Ext.data.Model) {
					return serialize(v);
				}
				
				return v;
			}
		},
		dateSerializer: function(format) {
			var format = format || 'c';
			return function(v, r) {
				if(v) {
					return Ext.util.Format.date(v,format);
				}
				
				return v;
			}
		},
		storeItemDeserializer: function(stores, id, array) {
			id = id || 'id';
			array = Ext.isDefined(array) ? true: false;
			
			return function(v, rec) {
				v = Ext.isArray(v) == false && Ext.isEmpty(v) == false && array ? [v] : v;
				
				if(v instanceof Ext.data.Model) {
					return v;
				}
				stores = Ext.isArray(stores) ? stores : [stores];

				var getItem = function(key) {
					var found = null;
					Ext.each(stores,function(storeId) {
						var s = Ext.getStore(storeId);
						var k = parseInt(key);
						
						if(s) {
							found = s.getById(k);
							if(found) {
								return false;
							}
						}
					});
					
					return found;
				};
				
				// FIXME: we belive the first store is correct
				var getItemByIndex = function(key) {
					var found = null;
					Ext.each(stores,function(storeId) {
						var s = Ext.getStore(storeId);						
						if(s) {
							found = s.getAt(key);
							if(found) {
								return false;
							}
						}
					});
					
					return found;
				}
				
				var val = null;
				if(Ext.isArray(v)) {
					if(rec.get(this.name) instanceof Ext.data.Store == false) {
						if(Ext.isDefined(this.model) == false) {
							var cls = Ext.getClassName(rec);
							Ext.Error.raise(Ext.String.format('Missing property "model" of field "{0}" in "{1}"',this.name, cls));
						}
						val = Ext.create('Ext.data.Store',{
							model: this.model
						});
					} else {
						val = rec.get(this.name);
						val.removeAll(true);
					}
					
					Ext.each(v,function(idVal, i) {
						if(Ext.isBoolean(idVal)) {
							if(idVal == true) {
								var f = getItemByIndex(i);
								idVal = f ? f.get('id') : null;
							} else {
								return true;
							}
						}
						
						if(Ext.isObject(idVal)) {
							idVal = idVal[id];
						}
						var r = getItem(idVal);
						if(r) {
							val.add(r);
						}
					});
					
					return val;
				} else {
					if(Ext.isObject(v)) {
						v = v[id];
					}

					val = getItem(v);
				}
				
				return val;
			}
		},
		createItemDeserializer: function(array) {
			array = Ext.isDefined(array) ? array : false;
			return function(v, rec) {
				var model = this.model;
				if(v instanceof Ext.data.Model || v instanceof Ext.data.Store) {
					return v;
				}
				
				v = Ext.isArray(v) == false && Ext.isEmpty(v) == false && array ? [v] : v;
				if(Ext.isDefined(model) == false) {
					var cls = Ext.getClassName(rec);
					Ext.Error.raise(Ext.String.format('Missing property "model" of field "{0}" in "{1}"',this.name, cls));
					return v;
				}
				
				if(Ext.isArray(v)) {
					var s = Ext.create('Ext.data.Store',{
						model: model
					});
					Ext.each(v, function(vv) {
						if(Ext.isObject(vv)) {
							s.add(vv);	
						}
					});
					
					return s;
				}
				
				if(Ext.isObject(v)) {
					return Ext.create(model,v);
				}
				
				return v;
			}
		}
	}
});
