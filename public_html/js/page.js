function Page (c, name) {
	var self = this;
	self.name = name
	self.controller = c;
	self.content = $("#"+self.name+"-container");
	self.waiting = {};
	self.ready = false;
	self.updated = false;
	self.event = {};

	// Load Control
	self.onReady = function () {}
	self.event.onReady = function () {
		self.ready = true
		if (self.waiting.update != undefined) {
			self.waiting.update();
			self.waiting.update = undefined;
		}
		self.onReady();
	}

	// Update Control
	self.update = function () {}
	self.__update__ = function () {
		if (self.ready )
			self.update();
		else if (self.waiting.update == undefined)
			self.waiting.update = self.__update__;
	}

	self.onUpdate = function () {}
	self.event.onUpdate = function () {
		self.updated = true;
		if (self.waiting.show != undefined) {
			self.waiting.show();
			self.waiting.show = undefined;
		}
		self.onUpdate();
	}

	// Show Control
	self.onShow = function () {}
	self.show = function () {
		if (self.updated) {
			for (var c in self.controller.components) {
				self.controller.components[c].content.css("display","none");
				self.controller.components[c].updated = false;
			}
			self.content.css("display","block");
			self.onShow();
		}
		else {
			if (self.waiting.show == undefined) {
				self.waiting.show = self.show;
			}
			self.__update__();
		}
	}

	return self;
}

