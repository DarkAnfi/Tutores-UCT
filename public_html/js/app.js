function App () {
	var self = this;

	self.post = function (type,tag,dict,callback,error) {
		dict.type = type;
		$.post("./php/app.php",dict,function (data,status) {
			if (status == "success") {
				data = JSON.parse(data);
				if (data.type == tag) {
					callback(data.value);
				} else if (data.type == "Error") {
					error(data.value);
					console.log(data.value)
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

	self.getPage = function (name, callback) {
		if (name != undefined) {
			self.get("./data/"+name+".html", function (data) {
				if (callback != undefined) {
					callback(name,data);
				}
			});
		}
	}

	self.getSession = function (callback, error) {
		self.post("session_get","User",{}, function (data) {
			if (callback != undefined) {
				callback(data);
			}
		}, function (data) {
			if (error != undefined) {
				error(data);
			}
		});
	}

	self.login = function (user, pass, callback, error) {
		if (user != undefined && pass != undefined) {
			self.post("login","User",{"user":user,"pass":pass}, function (data) {
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

	self.updateTutoria = function (callback, error) {
		self.post("tutoria_update","bool",{}, function (data) {
			if (callback != undefined) {
				callback(data);
			}
		}, function (data) {
			if (error != undefined) {
				error(data);
			}
		});
	}

	self.getTutoria = function (callback, error) {
		self.post("tutoria_read","List(Tutoria)",{}, function (data) {
			if (callback != undefined) {
				callback(data);
			}
		}, function (data) {
			if (error != undefined) {
				error(data);
			}
		});
	}

	self.getTutoriaById = function (id, callback, error) {
		if (id != undefined) {
			self.post("tutoria_read_id","Tutoria",{"id":id}, function (data) {
				if (callback != undefined) {
					callback(id, data);
				}
			}, function (data) {
				if (error != undefined) {
					error(data);
				}
			});
		}
	}

	self.getSessionsById = function (id, callback, error) {
		if (id != undefined) {
			self.post("sessions_read_id","List(Session)",{"id":id}, function (data) {
				if (callback != undefined) {
					callback(id, data);
				}
			}, function (data) {
				if (error != undefined) {
					error(data);
				}
			});
		}
	}

	self.getAsistenciaBySesion = function (id, callback, error) {
		if (id != undefined) {
			self.post("asistencia_read_sesion","List(Asistencia)",{"id":id}, function (data) {
				if (callback != undefined) {
					callback(id, data);
				}
			}, function (data) {
				if (error != undefined) {
					error(data)
				}
			});
		}
	}

	self.addSessionById = function (id, date, callback, error) {
		if (id != undefined && date != undefined) {
			self.post("session_add_id","bool",{"id":id,"date":date}, function (data) {
				if (callback != undefined) {
					callback(id, date, data);
				}
			}, function (data) {
				if (error != undefined) {
					error(data);
				}
			});
		}
	}

	self.updateSesion = function (i,l,c,e,o, callback, error) {
		if (i != undefined && l != undefined && c != undefined && e != undefined && o != undefined) {
			self.post("session_update","bool",{'id':i,'lugar':l,'contenidos':c,'estudiantes':e,'observaciones':o}, function (data) {
				if (callback != undefined) {
					callback(i,l,c,e,o,data);
				}
			}, function (data) {
				if (error != undefined) {
					error(data);
				}
			});
		}
	}

	return self;
}

