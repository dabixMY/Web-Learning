
USE cafe_data;

INSERT INTO dishes
(name, description, price, image, category)
VALUES

-- BURGERS
('Classic Burger', 'A classic beef burger with fresh lettuce, tomato and onion.', 15.90, 'burger.png', 'Burger'),
('Cheese Burger', 'A juicy beef burger topped with melted cheese and fresh vegetables.', 17.90, 'cheeseburger.jpg', 'Burger'),
('Chicken Burger', 'Crispy chicken fillet served with lettuce, tomato and house sauce.', 16.90, 'chickenburger.jpg', 'Burger'),
('Beef Burger', 'A massive grilled beef patty served with fresh vegetables and crispy bacon.', 18.90, 'beefburger.jpg', 'Burger'),
('Fillet O'' Fish', 'Crispy fish fillet served in a soft bun with fresh lettuce and sauce.', 17.90, 'fishburger.jpg', 'Burger'),

-- MAIN COURSE
('Grilled Steak', 'Tender grilled steak served with vegetables and a side of fries.', 25.90, 'steak.png', 'Main Course'),
('Grilled Chicken Chop', 'Juicy grilled chicken chop served salad, fries and our homemade mushroom sauce.', 19.90, 'chickenchop.jpg', 'Main Course'),
('Lamb Chop', 'Tender grilled lamb chop served with potato wedges and a savoury sauce.', 23.90, 'lambchop.jpg', 'Main Course'),
('Salmon Wellington', 'Oven-baked salmon wrapped in pastry and served with potato puree.', 25.90, 'salmon.jpg', 'Main Course'),

-- PASTA
('Creamy Carbonara', 'Creamy pasta prepared with a rich sauce, cheese and savoury toppings.', 18.90, 'carbonara.png', 'Pasta'),
('Aglio Olio', 'Spaghetti tossed with garlic, olive oil, herbs and chilli flakes.', 17.90, 'aglioolio.jpg', 'Pasta'),
('Seafood Pasta', 'Pasta served with a selection of seafood in a rich and flavourful sauce.', 22.90, 'seafoodpasta.jpg', 'Pasta'),
('Pomodoro Pasta', 'Pasta served with a fresh tomato and herb sauce.', 21.90, 'pomodoropasta.jpg', 'Pasta'),
('Macaroni & Cheese Pasta', 'Creamy macaroni pasta with melted cheese.', 20.90, 'macaroni.jpg', 'Pasta'),

-- SNACKS
('French Fries', 'Crispy golden fries served as a classic side snack.', 6.90, 'fries.jpg', 'Snacks'),
('Onion Rings', 'Crispy battered onion rings served with a dipping sauce.', 6.90, 'onionrings.jpg', 'Snacks'),
('Garlic Bread', 'Toasted bread topped with garlic butter and herbs, paired with tomato sauce.', 6.90, 'garlicbread.jpg', 'Snacks'),
('Mushroom Soup', 'Warm and creamy mushroom soup prepared with fresh mushrooms.', 7.90, 'mushroomsoup.jpg', 'Snacks'),
('Crispy Nuggets', 'Golden crispy chicken nuggets served with dipping sauce.', 9.90, 'crispynugget.jpg', 'Snacks'),
('Classic Caesar Salad', 'Fresh lettuce with Caesar dressing, croutons and cheese.', 8.90, 'salad.jpg', 'Snacks'),

-- BEVERAGES
('Americano', 'Americano brewed with our Arabica coffee beans.', 8.90, 'americano.jpg', 'Beverages'),
('Latte', 'Smooth espresso blended with steamed milk.', 10.90, 'latte.jpg', 'Beverages'),
('Mocha', 'Espresso blended with chocolate and steamed milk.', 10.90, 'mocha.jpg', 'Beverages'),
('Cappuccino', 'Espresso topped with steamed milk and creamy foam.', 10.90, 'cappuccino.jpg', 'Beverages'),
('Lemon Tea', 'Refreshing tea served with a light lemon flavour.', 6.90, 'lemontea.jpg', 'Beverages'),
('Matcha Latte', 'Creamy steamed milk blended with matcha green tea.', 11.90, 'matchalatte.jpg', 'Beverages'),
('Mojito', 'A refreshing mint and lime drink.', 12.90, 'mojito.jpg', 'Beverages'),
('Earl Grey Tea', 'Fragrant black tea with a distinctive citrus aroma.', 9.90, 'earlgreytea.jpg', 'Beverages'),

-- DESSERTS
('Classic Cheesecake', 'Creamy cheesecake with a smooth texture and biscuit base.', 12.90, 'cheesecake.jpg', 'Desserts'),
('Chocolate Brownie', 'Rich and soft chocolate brownie with a deep chocolate flavour.', 10.90, 'brownie.jpg', 'Desserts'),
('Tiramisu', 'A classic coffee-flavoured dessert with creamy layers.', 13.90, 'tiramisu.jpg', 'Desserts');

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_date`, `status`) VALUES
(1, 1, 9.50, '2026-08-01 09:15:00', 'Completed'),
(2, 2, 7.30, '2026-08-05 10:30:00', 'Completed'),
(3, 3, 13.00, '2026-08-10 12:45:00', 'Pending'),
(4, 4, 3.50, '2026-08-15 08:20:00', 'Pending'),
(5, 6, 12.00, '2026-08-20 14:10:00', 'Cancelled');

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `dish_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 5, 1),
(3, 2, 3, 1),
(4, 2, 4, 1),
(5, 3, 2, 2),
(6, 3, 6, 1),
(7, 4, 1, 1),
(8, 5, 5, 1),
(9, 5, 3, 1),
(10, 5, 6, 1);

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'Peter Griffin', 'peter@gmail.com', '12345678910', '0123456789', '2026-08-23 07:35:57'),
(2, 'Lois Griffin', 'lois@gmail.com', '12345678910', '0123456790', '2026-08-23 07:35:57'),
(3, 'Megatron Griffin', 'meg@gmail.com', '12345678910', '0123456791', '2026-08-23 07:35:57'),
(4, 'Chris Griffin', 'chris@gmail.com', '12345678910', '0123456792', '2026-08-23 07:35:57'),
(5, 'Stewie Griffin', 'stewie@gmail.com', '12345678910', '0123456793', '2026-08-23 07:35:57'),
(6, 'Desmond Tay Qi Shun', 'desmond1231@1utar.my', 'testing123', '0167676767', '2026-08-23 13:07:35');
COMMIT;

INSERT INTO admin (adm_username, adm_email, adm_password, adm_phone)
VALUES (
    'MWJ',
    'mwj@plateco.com',
    '$2y$10$mLsaLYbhSWZWomGS3xWEdOQTusz82UnR19nPTFXZL//K6Te5C9/1W',
    '0179879517'
)
ON DUPLICATE KEY UPDATE
    adm_email = VALUES(adm_email),
    adm_password = VALUES(adm_password),
    adm_phone = VALUES(adm_phone);