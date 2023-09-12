<?php

use App\Models\Page;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

//---------------------------------------------------------------

// Вход в админ панель
Breadcrumbs::for('admin.login.form', function ($trail) {
	$trail->push('Вход в админ панель', route('admin.login.form'));
});

//---------------------------------------------------------------

// Главная
Breadcrumbs::for('admin.home', function (BreadcrumbTrail $trail) {
	$trail->push('Главная', route('admin.home'));
});

//---------------------------------------------------------------

// Главная > Администраторы
Breadcrumbs::for('admin.admins.index', function (BreadcrumbTrail $trail) {
	$trail->parent('admin.home');
	$trail->push('Администраторы', route('admin.admins.index'));
});

// Главная > Администраторы > (создание)
Breadcrumbs::for("admin.admins.create", function (BreadcrumbTrail $trail) {
	$trail->parent("admin.admins.index");
	$trail->push('Создание аминистратора', route("admin.admins.create"));
});

// Главная > Администраторы > [Администратор] (редактирование)
Breadcrumbs::for("admin.admins.edit", function (BreadcrumbTrail $trail, Admin $admin) {
	$trail->parent("admin.admins.index", $admin);
	$trail->push($admin->login . ' (редактирование)', route("admin.admins.edit", $admin));
});

//---------------------------------------------------------------

// Главная > Роли
Breadcrumbs::for('admin.roles.index', function (BreadcrumbTrail $trail) {
	$trail->parent('admin.home');
	$trail->push('Роли', route('admin.roles.index'));
});

// Главная > Роли > (создание)
Breadcrumbs::for("admin.roles.create", function (BreadcrumbTrail $trail) {
	$trail->parent("admin.roles.index");
	$trail->push('Создание роли', route("admin.roles.create"));
});

// Главная > Роли > [Роль] (редактирование)
Breadcrumbs::for("admin.roles.edit", function (BreadcrumbTrail $trail, Role $role) {
	$trail->parent("admin.roles.index", $role);
	$trail->push($role->name . ' (редактирование)', route("admin.roles.edit", $role));
});

//---------------------------------------------------------------

// Главная > Страницы
Breadcrumbs::for('admin.pages.index', function (BreadcrumbTrail $trail) {
	$trail->parent('admin.home');
	$trail->push('Страницы', route('admin.pages.index'));
});

Breadcrumbs::for("admin.pages.show", function (BreadcrumbTrail $trail, Page $page) {
	$trail->parent("admin.pages.index");
	foreach ($page->ancestors as $ancestor) {
		$trail->push($ancestor->name, route('admin.pages.show', $ancestor->slug));
	}
	$trail->push($page->name, route("admin.pages.show", $page->slug));
});

// Главная > Страницы > (создание)
Breadcrumbs::for("admin.pages.create", function (BreadcrumbTrail $trail) {
	if (request()->parentId) {
		$trail->parent("admin.pages.show", Page::findOrFail(request()->parentId));
	} else {
		$trail->parent("admin.pages.index");
	}
	$trail->push('Создание страницы', route("admin.pages.create"));
});

// Главная > Страницы > [Страница] (редактирование)
Breadcrumbs::for("admin.pages.edit", function (BreadcrumbTrail $trail, Page $page) {
	if (request()->parentId) {
		$trail->parent("admin.pages.show", Page::findOrFail(request()->parentId));
	} else {
		$trail->parent("admin.pages.index", $page);
	}
	$trail->push($page->name . ' (редактирование)', route("admin.pages.edit", $page->slug));
});

//---------------------------------------------------------------