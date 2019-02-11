USE yeticave;

-- Добавляем категорий
INSERT INTO categories (title) VALUE ('Доски и лыжи'),('Крепления'),('Ботинки'),('Одежда'),('Инструменты'),('Разное');

-- Добавляем пользователей
INSERT INTO users (email, name, password, contacts, avatar) VALUE ('asp@gg.com', 'Tom Tenwood', 'grend3!0', '+22465156478', '/tom_w.png'),
                  ('netrop@gg.com', 'Tina Deliva', 'gwerm!f9bv','+524468749','/tinad2.png');

-- Добавляем список объявлений
INSERT INTO lots (title, description, image, category_id, price, end_time, step_rate, user_id, winner_id)
VALUES ('2014 Rossignol District Snowboard','big size','img/lot-1.jpg', 1, 10999,'2019-03-10 00:00:00',2,1,2),
       ('DC Ply Mens 2016/2017 Snowboard','for man','img/lot-2.jpg',1,159999,'2019-02-27 00:00:00',8,2,NULL),
       ('Крепления Union Contact Pro 2015 года размер L/XL','quality','img/lot-3.jpg',2,8000,'2019-03-12 00:00:00',5,2,NULL),
       ('Ботинки для сноуборда DC Mutiny Charocal','for woman','img/lot-4.jpg',3,10999,'2019-02-18 00:00:00',20,1,1),
       ('Куртка для сноуборда DC Mutiny Charocal','В отличном состоянии','img/lot-5.jpg',4,7500,'2019-02-05 00:00:00',45,2,2),
       ('Маска Oakley Canopy','Cool','img/lot-6.jpg',6,10999,'2019-02-21 00:00:00',45,1,NULL);

-- Добавляем ставки
INSERT INTO bets (rate, user_id, lot_id) VALUE
  (12000, 2, 1),
  (165200, 1, 2),
  (8920, 2, 3),
  (9290, 1, 3),
  (11000, 2, 6);



-- получаем все категрии
SELECT title FROM categories;

-- получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;
-- 1 - вариант. Более проработанный с отображением выставленной последней ставкой.
SELECT l.title Наименование_лота, l.price Начальная_цена, l.image Изображение, MAX(b.rate) Цена, c.title Категория
FROM lots l, categories c, bets b
WHERE c.id = l.category_id AND l.id = b.lot_id AND l.winner_id IS NULL GROUP BY l.id ORDER BY l.id DESC;
-- 2 - вариант
SELECT l.title, l.price, l.image, c.title
FROM lots l JOIN categories c ON l.category_id = c.id
WHERE l.end_time >= NOW() ORDER BY l.create_time DESC;


-- показать лот по его id. Получите также название категории, к которой принадлежит лот
SELECT l.id, c.title
FROM lots l, categories c
WHERE c.id = l.category_id AND l.id = '1';

--  обновить название лота по его идентификатору;
UPDATE lots SET title = '' WHERE id = '1';

-- получить список самых свежих ставок для лота по его идентификатору;
SELECT l.*, l.title, l.image, c.title, l.price, b.rate, u.name
FROM lots l, bets b, categories c, users u
WHERE b.lot_id = l.id AND l.category_id = c.id AND l.user_id = u.id AND l.id = 3 ORDER BY b.id DESC;


-- получить список самых свежих ставок для лота по его идентификатору;
SELECT *
FROM bets b
WHERE b.lot_id=1 ORDER BY b.create_time DESC;
