function Controller () {
	var self = this;
	self.document = $(document);
	self.components = {};
	self.main_page = "";

	self.app = new App();

	self.init = function () {
		self.__setPages__();
		self.__setEvents__();
	}

	self.setPages = function () {}
	self.__setPages__ = function () {
		self.setPages();
	}

	self.setEvents = function () {}
	self.__setEvents__ = function () {
		window.onhashchange = self.onhashchange;
		window.onhashchange();
		self.setEvents();
	}

	self.onhashchange = function () {
		self.args = window.location.href.split("#")[1]
		if (self.args != undefined && self.args != "") {
			self.args = self.args.split(".");
			self.page = self.args.splice(0, 1)[0];
			if (self.components[self.page] != undefined) 
				self.components[self.page].show();
			else window.location.href = "#"+self.main_page;
		}
		else window.location.href = "#"+self.main_page;
	}

	return self;
}