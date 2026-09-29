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

			var properties = [
				{
					unitNo: "C-8-1",
					owner: "Foo Yoke Wai"
				},
				{
					unitNo: "C-3A-3A",
					owner: "Chia Kim Hooi"
				},
				{
					unitNo: "B-18-8",
					owner: "Heng Tee See"
				},
				{
					unitNo: "A-10-10",
					owner: "Tang So Ny"
				},
				{
					unitNo: "B-19-10",
					owner: "Tang Xiao Mi"
				},
			];


			var list1 = document.createElement('ol');
			properties.forEach(function (properties) {
				var li = document.createElement('li');
				li.textContent = `${properties.unitNo} - ${properties.owner}`;
				li.style.color = "blue";
				list1.appendChild(li);
			});

			var wrapper = document.getElementById('wrapper');
			wrapper.appendChild(list1);

		};

	</script>

</body>

</html>