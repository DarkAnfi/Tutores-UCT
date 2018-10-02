function Login (c) {
	var self = new Page(c,"login");

	self.init = function () {
		self.controller.app.getPage("login", self.setPage);
	}

	self.update = function () {
		self.controller.app.getSession(self.setSession);
		self.event.onUpdate();
	}

	self.setPage = function (name, data) {
		self.content.html(data);
		self.event.onReady();
	}

	self.setSession = function (data) {
		$("#user-name").text(data.user);
		window.location.href = "#home";
	}

	self.onUpdate = function () {}

	self.onReady = function () {
		self.content.find("#login-form").on("submit",self.onSubmit);
		self.content.find("#login-user").on("change",self.onChange);
	}

	self.onShow = function () {}

	self.onSubmit = function (event) {
		event.preventDefault();
		var user = self.content.find("#login-user");
		var pass = self.content.find("#login-pass");
		var user_info = self.content.find("#login-user-info");
		var pass_info = self.content.find("#login-pass-info");
		if (user.val() != "") {
			if (pass.val() != "") {
				self.controller.app.login(user.val(),pass.val(),self.onLogin,self.onError);
				user_info.text("");
				user.parent().parent().removeClass("has-error");
				pass_info.text("");
				pass.parent().parent().removeClass("has-error");
			} else {
				pass.parent().parent().addClass("has-error");
				pass_info.text("No se ha ingresado Contraseña");
				pass.focus();
			}
		} else {
			user.focus();
			user.parent().parent().addClass("has-error");
			user_info.text("No se ha ingresado Usuario");
		}
	}

	self.onChange = function (event) {
		var tar = $(event.target);
		if (tar.val() == "") {
			tar.focus();
			tar.parent().parent().addClass("has-error");
			if (tar.attr("id") == "login-user") {
				tar.parent().find("#login-user-info").text("No se ha ingresado Usuario");
			}
			else if (tar.attr("id") == "login-pass") {
				tar.parent().find("#login-pass-info").text("No se ha ingresado Contraseña");
			}
		} else {
			tar.parent().parent().removeClass("has-error");
			tar.parent().find("p").text("");
		}
	}

	self.onLogin = function (data) {
		self.content.find("#login-user").val("");
		self.content.find("#login-pass").val("");
		$("#logout").css("display","block");
		window.location.href = "#home";
	}

	self.onError = function (data) {
		self.content.find("#login-pass").focus().parent().parent().addClass("has-error");
		self.content.find("#login-pass-info").text("Contraseña Incorrecta");
	}

	self.init();
	return self;
}

