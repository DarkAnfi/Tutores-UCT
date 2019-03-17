function App () {
	var self = this;

	/* ----- Methods ----- */

	self.post = function (type,tag,dict,callback,error) {
		dict.type = type;
		$.post("./php/app.php",dict,function (data,status) {
			if (status == "success") {
				data = JSON.parse(data);
				if (data.type == tag) {
					callback(data.value);
				} else if (data.type == "Error") {
					error(data.value);
				} else {
					console.log(data);
				}
			} else {
				console.log({"type":status,"value":data});
			}
		});
	}

	self.get = function (url, callback) {
		$.get(url,{"_":$.now()},callback)
	}

	/* ----- Login ----- */

	self.session = function (callback, error) {
		self.post("session","Login",{}, function (data) {
			if (callback != undefined) {
				callback(data);
			}
		}, function (data) {
			if (error != undefined) {
				error(data);
			}
		});
	}

	self.login = function (e, p, callback, error) {
		if (e != undefined && p != undefined) {
			self.post("login","Login",{"email":e,"password":p}, function (data) {
				if (callback != undefined) {
					callback(data);
				}
			}, function (data) {
				if (error != undefined) {
					error(data);
				}
			});
		}
	}

	self.logout = function (callback, error) {
		self.post("logout","bool",{}, function (data) {
			if (callback != undefined) {
				callback(data);
			}
		}, function (data) {
			if (error != undefined) {
				error(data);
			}
		});
	}

	/* ----- Data -----*/

	self.data_select_by_id = function (i, callback, error) {
		self.post("data_select_by_id","Data",{"id":i}, function (data) {
			if (callback != undefined) {
				callback(i,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(i,data);
			}
		});
	}

	self.data_update = function (i, n, l, p, callback, error) {
		self.post("data_update","bool",{"id":i,"name":n,"lastname":l,"phone":p}, function (data) {
			if (callback != undefined) {
				callback(i,n,l,p,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(i,n,l,p,data);
			}
		});
	}

	/* ----- Service ----- */

	self.service_select_by_level_by_user = function(i, callback, error) {
		self.post("service_select_by_level_by_user","List(Service)",{"id":i}, function (data) {
			if (callback != undefined) {
				callback(i,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(i,data);
			}
		});
	}

	/* ----- Course ----- */

	self.course_select_by_tutor_by_user_type = function(i,t, callback, error) {
		self.post("course_select_by_tutor_by_user_type","List(Course)",{"id":i,"course_type":t}, function (data) {
			if (callback != undefined) {
				callback(i,t,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(i,t,data);
			}
		});
	}

	self.course_select_by_id = function (i, callback, error) {
		self.post("course_select_by_id","Course",{"id":i}, function (data) {
			if (callback != undefined) {
				callback(i,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(i,data);
			}
		});
	}

	return self;
}

app = new App();