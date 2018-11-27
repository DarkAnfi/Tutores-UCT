function Servicio (c) {
	var self = new Page(c,"servicio");
	self.sessions = {};

	self.init = function () {
		self.controller.app.getPage("servicio", self.setPage);
	}

	self.update = function () {
		if (self.controller.args[0] != undefined) {
			self.controller.app.getSession(self.setSession,self.errorSession);
		} else {
			window.location.href = "#home";
		}
	}

	self.setSession = function (data) {
		$("#user-name").text("~"+data.user);
		$("#logout").css("display","block");
		self.controller.app.getTutoriaById(self.controller.args[0],self.setTutoriaById,self.errorTutoria);
	}

	self.errorTutoria = function (data) {
		console.log(data);
		window.location.href = "#home";
	}

	self.setTutoriaById = function (id, data) {
		self.servicio = data;
		self.content.find("#servicio").text(data.nombre.split("-")[1]);
		self.content.find("#id").text(data.servicio+" "+data.id);
		self.content.find("#horario").text((
			data.dia+" "+data.hora_inicio.substring(0,5)+" - "+data.hora_termino.substring(0,5)
		).capitalize());
		self.content.find("#tutor").text(data.tutor.name);
		self.content.find("#prof").text(data.profesional.name);
		self.controller.app.getSessionsById(self.controller.args[0],self.setSessionsById)
	}

	self.setSessionsById = function (id, data) {
		self.content.find("#sessions").html("")
		for (var i = 0; i < data.length; i++) {
			var fecha = new Date(data[i].fecha + " 12:00:00")
			var l = dateFormat(fecha,"l");
			var d = dateFormat(fecha,"d");
			var m = dateFormat(fecha,"m");
			var Y = dateFormat(fecha,"Y");
			self.sessions[data[i].fecha] = data[i].id;
			self.content.find("#sessions").append($(document.createElement("div"))
				.addClass("rect")
				.addClass("rect-default")
				.addClass("reg-button")
				.attr("data-toggle","modal")
				.attr("data-target","#reg-modal")
				.attr("data-id",data[i].id)
				.attr("data-fecha",data[i].fecha)
				.attr("data-contenidos",data[i].contenidos)
				.attr("data-observaciones",data[i].observaciones)
				.attr("data-lugar",data[i].lugar)
				.attr("data-tutoria",data[i].tutoria.id)
				.html($(document.createElement("div"))
					.addClass("rect-center")
					.addClass("rect-content-md")
					.html(self.controller.dates[l.toUpperCase()].capitalize()+" "+d+" del "+m+" del "+Y)
				)
				.click(function (event) {
					event.preventDefault();
					self.content.find("#reg-modal").find("#reg-modal-sesion").val($(event.currentTarget).attr("data-id"));
					self.content.find("#reg-modal").find("#reg-modal-id").val($(event.currentTarget).attr("data-tutoria"));
					self.content.find("#reg-modal").find("#reg-modal-fecha").val($(event.currentTarget).attr("data-fecha"));
					self.content.find("#reg-modal").find("#reg-modal-contenidos").val($(event.currentTarget).attr("data-contenidos"));
					self.content.find("#reg-modal").find("#reg-modal-observaciones").val($(event.currentTarget).attr("data-observaciones"));
					self.content.find("#reg-modal").find("#reg-modal-lugar").val($(event.currentTarget).attr("data-lugar"));
					self.controller.app.getAsistenciaBySesion($(event.currentTarget).attr("data-id"),self.setAsistenciaBySesion)
				})
			);
		};
		self.event.onUpdate();
	}

	self.setAsistenciaBySesion = function (id, data) {
		console.log(id,data)
		self.content.find("#reg-modal").find("tbody").html("");
		for (var i = 0; i < data.length; i++) {
			console.log(data[i]);
			self.content.find("#reg-modal").find("tbody").append($(document.createElement("tr"))
				.append($(document.createElement("td"))
					.attr("class","text-center")
					.append($(document.createElement("input"))
						.attr("type","checkbox")
					)
				)
				.append($(document.createElement("td"))
					.text(data[i].estudiante.rut+"-"+data[i].estudiante.dv)
				)
				.append($(document.createElement("td"))
					.text(data[i].estudiante.nombre.capitalize())
				)
			);
		}
	}

	self.addSessionById = function (event) {
		var a_day = dateFormat(new Date(self.content.find("#add-modal").find("#add-modal-fecha").val()+" 12:00:00"),"l").toUpperCase()
		var c_day = self.servicio.dia.toUpperCase();
		if (self.controller.dates[a_day] == c_day) {
			if (self.content.find("#add-modal").find("#add-modal-fecha").val() in self.sessions) {
				self.content.find("#add-modal").find("#add-modal-fecha").parent().parent().addClass("has-error");
				self.content.find("#add-modal").find("#add-modal-message").html($(document.createElement("div"))
					.addClass("alert")
					.addClass("alert-dismissible")
					.addClass("alert-danger")
					.append($(document.createElement("button"))
						.addClass("close")
						.attr("type","button")
						.attr("data-dismiss","alert")
						.html("&times;")
					)
					.append($(document.createElement("strong"))
						.text("Ups! ")
					)
					.append("La fecha ingresada ya se encuentra en la lista de servicios. Intente una fecha diferente.")
				);
			} else {
				self.controller.app.addSessionById(
					self.servicio.id,
					self.content.find("#add-modal").find("#add-modal-fecha").val(),
					function (id, date, data){
						self.controller.app.getSessionsById(self.servicio.id,self.setSessionsById)
						self.content.find("#add-modal").modal("hide");
						self.content.find("#add-modal").find("#add-modal-fecha").parent().parent().removeClass("has-error");
						self.content.find("#add-modal").find("#add-modal-message").find(".close").alert("close");
					}
				);
			}
		} else {
			self.content.find("#add-modal").find("#add-modal-fecha").parent().parent().addClass("has-error");
			self.content.find("#add-modal").find("#add-modal-message").html($(document.createElement("div"))
				.addClass("alert")
				.addClass("alert-dismissible")
				.addClass("alert-danger")
				.append($(document.createElement("button"))
					.addClass("close")
					.attr("type","button")
					.attr("data-dismiss","alert")
					.html("&times;")
				)
				.append($(document.createElement("strong"))
					.text("Ups! ")
				)
				.append("La fecha no coincide con el horario del servicio. Por favor ingrese la fecha correspondiente al servicio")
			);
		}
	}

	self.regSessionById = function (event) {}

	self.errorSession = function (data) {
		window.location.href = "#login";
	}

	self.setPage = function (name, data) {
		self.content.html(data);
		self.event.onReady();
	}

	self.onUpdate = function () {}

	self.onReady = function () {
		self.content.find("#add-modal")
			.find("#add-modal-submit")
			.click(self.addSessionById);
		self.content.find("#add-modal").find("#add-modal-fecha").val(dateFormat(new Date, "Y-m-d"));
		self.content.find("#reg-modal")
			.find("#reg-modal-submit")
			.click(self.regSessionById);
	}

	self.onShow = function () {}

	self.init();
	return self;
}