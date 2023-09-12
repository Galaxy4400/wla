<?php

return [

	'page_created' => [
		'type' => 'success',
		'message' => 'Страница создана',
		'extra' => 'Страница успешно удалена.',
	],

	'page_updated' => [
		'type' => 'success',
		'message' => 'Страница изменена',
		'extra' => 'Параметры страницы были успешно изменены.',
	],

	'page_deleted' => [
		'type' => 'success',
		'message' => 'Страница удалёна',
		'extra' => 'Страница, и все вложенные в неё страницы были успешно удалены',
	],

	'admin_created' => [
		'type' => 'success',
		'message' => 'Администратор создан',
		'extra' => 'Новый администратор успешно добавлен в систему. Необходимые данные для входа в административную панель были высланы на указанную почту.',
	],

	'admin_updated' => [
		'type' => 'success',
		'message' => 'Администратор изменён',
		'extra' => 'Параметры администратора были успешно изменены.',
	],

	'admin_deleted' => [
		'type' => 'success',
		'message' => 'Администратор удалён',
		'extra' => 'Администратор, и все связанные с ним данные были успешно удалены',
	],

	'role_created' => [
		'type' => 'success',
		'message' => 'Роль создана',
		'extra' => 'Новая роль успешно создана.',
	],

	'role_updated' => [
		'type' => 'success',
		'message' => 'Роль изменена',
		'extra' => 'Параметры роли были успешно изменены.',
	],

	'role_deleted' => [
		'type' => 'success',
		'message' => 'Роль удалена',
		'extra' => 'Роль успешно удалена.',
	],

	'role_delete_abort' => [
		'type' => 'warning',
		'message' => 'Невозможно удалить роль',
		'extra' => 'Роль принадлежит одному или нескольким администраторам. Прежде чем удалить роль убедитесь, что ни один администратор её не использует.',
	],

	'error' => [
		'type' => 'error',
		'message' => 'Упс... Что-то пошло не так.',
		'extra' => 'Скорей всего произошла какая-то программная ошибка. Следует обратиться к разработчику.',
	],


];