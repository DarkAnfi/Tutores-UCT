function Main () {
	var self = this;
	self.document = $(document);

	self.user = {};
	self.course_id = 0;

	self.init = function () {
		self.page = $("main");
	}

	self.dates = {
		"MONDAY":"LUNES",
		"TUESDAY":"MARTES",
		"WEDNESDAY":"MIÉRCOLES",
		"THURSDAY":"JUEVES",
		"FRIDAY":"VIERNES",
		"SATURDAY":"SÁBADO",
		"SUNDAY":"DOMINGO"
	};

	String.prototype.capitalize = function() {
	    return this.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { return a.toUpperCase(); });
	}

	self.validate = function (n,k) {
		var l = n.toString().length;
		var s = 0;
		for (var i = 0; i < l; i++) {
			s += ((n % Math.pow(10,i+1))-(n % Math.pow(10,i))) / Math.pow(10,i) * ((i % 6) + 2)
		}
		s = 11 - (s % 11)
		if (s == 11) { s = '0'; }
		else if (s == 10) { s = 'k'; }
		else { s = s.toString(); }
		return (k==s)
	}

	self.createAlert = function (element, status, content) {
		element.html($(document.createElement("div"))
			.addClass("alert")
			.addClass("alert-dismissible")
			.addClass("alert-"+status)
			.append($(document.createElement("button"))
				.addClass("close")
				.attr("type","button")
				.attr("data-dismiss","alert")
				.html("&times;")
			)
			.append(content)
		);
	}

	self.closeAlert = function (element) {
		element.find(".close").alert("close");
	}

	self.view = function (url) {
		app.get(url, function (data) {
			self.page.html(data);
		});
		$("#myNavbar").collapse("hide");
	}

	self.activate = function () {
		$(".private").css("display","block");
	}

	self.disable = function () {
		$(".private").css("display","none");	
	}

	self.service = function (name, image, url) {
		return ($(document.createElement("div"))
			.attr("class","col-lg-2 col-md-3 col-sm-4 col-xs-6")
			.html($(document.createElement("div"))
				.attr("class","thumbnail")
				.append($(document.createElement("img"))
					.attr("src",image)
					.attr("alt",name)
					.css("border-radius","100%")
				)
				.append($(document.createElement("div"))
					.attr("class","caption")
					.css("text-align","center")
					.html($(document.createElement("h4"))
						.text(name)
					)
				)
				.on("click",
					function (event) {
						event.preventDefault();
						main.view(url);
					}
				)
			)
		);
	}

	self.course = function (id, code, name) {
		return ($(document.createElement("div"))
			.attr("class","btn-group btn-group-justified")
			.css("margin-bottom","10px")
			.append($(document.createElement("a"))
				.attr("class","btn btn-primary")
				.css("width","100px")
				.text(code)
			)
			.append($(document.createElement("a"))
				.attr("class","btn btn-default")
				.css("width","calc(100% - 100px)")
				.text(name)
			)
			.on("click",
				function (event) {
					event.preventDefault();
					main.course_id = id;
					main.view("./data/attendance.html");
				}
			)
		);
	}

	self.document.ready(self.init);
	return self;
}

main = new Main();
