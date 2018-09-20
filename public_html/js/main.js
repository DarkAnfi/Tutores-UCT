function Main () {
	var self = new Controller();
	self.main_page = "home";

	self.setPages = function () {
		self.components.home = new Home(self);
	}

	self.setEvents = function () {}

	self.document.ready(self.init);
	return self;
}

main = new Main();