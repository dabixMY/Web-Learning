<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Agent Lists Modification</title>
</head>

<body>
	<div id="wrapper"></div>
	<script>
		window.onload = function () {

			var agents = [
				"Tham Mun Fatt",
				"Tan Chin Tiong",
				"Apple Tiong",
				"Tiong Na Na",
				"Sam Sung"
			];

			var list1 = document.createElement('ul');
			agents.forEach(function (agent) {
				var li = document.createElement('li');
				li.textContent = agent;
				li.style.color = "blue";
				list1.appendChild(li);
			});


			var newAgents = [
				"Sim Su Yi",
				"Teh Seok Leng",
				"Lau Li Ting"
			];

			newAgents.forEach(function (agent) {
				var li = document.createElement('li');
				li.textContent = agent;
				li.style.color = "red";
				list1.insertBefore(li, list1.firstChild);
			});

			var wrapper = document.getElementById('wrapper');
			wrapper.appendChild(list1);

		};

	</script>

</body>

</html>