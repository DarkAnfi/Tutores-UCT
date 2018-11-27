function Home (c) {
	var self = new Page(c,"home");

	self.init = function () {
		self.controller.app.getPage("home", self.setPage);
	}

	self.update = function () {
		self.controller.app.getSession(self.setSession,self.errorSession);
	}

	self.setSession = function (data) {
		$("#user-name").text("~"+data.user);
		$("#logout").css("display","block");
		self.content.find("#nombre").text(data.name);
		self.controller.app.getTutoria(self.setTutoria,console.log);
	}

	self.onRectClick = function(event) {
		window.location.href = "#servicio."+$(event.target).parent().find(".pent").text();
	}

	self.putService = function (title,list) {
		self.content.find("#servicios").append($(document.createElement("h3"))
			.text(title)
		);
		for (var i = 0; i < list.length; i++) {
			var item = list[i];
			if (item.cerrado) {
				item.state = "danger";
			} else if (item.dia.toUpperCase() == self.controller.dates[dateFormat(new Date, "l").toUpperCase()]) {
				item.state = "primary";
			} else {
				item.state = "default";
			}
			self.content.find("#servicios").append($(document.createElement("div"))
				.attr("class","rect rect-info")
				.append($(document.createElement("div"))
					.attr("class","pent pent-md pent-"+item.state)
					.text(item.id)
				).append($(document.createElement("div"))
					.attr("class","rect-content rect-content-md")
					.text(item.nombre.split("-")[1])
				).click(self.onRectClick)
			);
		}
	}

	self.setTutoria = function (data) {
		var tutorias = [];
		var talleres = [];
		var otros    = [];
		for (var i = 0; i < data.length; i++) {
			servicio = data[i];
			if (servicio.servicio == "TUTORÍA") {
				tutorias.push(servicio);
			} else if (servicio.servicio == "TALLER") {
				talleres.push(servicio);
			} else {
				otros.push(servicio);
			}
		}
		self.content.find("#servicios").html("");
		if (tutorias.length) {
			self.putService("Tus tutorias",tutorias);
		} if (talleres.length) {
			self.putService("Tus talleres",talleres);
		} if (otros.length) {
			self.putService("Otros servicios",otros);
		}
		self.event.onUpdate();
	}

	self.errorSession = function (data) {
		window.location.href = "#login";
	}

	self.setPage = function (name, data) {
		self.content.html(data);
		self.event.onReady();
	}

	self.onUpdate = function () {}

	self.onReady = function () {}

	self.onShow = function () {}

	self.init();
	return self;
}

