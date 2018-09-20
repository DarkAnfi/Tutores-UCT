function Home (c) {
	var self = new Page(c,"home");

	self.init = function () {
		self.controller.app.getPage("home", self.setPage);
	}

	self.update = function () {
		self.event.onUpdate();
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