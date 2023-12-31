<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Illuminate\Database\Eloquent\Model;

//==============================================================================================================================

// Макрос хлебных крошек для ресурсов
Breadcrumbs::macro('resource', function (string $name, string $title, string $fieldNameOfModelTitle = 'name', array $except = []) {

	// Главная > {Модель}
	Breadcrumbs::for("admin.{$name}.index", function (BreadcrumbTrail $trail) use ($name, $title) {
		$trail->parent('admin.home');
		$trail->push($title, route("admin.{$name}.index"));
	});

	// Главная > [ {Родительские модели} > ] {Имя модели}
	Breadcrumbs::for("admin.{$name}.show", function (BreadcrumbTrail $trail, Model $model) use ($name, $fieldNameOfModelTitle, $except) {
		$trail->parent("admin.{$name}.index");
		foreach ($model->ancestors ?? [] as $ancestor) {
			if (!in_array($ancestor->slug, $except)) {
				$trail->push($ancestor->$fieldNameOfModelTitle, route("admin.{$name}.show", $ancestor->slug));
			}
		}
		if (!in_array($model->slug, $except)) {
			$trail->push($model->$fieldNameOfModelTitle, route("admin.{$name}.show", $model->slug ?? $model->id));
		}
	});

	// Главная > [ {Родительские модели} > ] {Модель} (создание)
	Breadcrumbs::for("admin.{$name}.create", function (BreadcrumbTrail $trail, $parent = null) use ($name, $title) {
		if (optional($parent)->exists) {
			$trail->parent("admin.{$name}.show", $parent);
			$trail->push($title . ' (создание)', route("admin.{$name}.create", $parent));
		} else {
			$trail->parent("admin.{$name}.index");
			$trail->push($title . ' (создание)', route("admin.{$name}.create"));
		}
	});

	// Главная > [ {Родительские модели} > ] {Имя модели} (редактирование)
	Breadcrumbs::for("admin.{$name}.edit", function (BreadcrumbTrail $trail, Model $model) use ($name, $fieldNameOfModelTitle) {
		if ($model->parent) {
			$trail->parent("admin.{$name}.show", $model->parent);
		} else {
			$trail->parent("admin.{$name}.index", $model);
		}
		$trail->push($model->$fieldNameOfModelTitle . ' (редактирование)', route("admin.{$name}.edit", $model->slug ?? $model->id));
	});
});

//------------------------------------------------------------------------------------------------------------------------------

// Макрос хлебных крошек элемента ресурса
Breadcrumbs::macro('resourceItem', function (string $name, string $itemTitle, string $fieldNameOfModelTitle = 'name') {

	// Создание элемента ресурса
	Breadcrumbs::for("admin.{$name}.item.create", function (BreadcrumbTrail $trail, Model $menu) use ($name, $itemTitle) {
		$trail->parent("admin.{$name}.show", $menu);
		$trail->push($itemTitle . ' (создание)', route("admin.{$name}.item.create", $menu));
	});

	// Редактирование элемента ресурса
	Breadcrumbs::for("admin.{$name}.item.edit", function (BreadcrumbTrail $trail, Model $menu, Model $menuItem) use ($name, $fieldNameOfModelTitle) {
		$trail->parent("admin.{$name}.show", $menu);
		$trail->push($menuItem->$fieldNameOfModelTitle . ' (редактирование)', route("admin.{$name}.item.edit", ['menu' => $menu, 'menu_item' => $menuItem]));
	});
});


//==============================================================================================================================


// Вход в админ панель
Breadcrumbs::for('admin.login.form', function (BreadcrumbTrail $trail) {
	$trail->push('Вход в админ панель', route('admin.login.form'));
});


// Главная
Breadcrumbs::for('admin.home', function (BreadcrumbTrail $trail) {
	$trail->push('Главная', route('admin.home'));
});


Breadcrumbs::resource('admins', 'Администраторы', 'login');
Breadcrumbs::resource('roles', 'Роли');
Breadcrumbs::resource('pages', 'Страницы', 'name' , ['home']);
Breadcrumbs::resource('menu', 'Конструктор меню');
Breadcrumbs::resourceItem('menu', 'Пункт меню');