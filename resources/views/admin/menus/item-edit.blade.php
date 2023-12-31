@extends('admin.layouts.screen')

@section('content')
	@if ($menuItem->exists)
		<form action="{{ route('admin.menu.item.update', ['menu' => $menu, 'menu_item' => $menuItem]) }}" method="post"> @method('patch')
	@else
		<form action="{{ route('admin.menu.item.store', $menu) }}" method="post">
	@endif
		@csrf

		<div class="card">
			<div class="card__header">
				<h3>{{ $menuItem->exists ? 'редактирование пункта меню' : 'Новый пункт меню' }}</h3>
				<button class="btn" type="submit">
					{{ $menuItem->exists ? 'Внести изменения' : 'Добавить' }}
					{!! $menuItem->exists ? '<i class="fa-regular fa-pen-to-square"></i>' : '<i class="fa-regular fa-rectangle-history-circle-plus"></i>' !!}
				</button>
			</div>
		</div>

		<div class="card-field">
			<div class="card-field__desc">
				<h3>Параметры пункта меню</h3>
				<p>Задайте основные параметры нового пункта меню</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">

							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Тип</span>
									<select name="type" data-choice>
										<option value="" selected disabled>Выберите тип пункта меню</option>
										@foreach ($itemTypes as $typeId => $type)
											<option value="{{ $typeId }}" {{ current_selected('type', $typeId, $menuItem->type) }} data-switcher="{{ $typeId }}">{{ $type }}</option>
										@endforeach
									</select>
								</label>
								@error('type')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column" data-switch="{{ App\Models\MenuItem::TYPE_URL }}">
								<label class="form__label">
									<span class="form__label-title _req">URL</span>
									<input class="form__input input @error('url') _error @enderror" type="text" name="url" value="{{ current_value('url', $menuItem) }}" placeholder="Введите URL">
								</label>
								@error('url')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column" data-switch="{{ App\Models\MenuItem::TYPE_ROUTE }}">
								<label class="form__label">
									<span class="form__label-title _req">Маршруты</span>
									<select name="route" data-choice>
										<option value="" selected disabled>Укажите имя маршрута</option>
										@foreach ($routes as $route)
											<option value="{{ $route }}" {{ current_selected('type', $route, $menuItem->source) }}>{{ $route }}</option>
										@endforeach
									</select>
								</label>
								@error('route')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column" data-switch="{{ App\Models\MenuItem::TYPE_PAGE }}">
								<label class="form__label">
									<span class="form__label-title _req">Страницы</span>
									<select name="page" data-choice data-search data-placeholder="Поиск...">
										<option value="" selected disabled>Укажите страницу</option>
										@foreach ($pagesTree as $childPage)
											@include('admin.pages.partials.pages-options', ['pagesTree' => $childPage->children, 'prefix' => '– '])
										@endforeach
									</select>
								</label>
								@error('page')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column" data-switch="{{ App\Models\MenuItem::TYPE_PAGE }}">
								<div class="form__single">
									<input type="checkbox" name="with_children" value="1" {{ current_checked('with_children') }} data-check data-label="Создать вместе с вложенными страницами">
								</div>
								@error('with_children')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title">Название</span>
									<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ current_value('name', $menuItem) }}" placeholder="Задайте название пункта меню">
								</label>
								@error('name')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Как открывать</span>
									<select name="open_type" data-choice>
										@foreach ($openTypes as $openTypeId => $openType)
											<option value="{{ $openTypeId }}" {{ current_selected('open_type', $openTypeId, $menuItem->open_type) }}>{{ $openType }}</option>
										@endforeach
									</select>
								</label>
								@error('open_type')<span class="form__error">{{ $message }}</span>@enderror
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="source-tabs__panel">
			<div class="card-field">
				<div class="card-field__desc">
					<h3>Расположение пункта меню</h3>
					<p>Установите расположение пункта меню в структуре меню</p>
				</div>
				<div class="card-field__field">
					<div class="form">
						<div class="form__section">
							<div class="form__row">
								<div class="form__column">
									<div class="form__label-title _req">Родительский пункт</div>
									<select class="" name="parent_id" data-choice data-search data-placeholder="Поиск...">
										@foreach ($menuTree as $childMenuItem)
											<option value="{{ $childMenuItem->id }}" {{ current_selected('parent_id', $childMenuItem->id, optional($menuItem->parent)->id) }}>Без родителя</option>
											@include('admin.menus.partials.menu-item-options', ['menuItemTree' => $childMenuItem->children, 'prefix' => '– '])
										@endforeach
									</select>
									@error('parent_id')<span class="form__error">{{ $message }}</span>@enderror
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>

	@if ($menuItem->exists)
		<div class="field field_right">
			<form action="{{ route('admin.menu.destroy', $menuItem) }}" method="post"> @csrf @method('delete')
				<button class="btn btn_small btn_danger" type="submit" onclick="return confirm('Вы уверены что хотите удалить администратора?')">Удалить меню<i class="fa-regular fa-trash-xmark"></i></button>
			</form>
		</div>
	@endif

@endsection