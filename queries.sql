INSERT INTO users SET date_registration = '2019-01-01 15:00:53', e_mail = 'kate@yandex.ru', name = 'kat', password = '789W789';
INSERT INTO users SET date_registration = '2019-02-01 12:00:44', e_mail = 'vasya@mail.ru', name = 'vasya', password = '123r654';
INSERT INTO users SET date_registration = '2019-02-11 13:00:00', e_mail = 'tim@mail.ru', name = 'tim', password = 'qwerty12345';
INSERT INTO projects (title, user_id) VALUES
('Входящие', 1),
('Учёба', 2),
('Работа', 2),
('Домашние дела', 1),
('Авто', 1),
('Финансы', 3),
('Спорт', 3);

INSERT INTO tasks (date_creation, date_completion, title_task, user_file, deadline, project_id, status) VALUES
( NULL, NULL, 'Собеседование в IT компании', NULL, '01.12.2019', 3, 0 ),
( NULL, NULL, 'Выполнить тестовое задание', NULL, '25.12.2019', 3, 0 ),
( NULL, NULL, 'Сделать задание первого раздела', NULL, '21.12.2019', 2, 1 ),
( NULL, NULL, 'Встреча с другом', NULL, '01.12.2019', 1, 0),
( NULL, NULL, 'Купить корм для кота', NULL, '12.02.2019', 4, 0),
( NULL, NULL, 'Заказать пиццу', NULL, NULL, 4, 0),
( NULL, NULL, 'Положить деньги на счет', NULL, '01.03.2019', 6, 0),
( NULL, NULL, 'Заплатить по кредиту', NULL, '12.02.2019', 6, 1),
( NULL, NULL, 'Тренировка', NULL, '15.02.2019', 7, 0);

/*получить список из всех проектов для одного пользователя;*/
SELECT title FROM projects WHERE user_id = 1;
/*получить список из всех задач для одного проекта;*/
SELECT title_task FROM tasks WHERE project_id = 3;
/*пометить задачу как выполненную;*/
UPDATE tasks SET status = 1 WHERE id = 6;
/*обновить название задачи по её идентификатору*/
UPDATE tasks SET title_task = 'Встреча с подругой' WHERE id = 4;
