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
		self.event.onUpdate();
	}

	self.errorSession = function (data) {
		console.log(data);
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

