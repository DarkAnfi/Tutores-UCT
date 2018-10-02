function App () {
	var self = this;

	self.post = function (type,tag,dict,callback,error) {
		dict.type = type;
		$.post("./php/app.php",dict,function (data,status) {
			if (status == "success") {
				data = JSON.parse(data);
				if (data.type == tag) {
					callback(data.value);
				} else if (data.type == "error") {
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
		self.post("session_get","user",{}, function (data) {
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
		if (user != undefined, pass != undefined) {
			self.post("login","user",{"user":user,"pass":pass}, function (data) {
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
		self.post("logout","success",{}, function (data) {
			if (callback != undefined) {
				callback(data);
			}
		}, function (data) {
			if (error != undefined) {
				error(data);
			}
		});
	}

	return self;
}

