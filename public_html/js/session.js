app.session(
	function (data) {
		main.user = data;
		main.view("./data/home.html");
		main.activate();
		app.data_select_by_id(main.user.id,
			function (id,data) {
				$("#profile-name").html(data.name + " " + data.lastname);
			}
		);
	},
	function (data) {
		main.user = {};
		main.view("./data/login.html");
		main.disable();
	}
);