<!DOCTYPE html>
<html>

<head>
	<title>Lab 04</title>
</head>

<body>
	<script>

		let numbers = [75.43, 18.76, 99.41, 18.78, 74.53, 86.81, 23.51, 66.17];

		let sum = 0;
		for (let i = 0; i < numbers.length; i++) {
			sum = sum + numbers[i];
		}

		let average = sum / numbers.length;

		console.log('The sum of the numbers is: ' + sum);
		console.log('The average of the numbers is: ' + average);

		for (let i = 0; i < numbers.length; i++) {
			numbers[i] = numbers[i] * 0.8683;
		}

		console.log('The new values of the numbers array are: ' + numbers);

		let customers = [
			{
				id: 'P8681',
				name: 'Foo Yoke Kai',
				email: 'fooyokekai@gmel.my',
				phone: '+60123456789',
				address: '313 Jalan Burung Tiong, 52100 Kuala Lumpur'
			},
			{
				id: 'P1234',
				name: 'John Doe',
				email: 'johndoe@example.com',
				phone: '+1234567890',
				address: '123 Main st, Anytown USA'
			},
			{
				id: 'P5678',
				name: 'Jane Smith',
				email: 'janesmith@example.com',
				phone: '+0987654321',
				address: '456 Oak st, Anytown USA'
			},
			{
				id: 'P3691',
				name: 'Alice Lee',
				email: 'alicelee@example.com',
				phone: '+4445556666',
				address: '321 Elm st, Anytown USA'
			},
			{
				id: 'P4702',
				name: 'John Joe',
				email: 'johndjoe@example.com',
				phone: '+1357924680',
				address: '999 West st, Anytown USA'
			},
		];

		for (let i = 0; i < customers.length; i++) {
			console.log('Customer ' + (i + 1) + ':');
			console.log('ID: ' + customers[i].id);
			console.log('Name: ' + customers[i].name);
			console.log('Email: ' + customers[i].email);
			console.log('Phone: ' + customers[i].phone);
			console.log('Address: ' + customers[i].address);
			console.log('------------------------------------');
		}


	</script>
</body>

</html>