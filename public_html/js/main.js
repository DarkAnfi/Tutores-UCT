function Main () {
	var self = new Controller();
	self.main_page = "home";
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

	self.setPages = function () {
		self.components.login = new Login(self);
		self.components.home  = new Home(self);
		self.components.servicio = new Servicio(self);
	}

	self.setEvents = function () {
		$("#logout").click(self.logout);
	}

	self.logout = function(event) {
		self.app.logout(self.onLogout,self.onLogoutException);
	}

	self.onLogout = function (data) {
		$("#logout").css("display","none");
		$("#user-name").text("");
	}

	self.onLogoutException = function (data) {
		$("#logout").css("display","none");
		$("#user-name").text("");
	}

	self.document.ready(self.init);
	return self;
}

main = new Main();

