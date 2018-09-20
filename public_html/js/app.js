function App () {
	var self = this;

	self.post = function (type,tag,dict,callback) {
		dict.type = type;
		$.post("./php/app.php",dict,function (data,status) {
			if (status == "success") {
				data = JSON.parse(data);
				if (data.type == tag) {
					callback(data);
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
					callback(name,data)
				}
			});
		}
	}

	self.postExample = function (args, callback) {
		if (name != undefined && comment != undefined) {
			self.post("example","success",{}, function (data) {
				if (callback != undefined) {
					callback(args,data)
				}
			});
		}
	}

	return self;
}