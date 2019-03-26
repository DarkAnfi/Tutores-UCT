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

	self.change_password = function (l,o,n,callback,error) {
		if (l != undefined && o != undefined && n != undefined) {
			self.post("change_password","bool",{"login":l,"old":o,"new":n}, function (data) {
				if (callback != undefined) {
					callback(l,o,n,data);
				}
			}, function (data) {
				if (error != undefined) {
					error(l,o,n,data);
				}
			});
		}
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

	/* ----- Session ----- */

	self.session_select_by_course = function (c, callback, error) {
		self.post("session_select_by_course","List(Session)",{"course":c}, function (data) {
			if (callback != undefined) {
				callback(c,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(c,data);
			}
		});
	}

	/* ----- Enrolled ----- */

	self.enrolled_select_by_course_session_active = function (c,s, callback, error) {
		self.post("enrolled_select_by_course_session_active","List(Enrolled)",{"course":c,"session":s}, function (data) {
			if (callback != undefined) {
				callback(c,s,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(c,s,data);
			}
		});
	}

	/* ----- Extra ----- */

	self.extra_select_by_course_session_active = function (c,s, callback, error) {
		self.post("extra_select_by_course_session_active","List(Extra)",{"course":c,"session":s}, function (data) {
			if (callback != undefined) {
				callback(c,s,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(c,s,data);
			}
		});
	}

	self.extra_remove_active_from_course = function (s,c, callback, error) {
		self.post("extra_remove_active_from_course","bool",{"student":s,"course":c}, function (data) {
			if (callback != undefined) {
				callback(s,c,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(s,c,data);
			}
		});
	}

	/* ----- Attendance ----- */

	self.attendance_select_by_session = function (s, callback, error) {
		self.post("attendance_select_by_session","List(Attendance)",{"session":s}, function (data) {
			if (callback != undefined) {
				callback(s,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(s,data);
			}
		});
	}

	self.attendance_insert_list = function (l,s, callback, error) {
		self.post("attendance_insert_list","bool",{"list":l,"session":s}, function (data) {
			if (callback != undefined) {
				callback(l,s,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(l,s,data);
			}
		});
	}

	/* ----- Student ----- */

	self.student_select_by_rut = function (r, callback, error) {
		self.post("student_select_by_rut","Student",{"rut":r}, function (data) {
			if (callback != undefined) {
				callback(r,data);
			}
		}, function (data) {
			if (error != undefined) {
				error(r,data);
			}
		});
	}

	return self;
}

app = new App();